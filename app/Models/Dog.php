<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle 
    protected $table = 'dogs';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'name_dog',
        'breed',
        'birth_date',
        'weight',
        'sex',
        'medical_info',
        'qr_code',
        'user_id',
    ];

    // Déclaration des relations

    /**
     * Obtenir les rendez-vous associés au chien.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'dog_id');
    }

    /**
     * Obtenir les photos associées au chien.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(DogPhoto::class, 'dog_id');
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
}