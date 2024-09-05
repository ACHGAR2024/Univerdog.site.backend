<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'specialty';  // Assurez-vous que c'est bien 'specialty'

    // Les attributs qui sont assignables en masse 
    protected $fillable = [
        'name_speciality',
        'professional_id',
    ];

    // Déclaration des relations

    /**
     * Définir la relation avec le modèle Professional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}