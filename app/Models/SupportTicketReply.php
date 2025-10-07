<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    protected $fillable = [
        'ticket_id', 'user_id', 'message', 'is_internal', 'attachments'
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'attachments' => 'array'
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}