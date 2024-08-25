<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    protected $table = 'chambres';
    protected $primaryKey = 'num_chambre';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'num_chambre',
        'code_hb',
        'disponibilite',
        'prix_par_nuit', 
        'nb_personnes_max',
        'description'
    ];

    protected $casts = [
        'num_chambre' => 'string',
        'code_hb' => 'string',
        'disponibilite' => 'boolean',
        'prix_par_nuit' => 'double',  
        'nb_personnes_max' => 'integer'
    ];

    public function hebergement()
    {
        return $this->belongsTo(Hebergement::class, 'code_hb', 'code_hb');
    }

    use HasFactory;
}
