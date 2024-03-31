<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DocumentRequest extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'document_id',
        'user_id',
        'expired',
        'message',
        'status',
        'response',
        'to',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //to dengan user
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }
}
