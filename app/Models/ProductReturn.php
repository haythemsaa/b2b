<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProductReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'rma_number',
        'order_id',
        'order_item_id',
        'user_id',
        'product_id',
        'quantity_returned',
        'reason',
        'reason_details',
        'condition',
        'status',
        'return_type',
        'refund_amount',
        'images',
        'admin_notes',
        'approved_at',
        'rejected_at',
        'completed_at',
        'approved_by',
    ];

    protected $casts = [
        'images' => 'array',
        'refund_amount' => 'decimal:3',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Méthodes utilitaires
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function approve($adminId, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $adminId,
            'admin_notes' => $notes,
        ]);
    }

    public function reject($adminId, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'approved_by' => $adminId,
            'admin_notes' => $notes,
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'En attente',
            'approved' => 'Approuvé',
            'rejected' => 'Refusé',
            'processing' => 'En traitement',
            'completed' => 'Terminé',
            'refunded' => 'Remboursé',
        ][$this->status] ?? $this->status;
    }

    public function getReasonLabelAttribute()
    {
        return [
            'defective' => 'Défectueux',
            'wrong_item' => 'Mauvais article',
            'not_as_described' => 'Non conforme à la description',
            'damaged_shipping' => 'Endommagé pendant l\'expédition',
            'expired' => 'Périmé',
            'other' => 'Autre',
        ][$this->reason] ?? $this->reason;
    }

    public function getConditionLabelAttribute()
    {
        return [
            'unopened' => 'Non ouvert',
            'opened' => 'Ouvert',
            'damaged' => 'Endommagé',
            'unusable' => 'Inutilisable',
        ][$this->condition] ?? $this->condition;
    }

    public function getReturnTypeLabelAttribute()
    {
        return [
            'refund' => 'Remboursement',
            'replacement' => 'Remplacement',
            'credit' => 'Avoir client',
        ][$this->return_type] ?? $this->return_type;
    }

    // Génération automatique du numéro RMA
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($return) {
            if (empty($return->rma_number)) {
                $return->rma_number = 'RMA-' . strtoupper(uniqid());
            }
        });
    }
}
