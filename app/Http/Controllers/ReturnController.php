<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = ProductReturn::with(['product', 'order', 'orderItem', 'approver'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rma_number', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        $returns = $query->paginate(10)->withQueryString();

        $stats = [
            'pending' => ProductReturn::where('user_id', $user->id)->pending()->count(),
            'approved' => ProductReturn::where('user_id', $user->id)->approved()->count(),
            'rejected' => ProductReturn::where('user_id', $user->id)->rejected()->count(),
            'total' => ProductReturn::where('user_id', $user->id)->count(),
        ];

        return view('returns.index', compact('returns', 'stats'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        // Récupérer les commandes livrées de l'utilisateur avec leurs items
        $orders = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->with(['items.product'])
            ->orderBy('delivered_at', 'desc')
            ->get();

        // Si un order_item_id est fourni dans l'URL, pré-remplir le formulaire
        $selectedOrderItem = null;
        if ($request->has('order_item_id')) {
            $selectedOrderItem = OrderItem::with(['order', 'product'])
                ->where('id', $request->order_item_id)
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->where('status', 'delivered');
                })
                ->first();
        }

        return view('returns.create', compact('orders', 'selectedOrderItem'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'order_item_id' => 'required|exists:order_items,id',
            'quantity_returned' => 'required|integer|min:1',
            'reason' => 'required|in:defective,wrong_item,not_as_described,damaged_shipping,expired,other',
            'reason_details' => 'nullable|string|max:1000',
            'condition' => 'required|in:unopened,opened,damaged,unusable',
            'return_type' => 'required|in:refund,replacement,credit',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier que l'order_item appartient à l'utilisateur et que la commande est livrée
        $orderItem = OrderItem::with('order')
            ->where('id', $request->order_item_id)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'delivered');
            })
            ->first();

        if (!$orderItem) {
            return redirect()->back()
                ->withErrors(['order_item_id' => 'Article de commande non valide'])
                ->withInput();
        }

        // Vérifier que la quantité retournée ne dépasse pas la quantité commandée
        $alreadyReturned = ProductReturn::where('order_item_id', $orderItem->id)->sum('quantity_returned');
        $availableQuantity = $orderItem->quantity - $alreadyReturned;

        if ($request->quantity_returned > $availableQuantity) {
            return redirect()->back()
                ->withErrors(['quantity_returned' => "Quantité maximum disponible pour retour: {$availableQuantity}"])
                ->withInput();
        }

        // Gérer l'upload des images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('returns', 'public');
                $images[] = $path;
            }
        }

        // Créer la demande de retour
        ProductReturn::create([
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'user_id' => $user->id,
            'product_id' => $orderItem->product_id,
            'quantity_returned' => $request->quantity_returned,
            'reason' => $request->reason,
            'reason_details' => $request->reason_details,
            'condition' => $request->condition,
            'return_type' => $request->return_type,
            'images' => $images,
        ]);

        return redirect()->route('returns.index')
            ->with('success', 'Votre demande de retour a été soumise avec succès. Vous recevrez une réponse sous 48h.');
    }

    public function show(ProductReturn $return)
    {
        // Vérifier que le retour appartient à l'utilisateur connecté
        if ($return->user_id !== Auth::id()) {
            abort(403);
        }

        $return->load(['product', 'order', 'orderItem', 'approver']);

        return view('returns.show', compact('return'));
    }

    public function destroy(ProductReturn $return)
    {
        // Vérifier que le retour appartient à l'utilisateur connecté
        if ($return->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Seuls les retours en attente peuvent être supprimés
        if ($return->status !== 'pending') {
            return response()->json(['error' => 'Ce retour ne peut plus être supprimé'], 400);
        }

        // Supprimer les images associées
        if ($return->images) {
            foreach ($return->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $return->delete();

        return response()->json(['message' => 'Demande de retour supprimée avec succès']);
    }

    public function getOrderItems(Order $order)
    {
        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $items = $order->items()->with('product')->get()->map(function ($item) {
            $alreadyReturned = ProductReturn::where('order_item_id', $item->id)->sum('quantity_returned');
            $availableQuantity = $item->quantity - $alreadyReturned;

            return [
                'id' => $item->id,
                'product_name' => $item->product->name,
                'product_sku' => $item->product->sku,
                'quantity_ordered' => $item->quantity,
                'quantity_returned' => $alreadyReturned,
                'quantity_available' => $availableQuantity,
                'unit_price' => $item->unit_price,
                'can_return' => $availableQuantity > 0,
            ];
        });

        return response()->json($items);
    }
}
