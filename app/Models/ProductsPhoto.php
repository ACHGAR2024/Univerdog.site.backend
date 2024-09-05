<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsPhoto extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'products_photos';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'photo_name_product',
        'product_id',
    ];

    // Déclaration des relations

    /**
     * Définir la relation avec le modèle Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}