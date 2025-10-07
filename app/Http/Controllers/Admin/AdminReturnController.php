<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductReturn::with(['user', 'product', 'order', 'orderItem', 'approver'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('rma_number', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('sku', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('company_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $returns = $query->paginate(20)->withQueryString();

        $stats = [
            'pending' => ProductReturn::pending()->count(),
            'approved' => ProductReturn::approved()->count(),
            'rejected' => ProductReturn::rejected()->count(),
            'total' => ProductReturn::count(),
        ];

        $users = User::where('role', 'vendeur')->orderBy('name')->get(['id', 'name', 'company_name']);

        return view('admin.returns.index', compact('returns', 'stats', 'users'));
    }

    public function show(ProductReturn $return)
    {
        $return->load(['user', 'product', 'order', 'orderItem', 'approver']);

        return view('admin.returns.show', compact('return'));
    }

    public function approve(Request $request, ProductReturn $return)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'nullable|string|max:1000',
            'refund_amount' => 'nullable|numeric|min:0|max:' . ($return->orderItem->unit_price * $return->quantity_returned),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($return->status !== 'pending') {
            return response()->json(['error' => 'Ce retour ne peut plus être modifié.'], 400);
        }

        $return->approve(Auth::id(), $request->admin_notes);

        if ($request->refund_amount) {
            $return->update(['refund_amount' => $request->refund_amount]);
        }

        return response()->json(['message' => 'Retour approuvé avec succès.']);
    }

    public function reject(Request $request, ProductReturn $return)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($return->status !== 'pending') {
            return response()->json(['error' => 'Ce retour ne peut plus être modifié.'], 400);
        }

        $return->reject(Auth::id(), $request->admin_notes);

        return response()->json(['message' => 'Retour refusé.']);
    }

    public function updateStatus(Request $request, ProductReturn $return)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,processing,completed,refunded',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $return->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?: $return->admin_notes,
        ]);

        if ($request->status === 'completed') {
            $return->complete();
        }

        return response()->json(['message' => 'Statut mis à jour avec succès.']);
    }

    public function destroy(ProductReturn $return)
    {
        if (!in_array($return->status, ['pending', 'rejected'])) {
            return response()->json(['error' => 'Impossible de supprimer ce retour.'], 400);
        }

        $return->delete();

        return response()->json(['message' => 'Retour supprimé avec succès.']);
    }

    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:approve,reject,delete',
            'return_ids' => 'required|array',
            'return_ids.*' => 'exists:product_returns,id',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $returns = ProductReturn::whereIn('id', $request->return_ids)->get();
        $processed = 0;

        foreach ($returns as $return) {
            if ($return->status !== 'pending') {
                continue;
            }

            switch ($request->action) {
                case 'approve':
                    $return->approve(Auth::id(), $request->admin_notes);
                    $processed++;
                    break;
                case 'reject':
                    $return->reject(Auth::id(), $request->admin_notes ?: 'Refusé en lot');
                    $processed++;
                    break;
                case 'delete':
                    if (in_array($return->status, ['pending', 'rejected'])) {
                        $return->delete();
                        $processed++;
                    }
                    break;
            }
        }

        return response()->json(['message' => "$processed retours traités avec succès."]);
    }

    public function export(Request $request)
    {
        $query = ProductReturn::with(['user', 'product', 'order']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $returns = $query->get();

        $filename = 'retours_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($returns) {
            $file = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($file, [
                'N° RMA',
                'Date',
                'Vendeur',
                'Société',
                'Produit',
                'Quantité',
                'Raison',
                'Statut',
                'Type de retour',
                'Montant remboursé',
            ]);

            foreach ($returns as $return) {
                fputcsv($file, [
                    $return->rma_number,
                    $return->created_at->format('d/m/Y'),
                    $return->user->name,
                    $return->user->company_name,
                    $return->product->name,
                    $return->quantity_returned,
                    $return->reason_label,
                    $return->status_label,
                    $return->return_type_label,
                    $return->refund_amount ? number_format($return->refund_amount, 2) . ' MAD' : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
