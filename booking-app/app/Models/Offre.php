<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $primaryKey = 'id_offre';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_offre', 'titre', 'description', 'date_deb', 'date_fin', 'image'
    ];
    use HasFactory;
}
