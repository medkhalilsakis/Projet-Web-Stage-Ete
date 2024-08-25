<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hebergement extends Model
{
    use HasFactory;

    protected $table = 'hebergements';
    protected $primaryKey = 'code_hb';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code_hb',
        'nom',
        'type',
        'adresse',
        'nbr_de_chambres',
        'description',
        'pts_forts',
        'num_tel'
    ];

    public function chambres()
    {
        return $this->hasMany(Chambre::class, 'code_hb', 'code_hb');
    }

    protected $casts = [
        'code_hb' => 'string',
        'nom' => 'string',
        'type' => 'string',
        'adresse' => 'string',
        'nbr_de_chambres' => 'integer',
        'images' => 'string',
        'description' => 'string',
        'pts_forts' => 'string',
        'num_tel' => 'string',
    ];
}
