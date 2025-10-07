<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Informations de base
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',

            // Descriptions
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',

            // Prix
            'base_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',

            // Stock
            'stock_quantity' => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'available_date' => 'nullable|date',

            // SEO
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'ean13' => 'nullable|string|max:13',
            'upc' => 'nullable|string|max:12',

            // Images
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',

            // Dimensions
            'weight' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'depth' => 'nullable|numeric|min:0',

            // Livraison
            'delivery_time' => 'nullable|string|max:255',
            'additional_shipping_cost' => 'nullable|numeric|min:0',

            // Autres
            'condition' => 'nullable|in:new,used,refurbished',
            'position' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
            'technical_specs' => 'nullable|string',
        ]);

        // Gestion des champs booléens
        $validated['is_active'] = $request->has('is_active');
        $validated['on_sale'] = $request->has('on_sale');
        $validated['available_for_order'] = $request->has('available_for_order');
        $validated['free_shipping'] = $request->has('free_shipping');
        $validated['featured'] = $request->has('featured');
        $validated['new_arrival'] = $request->has('new_arrival');
        $validated['show_price'] = $request->has('show_price');
        $validated['customizable'] = $request->has('customizable');

        // Créer le produit
        $product = Product::create($validated);

        // Gérer l'upload des images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $position = 1;

            foreach ($images as $image) {
                // Générer un nom unique pour l'image
                $imageName = time() . '_' . $position . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Stocker l'image dans storage/app/public/products
                $imagePath = $image->storeAs('products', $imageName, 'public');

                // Créer l'enregistrement de l'image
                $product->images()->create([
                    'image_path' => $imagePath,
                    'is_cover' => $position === 1, // La première image est l'image de couverture
                    'position' => $position
                ]);

                // Si c'est la première image, définir image_url
                if ($position === 1 && !$validated['image_url']) {
                    $product->update(['image_url' => '/storage/' . $imagePath]);
                }

                $position++;
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès avec ' . ($position - 1) . ' image(s).');
    }

    public function edit(Product $product)
    {
        // Charger les images directement
        $productImages = ProductImage::where('product_id', $product->id)
            ->orderBy('position')
            ->get();

        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories', 'productImages'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            // Informations de base
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',

            // Descriptions
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',

            // Prix
            'base_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',

            // Stock
            'stock_quantity' => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'available_date' => 'nullable|date',

            // SEO
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'ean13' => 'nullable|string|max:13',
            'upc' => 'nullable|string|max:12',

            // Images
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',

            // Dimensions
            'weight' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'depth' => 'nullable|numeric|min:0',

            // Livraison
            'delivery_time' => 'nullable|string|max:255',
            'additional_shipping_cost' => 'nullable|numeric|min:0',

            // Autres
            'condition' => 'nullable|in:new,used,refurbished',
            'position' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
            'technical_specs' => 'nullable|string',
        ]);

        // Gestion des champs booléens
        $validated['is_active'] = $request->has('is_active');
        $validated['on_sale'] = $request->has('on_sale');
        $validated['available_for_order'] = $request->has('available_for_order');
        $validated['free_shipping'] = $request->has('free_shipping');
        $validated['featured'] = $request->has('featured');
        $validated['new_arrival'] = $request->has('new_arrival');
        $validated['show_price'] = $request->has('show_price');
        $validated['customizable'] = $request->has('customizable');

        $product->update($validated);

        // Gérer l'upload des nouvelles images
        $uploadedCount = 0;
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $position = $product->images()->max('position') ?? 0;

            foreach ($images as $image) {
                $position++;
                $imageName = time() . '_' . $position . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');

                $product->images()->create([
                    'image_path' => $imagePath,
                    'is_cover' => $product->images()->count() === 0, // Première image = cover
                    'position' => $position,
                    'tenant_id' => auth()->user()->tenant_id, // Ajout explicite du tenant_id
                ]);
                $uploadedCount++;
            }
        }

        $message = 'Produit mis à jour avec succès.';
        if ($uploadedCount > 0) {
            $message .= ' ' . $uploadedCount . ' image(s) ajoutée(s).';
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', $message);
    }

    public function deleteImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'Image non trouvée.'
            ], 404);
        }

        try {
            // Supprimer le fichier physique
            if (\Storage::disk('public')->exists($image->image_path)) {
                \Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image supprimée avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    public function setCoverImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return back()->with('error', 'Image non trouvée.');
        }

        // Retirer le statut cover de toutes les images
        $product->images()->update(['is_cover' => false]);

        // Définir la nouvelle image cover
        $image->update(['is_cover' => true]);

        // Mettre à jour l'image_url du produit
        $product->update(['image_url' => '/storage/' . $image->image_path]);

        return back()->with('success', 'Image principale définie avec succès.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return back()->with('success', 'Statut du produit mis à jour.');
    }

    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->update($validated);

        return back()->with('success', 'Stock mis à jour.');
    }
}