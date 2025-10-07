<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::active()->root()->with('children')->orderBy('sort_order')->get();

        $query = Product::forUserGroup($user)->with(['category', 'customPrices']);

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('in_stock') && $request->in_stock) {
            $query->inStock();
        }

        // Appliquer filtrage par groupe utilisateur si pas admin
        if ($user->role === 'vendeur' && $user->customerGroups->count() > 0) {
            // Ajouter information sur les groupes de l'utilisateur pour debug
            $userGroupNames = $user->customerGroups->pluck('name')->join(', ');
        }

        $products = $query->paginate(12);

        $products->getCollection()->transform(function ($product) use ($user) {
            $product->user_price = $product->getPriceForUser($user);
            return $product;
        });

        return view('products.index', compact('products', 'categories'));
    }

    public function category(Category $category, Request $request)
    {
        $user = Auth::user();

        $query = Product::forUserGroup($user)
            ->where('category_id', $category->id)
            ->with(['category', 'customPrices']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12);

        $products->getCollection()->transform(function ($product) use ($user) {
            $product->user_price = $product->getPriceForUser($user);
            return $product;
        });

        return view('products.category', compact('products', 'category'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $user = Auth::user();
        $product->user_price = $product->getPriceForUser($user);

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get()
            ->map(function ($relatedProduct) use ($user) {
                $relatedProduct->user_price = $relatedProduct->getPriceForUser($user);
                return $relatedProduct;
            });

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('q', '');

        if (empty($search)) {
            return response()->json([]);
        }

        $products = Product::forUserGroup($user)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'sku', 'base_price', 'price', 'images']);

        $results = $products->map(function ($product) use ($user) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->getPriceForUser($user),
                'image' => $product->first_image,
                'url' => route('products.show', $product->sku),
            ];
        });

        return response()->json($results);
    }
}