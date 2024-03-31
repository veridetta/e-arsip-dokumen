<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'file',
        'general_category_id',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generalCategory()
    {
        return $this->belongsTo(GeneralCategory::class);
    }

    //document_requests
    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }

    //notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    //boot slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($document) {
            $document->slug = Str::slug($document->name);
        });
    }
}
