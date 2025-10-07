<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPrice;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCustomPriceController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomPrice::with(['product', 'user', 'customerGroup']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            })->orWhereHas('customerGroup', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('customer_group_id') && $request->customer_group_id) {
            $query->where('customer_group_id', $request->customer_group_id);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $customPrices = $query->orderBy('created_at', 'desc')->paginate(15);

        $products = Product::active()->get();
        $customerGroups = CustomerGroup::active()->get();

        return view('admin.custom-prices.index', compact('customPrices', 'products', 'customerGroups'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        $users = User::where('role', 'vendeur')->where('is_active', true)->orderBy('name')->get();
        $customerGroups = CustomerGroup::active()->orderBy('name')->get();

        return view('admin.custom-prices.create', compact('products', 'users', 'customerGroups'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'type' => 'required|in:user,group',
            'user_id' => 'required_if:type,user|nullable|exists:users,id',
            'customer_group_id' => 'required_if:type,group|nullable|exists:customer_groups,id',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Vérifier qu'il n'y a pas déjà un tarif pour cette combinaison
        $existingPrice = CustomPrice::where('product_id', $request->product_id);

        if ($request->type === 'user' && $request->user_id) {
            $existingPrice->where('user_id', $request->user_id);
        } elseif ($request->type === 'group' && $request->customer_group_id) {
            $existingPrice->where('customer_group_id', $request->customer_group_id);
        }

        if ($existingPrice->exists()) {
            return redirect()->back()
                ->withErrors(['error' => 'Un tarif personnalisé existe déjà pour cette combinaison.'])
                ->withInput();
        }

        $customPrice = CustomPrice::create([
            'product_id' => $request->product_id,
            'user_id' => $request->type === 'user' ? $request->user_id : null,
            'customer_group_id' => $request->type === 'group' ? $request->customer_group_id : null,
            'price' => $request->price,
            'min_quantity' => $request->min_quantity ?? 1,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'is_active' => true,
        ]);

        return redirect()->route('admin.custom-prices.index')
            ->with('success', 'Tarif personnalisé créé avec succès.');
    }

    public function show(CustomPrice $customPrice)
    {
        $customPrice->load(['product', 'user', 'customerGroup']);
        return view('admin.custom-prices.show', compact('customPrice'));
    }

    public function edit(CustomPrice $customPrice)
    {
        $products = Product::active()->orderBy('name')->get();
        $users = User::where('role', 'vendeur')->where('is_active', true)->orderBy('name')->get();
        $customerGroups = CustomerGroup::active()->orderBy('name')->get();

        return view('admin.custom-prices.edit', compact('customPrice', 'products', 'users', 'customerGroups'));
    }

    public function update(Request $request, CustomPrice $customPrice)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'type' => 'required|in:user,group',
            'user_id' => 'required_if:type,user|nullable|exists:users,id',
            'customer_group_id' => 'required_if:type,group|nullable|exists:customer_groups,id',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customPrice->update([
            'product_id' => $request->product_id,
            'user_id' => $request->type === 'user' ? $request->user_id : null,
            'customer_group_id' => $request->type === 'group' ? $request->customer_group_id : null,
            'price' => $request->price,
            'min_quantity' => $request->min_quantity ?? 1,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
        ]);

        return redirect()->route('admin.custom-prices.index')
            ->with('success', 'Tarif personnalisé mis à jour avec succès.');
    }

    public function destroy(CustomPrice $customPrice)
    {
        $customPrice->delete();

        return response()->json(['message' => 'Tarif personnalisé supprimé avec succès.']);
    }

    public function toggleStatus(CustomPrice $customPrice)
    {
        $customPrice->update(['is_active' => !$customPrice->is_active]);

        $status = $customPrice->is_active ? 'activé' : 'désactivé';

        return response()->json(['message' => "Tarif {$status} avec succès."]);
    }
}
