<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'vendeur');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $users = $query->with('customerGroups')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $customerGroups = CustomerGroup::active()->get();
        return view('admin.users.create', compact('customerGroups'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'preferred_language' => 'required|in:fr,ar',
            'customer_groups' => 'nullable|array',
            'customer_groups.*' => 'exists:customer_groups,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendeur',
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'preferred_language' => $request->preferred_language,
            'is_active' => true,
        ]);

        if ($request->has('customer_groups')) {
            $user->customerGroups()->sync($request->customer_groups);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Vendeur créé avec succès.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'vendeur') {
            abort(404);
        }

        $customerGroups = CustomerGroup::active()->get();
        $userGroups = $user->customerGroups->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'customerGroups', 'userGroups'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'vendeur') {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'preferred_language' => 'required|in:fr,ar',
            'customer_groups' => 'nullable|array',
            'customer_groups.*' => 'exists:customer_groups,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'preferred_language' => $request->preferred_language,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        if ($request->has('customer_groups')) {
            $user->customerGroups()->sync($request->customer_groups);
        } else {
            $user->customerGroups()->detach();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Vendeur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'vendeur') {
            abort(404);
        }

        if ($user->orders()->exists()) {
            return response()->json([
                'error' => 'Impossible de supprimer ce vendeur car il a des commandes associées.'
            ], 400);
        }

        $user->delete();

        return response()->json(['message' => 'Vendeur supprimé avec succès.']);
    }

    public function toggleStatus(User $user)
    {
        if ($user->role !== 'vendeur') {
            abort(404);
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activé' : 'désactivé';

        return response()->json(['message' => "Vendeur {$status} avec succès."]);
    }
}