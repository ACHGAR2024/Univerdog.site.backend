<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'products';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'name_product',
        'description_product',
        'price',
        'affiliation_link',
        'products_category_id',
    ];

    // Déclaration des relations

    /**
     * Définir la relation avec le modèle ProductsCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductsCategory::class, 'products_category_id');
    }

    /**
     * Obtenir les photos associées à ce produit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(ProductsPhoto::class, 'product_id');
    }
}