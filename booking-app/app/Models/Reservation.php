<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'id_resv';

    protected $fillable = [
        'client',
        'date_arr',
        'date_dep',
        'nbr_adultes',
        'nbr_enfants',
        'nbr_chambres',
        'code_hb',
        'num_chambre',
        'prix_total',
    ];

    public function hebergement()
    {
        return $this->belongsTo(Hebergement::class, 'code_hb', 'code_hb');
    }

    public function chambre()
    {
        return $this->belongsTo(Chambre::class, 'num_chambre', 'num_chambre');
    }

    protected $casts = [
        'date_arr' => 'date',
        'date_dep' => 'date',
        'client' => 'string',
        'nbr_adultes' => 'integer',
        'nbr_enfants' => 'integer',
        'nbr_chambres' => 'integer',
        'prix_total' => 'double',
        'code_hb' => 'string',
        'num_chambre' => 'string',
    ];
}
