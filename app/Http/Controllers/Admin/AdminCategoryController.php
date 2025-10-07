<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère toutes les catégories avec leurs relations parent/enfant
        $categories = Category::with('parent', 'children')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get();

        // Organiser les catégories en arborescence
        $tree = $this->buildTree($categories);

        return view('admin.categories.index', compact('categories', 'tree'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Calcul automatique du niveau
        if ($validated['parent_id']) {
            $parent = Category::find($validated['parent_id']);
            $validated['level'] = $parent->level + 1;
        } else {
            $validated['level'] = 0;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Recalcul du niveau si le parent change
        if ($validated['parent_id']) {
            $parent = Category::find($validated['parent_id']);
            $validated['level'] = $parent->level + 1;
        } else {
            $validated['level'] = 0;
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Vérifier si la catégorie a des sous-catégories
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie contenant des sous-catégories.');
        }

        // Vérifier si la catégorie a des produits
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une catégorie contenant des produits.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * Construire l'arborescence des catégories
     */
    private function buildTree($categories, $parentId = null, $level = 0)
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $category->level = $level;
                $tree[] = $category;
                $children = $this->buildTree($categories, $category->id, $level + 1);
                $tree = array_merge($tree, $children);
            }
        }

        return $tree;
    }
}
