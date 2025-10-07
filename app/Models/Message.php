<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'is_read',
        'read_at',
        'attachments',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'attachments' => 'array',
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function ($query) use ($userId1, $userId2) {
            $query->where('from_user_id', $userId1)
                ->where('to_user_id', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('from_user_id', $userId2)
                ->where('to_user_id', $userId1);
        });
    }

    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public static function getConversation($userId1, $userId2)
    {
        return self::betweenUsers($userId1, $userId2)
            ->orderBy('created_at')
            ->get();
    }

    public static function getUnreadCount($userId)
    {
        return self::where('to_user_id', $userId)
            ->unread()
            ->count();
    }
}