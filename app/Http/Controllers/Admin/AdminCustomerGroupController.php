<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCustomerGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerGroup::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $groups = $query->withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        $users = User::where('role', 'vendeur')->where('is_active', true)->get();
        return view('admin.groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:customer_groups',
            'description' => 'nullable|string|max:500',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $group = CustomerGroup::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage ?? 0,
            'is_active' => true,
        ]);

        if ($request->has('users')) {
            $group->users()->sync($request->users);
        }

        return redirect()->route('admin.groups.index')
            ->with('success', 'Groupe de clients créé avec succès.');
    }

    public function show(CustomerGroup $group)
    {
        $group->load(['users', 'customPrices.product']);
        return view('admin.groups.show', compact('group'));
    }

    public function edit(CustomerGroup $group)
    {
        $users = User::where('role', 'vendeur')->where('is_active', true)->get();
        $groupUsers = $group->users->pluck('id')->toArray();
        return view('admin.groups.edit', compact('group', 'users', 'groupUsers'));
    }

    public function update(Request $request, CustomerGroup $group)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:customer_groups,name,' . $group->id,
            'description' => 'nullable|string|max:500',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage ?? 0,
        ]);

        if ($request->has('users')) {
            $group->users()->sync($request->users);
        } else {
            $group->users()->detach();
        }

        return redirect()->route('admin.groups.index')
            ->with('success', 'Groupe de clients mis à jour avec succès.');
    }

    public function destroy(CustomerGroup $group)
    {
        if ($group->users()->exists()) {
            return response()->json([
                'error' => 'Impossible de supprimer ce groupe car il contient des vendeurs.'
            ], 400);
        }

        if ($group->customPrices()->exists()) {
            return response()->json([
                'error' => 'Impossible de supprimer ce groupe car il a des tarifs personnalisés associés.'
            ], 400);
        }

        $group->delete();

        return response()->json(['message' => 'Groupe de clients supprimé avec succès.']);
    }

    public function toggleStatus(CustomerGroup $group)
    {
        $group->update(['is_active' => !$group->is_active]);

        $status = $group->is_active ? 'activé' : 'désactivé';

        return response()->json(['message' => "Groupe {$status} avec succès."]);
    }
}
