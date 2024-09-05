<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'professionals';

    // Les attributs qui sont assignables en masse .
    protected $fillable = [
        'company_name',
        'description_pro',
        'rates',
        'user_id',
        'place_id',
    ];

    // Déclaration des relations

    /**
     * Obtenir les disponibilités associées au professionnel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'professional_id');
    }

    /**
     * Obtenir les spécialités associées au professionnel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specialties()
    {
        return $this->hasMany(Specialty::class, 'professional_id');
    }

    /**
     * Obtenir les rendez-vous associés au professionnel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'professional_id');
    }

    /**
     * Définir la relation avec le modèle User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Définir la relation avec le modèle Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }
}