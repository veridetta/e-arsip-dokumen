<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class GeneralCategory extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    //generate slug
    protected static function boot()
    {
        parent::boot();
        //membuat slug otomatis
        static::creating(function ($generalCategory) {
            $generalCategory->slug = Str::slug($generalCategory->name);
        });
    }
}
