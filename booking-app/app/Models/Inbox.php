<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    // Définir le nom de la table si ce n'est pas le pluriel par défaut du modèle
    protected $table = 'inbox';

    // Définir les attributs que vous pouvez remplir via des requêtes massives
    protected $fillable = [
        'nom',
        'email',
        'message',
        'etat'
    ];

    // Si vous souhaitez que Eloquent gère les timestamps automatiquement
    public $timestamps = true; // Par défaut, il est true. Vous pouvez l'omettre si vous utilisez les timestamps.

    // Si vous utilisez des timestamps mais que vous ne souhaitez pas que Eloquent les gère automatiquement
    // vous pouvez désactiver la gestion automatique des timestamps :
    // public $timestamps = false;
}
