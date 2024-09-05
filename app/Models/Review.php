<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'reviews';

    // Les attributs qui sont assignables en masse 
    protected $fillable = [
        'rating',
        'comment',
        'date_review',
        'professional_id',
    ];

    // Déclaration des relations

    /**
     * Définir la relation inverse avec le modèle Professional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}