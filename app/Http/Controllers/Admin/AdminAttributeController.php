<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::withCount('values')
            ->orderBy('sort_order')
            ->get();

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Attribute::types();
        return view('admin.attributes.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Attribute::types())),
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_required'] = $request->has('is_required');
        $validated['is_filterable'] = $request->has('is_filterable');

        Attribute::create($validated);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribut créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        $attribute->load('values');
        $types = Attribute::types();

        return view('admin.attributes.edit', compact('attribute', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Attribute::types())),
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_required'] = $request->has('is_required');
        $validated['is_filterable'] = $request->has('is_filterable');

        $attribute->update($validated);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribut mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        // Supprimer toutes les valeurs associées
        $attribute->values()->delete();

        // Supprimer l'attribut
        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribut supprimé avec succès.');
    }

    /**
     * Ajouter une valeur à un attribut
     */
    public function addValue(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $attribute->values()->create($validated);

        return back()->with('success', 'Valeur ajoutée avec succès.');
    }

    /**
     * Supprimer une valeur d'attribut
     */
    public function deleteValue(Attribute $attribute, AttributeValue $value)
    {
        if ($value->attribute_id !== $attribute->id) {
            return back()->with('error', 'Cette valeur n\'appartient pas à cet attribut.');
        }

        $value->delete();

        return back()->with('success', 'Valeur supprimée avec succès.');
    }
}
