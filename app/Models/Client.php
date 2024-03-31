<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'name',
        'company_name',
        'phone',
        'start_contract',
        'end_contract',
        'file',
    ];


}
