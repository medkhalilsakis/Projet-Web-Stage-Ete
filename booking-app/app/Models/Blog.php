<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
        'titre',
        'image',
        'date',
        'description',
        'categories',
        'tags',
    ];

    protected $casts = [
        'date' => 'date',
    ];
    use HasFactory;
}
