<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'availability';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'professional_id',
    ];

    // Déclaration des relations
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}