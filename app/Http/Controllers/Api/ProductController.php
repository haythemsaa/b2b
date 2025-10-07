<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $tenant_id = $request->user()->tenant_id;
        $perPage = $request->input('per_page', 20);

        $query = Product::where('tenant_id', $tenant_id)
            ->where('is_active', true)
            ->with(['category', 'images']);

        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Filter by stock availability
        if ($request->has('in_stock') && $request->input('in_stock') == true) {
            $query->where('stock_quantity', '>', 0);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        if (in_array($sortBy, ['name', 'price', 'stock_quantity', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products->map(function ($product) use ($request) {
                    return $this->formatProduct($product, $request->user());
                }),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'total_pages' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]
        ], 200);
    }

    /**
     * Display the specified product
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Request $request)
    {
        $tenant_id = $request->user()->tenant_id;

        $product = Product::where('tenant_id', $tenant_id)
            ->where('id', $id)
            ->with(['category', 'images'])
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $this->formatProduct($product, $request->user(), true)
            ]
        ], 200);
    }

    /**
     * Get categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request)
    {
        $tenant_id = $request->user()->tenant_id;

        $categories = Category::where('tenant_id', $tenant_id)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'description' => $category->description,
                        'products_count' => $category->products_count,
                    ];
                })
            ]
        ], 200);
    }

    /**
     * Search products
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $tenant_id = $request->user()->tenant_id;
        $query = $request->input('q');

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 422);
        }

        $products = Product::where('tenant_id', $tenant_id)
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->with(['category', 'images'])
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products->map(function ($product) use ($request) {
                    return $this->formatProduct($product, $request->user());
                }),
                'total' => $products->count()
            ]
        ], 200);
    }

    /**
     * Get featured products
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function featured(Request $request)
    {
        $tenant_id = $request->user()->tenant_id;
        $limit = $request->input('limit', 10);

        $products = Product::where('tenant_id', $tenant_id)
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with(['category', 'images'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products->map(function ($product) use ($request) {
                    return $this->formatProduct($product, $request->user());
                })
            ]
        ], 200);
    }

    /**
     * Format product data for API response
     *
     * @param Product $product
     * @param User $user
     * @param bool $detailed
     * @return array
     */
    private function formatProduct($product, $user, $detailed = false)
    {
        // Get user-specific price
        $price = $product->price;
        $customPrice = null;

        if ($user->group_id) {
            $customPriceModel = $product->customPrices()
                ->where('group_id', $user->group_id)
                ->first();

            if ($customPriceModel) {
                $customPrice = $customPriceModel->price;
                $price = $customPrice;
            }
        }

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'description' => $detailed ? $product->description : substr($product->description, 0, 150) . '...',
            'price' => (float) $price,
            'original_price' => $customPrice ? (float) $product->price : null,
            'discount_percentage' => $customPrice ? round((($product->price - $customPrice) / $product->price) * 100, 2) : null,
            'stock_quantity' => $product->stock_quantity,
            'in_stock' => $product->stock_quantity > 0,
            'is_active' => $product->is_active,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ] : null,
            'images' => $product->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->image_path),
                    'is_cover' => $image->is_cover,
                ];
            }),
            'main_image' => $product->images->where('is_cover', true)->first()
                ? asset('storage/' . $product->images->where('is_cover', true)->first()->image_path)
                : null,
        ];

        if ($detailed) {
            $data['unit'] = $product->unit;
            $data['weight'] = $product->weight;
            $data['dimensions'] = $product->dimensions;
            $data['created_at'] = $product->created_at->toISOString();
            $data['updated_at'] = $product->updated_at->toISOString();
        }

        return $data;
    }
}
