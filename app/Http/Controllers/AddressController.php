<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Afficher toutes les adresses de l'utilisateur
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('addresses.create');
    }

    /**
     * Sauvegarder une nouvelle adresse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:2',
            'is_default' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        // Si cette adresse est définie comme par défaut, retirer le flag des autres
        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        $validated['user_id'] = auth()->id();
        $address = Address::create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Adresse ajoutée avec succès');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Address $address)
    {
        // Vérifier que l'adresse appartient à l'utilisateur
        $this->authorize('update', $address);

        return view('addresses.edit', compact('address'));
    }

    /**
     * Mettre à jour une adresse
     */
    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:2',
            'is_default' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        // Si cette adresse est définie comme par défaut, retirer le flag des autres
        if ($request->is_default) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Adresse mise à jour avec succès');
    }

    /**
     * Supprimer une adresse
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Adresse supprimée avec succès');
    }

    /**
     * Définir une adresse comme par défaut
     */
    public function setDefault(Address $address)
    {
        $this->authorize('update', $address);

        // Retirer le flag par défaut de toutes les adresses
        auth()->user()->addresses()->update(['is_default' => false]);

        // Définir cette adresse comme par défaut
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Adresse définie comme par défaut'
        ]);
    }
}
