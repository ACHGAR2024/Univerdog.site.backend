<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Notification;



class Notification extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'notifications';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'message',
        'date_notification',
        'read',
        'user_id',
    ];

    // Déclaration des relations entre les tables

    /**
     * Définir la relation inverse avec le modèle User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}