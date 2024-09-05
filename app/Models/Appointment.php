<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'appointments';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'date_appointment',
        'time_appointment',
        'status',
        'dog_id',
        'professional_id',
    ];

    // Déclaration des relations

    /**
     * Définir la relation avec le modèle Dog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dog()
    {
        return $this->belongsTo(Dog::class, 'dog_id');
    }

    /**
     * Définir la relation avec le modèle Professional..
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }
}