<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'to',
        'from',
        'content',
        'is_read',
        'document_id',
        'chat_room_id',
    ];

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }

}
