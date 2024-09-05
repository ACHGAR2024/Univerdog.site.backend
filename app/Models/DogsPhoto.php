<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DogsPhoto extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'dogs_photos';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'dog_id',
        'photo_name_dog',
    ];

    // Déclaration des relations

    /**
     * Définir la relation inverse avec le modèle Dog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dog_id');
    }
}