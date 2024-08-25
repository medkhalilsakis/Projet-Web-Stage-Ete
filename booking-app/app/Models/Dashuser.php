<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashuser extends Model
{

    protected $fillable = [
        'nom',
        'prenom',
        'date_naiss',
        'IDCARD',
        'nationalite',
        'email',
        'password',
        'genre',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_naiss' => 'date',
    ];

    use HasFactory;
}

