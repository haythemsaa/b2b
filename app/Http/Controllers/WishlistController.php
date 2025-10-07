<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's wishlist
     */
    public function index()
    {
        $user = Auth::user();

        // Get or create default wishlist
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id
        ], [
            'name' => 'Ma liste de souhaits'
        ]);

        $wishlistItems = $wishlist->items()->with('product')->get();

        return view('wishlist.index', compact('wishlist', 'wishlistItems'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = Auth::user();

        // Get or create default wishlist
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id
        ], [
            'name' => 'Ma liste de souhaits'
        ]);

        // Check if item already exists
        $exists = WishlistItem::where('wishlist_id', $wishlist->id)
                             ->where('product_id', $request->product_id)
                             ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ce produit est déjà dans votre liste de souhaits.'
            ], 400);
        }

        // Add item to wishlist
        WishlistItem::create([
            'wishlist_id' => $wishlist->id,
            'product_id' => $request->product_id,
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté à la liste de souhaits.',
            'count' => $wishlist->items()->count()
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function remove($itemId)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->first();

        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Liste de souhaits non trouvée.'
            ], 404);
        }

        $item = WishlistItem::where('wishlist_id', $wishlist->id)
                           ->where('id', $itemId)
                           ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Article non trouvé.'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produit retiré de la liste de souhaits.',
            'count' => $wishlist->items()->count()
        ]);
    }

    /**
     * Move product from wishlist to cart
     */
    public function moveToCart($itemId)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->first();

        if (!$wishlist) {
            return redirect()->back()->with('error', 'Liste de souhaits non trouvée.');
        }

        $item = WishlistItem::where('wishlist_id', $wishlist->id)
                           ->where('id', $itemId)
                           ->first();

        if (!$item) {
            return redirect()->back()->with('error', 'Article non trouvé.');
        }

        // Add to cart (using CartController logic)
        $cartController = new \App\Http\Controllers\CartController();
        $request = new Request([
            'product_id' => $item->product_id,
            'quantity' => 1
        ]);

        $cartController->add($request);

        // Remove from wishlist
        $item->delete();

        return redirect()->route('cart.index')
                       ->with('success', 'Produit déplacé vers le panier.');
    }

    /**
     * Get wishlist count
     */
    public function getCount()
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->first();

        if (!$wishlist) {
            return response()->json(['count' => 0]);
        }

        $count = $wishlist->items()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->first();

        if ($wishlist) {
            $wishlist->items()->delete();
        }

        return redirect()->route('wishlist.index')
                       ->with('success', 'Liste de souhaits vidée.');
    }
}
