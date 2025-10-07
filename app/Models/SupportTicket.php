<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'ticket_number', 'tenant_id', 'user_id', 'assigned_to', 'subject',
        'description', 'priority', 'status', 'category', 'resolved_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id');
    }

    public static function generateTicketNumber()
    {
        $year = date('Y');
        $lastTicket = self::where('ticket_number', 'like', "TKT-{$year}-%")->latest()->first();
        $number = $lastTicket ? ((int) substr($lastTicket->ticket_number, -5)) + 1 : 1;
        return sprintf("TKT-%s-%05d", $year, $number);
    }
}