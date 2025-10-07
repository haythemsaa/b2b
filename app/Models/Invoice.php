<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id', 'subscription_id', 'order_id', 'invoice_number', 'subtotal', 'tax', 'total',
        'status', 'invoice_date', 'issue_date', 'due_date', 'paid_date', 'paid_at', 'sent_at', 'notes'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'paid_at' => 'datetime',
        'sent_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function generateInvoiceNumber()
    {
        $year = date('Y');
        $lastInvoice = self::where('invoice_number', 'like', "INV-{$year}-%")->latest()->first();
        $number = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;
        return sprintf("INV-%s-%04d", $year, $number);
    }
}