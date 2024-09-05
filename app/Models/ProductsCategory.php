<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    use HasFactory;

    // Nom de la table associée au modèle
    protected $table = 'products_category';

    // Les attributs qui sont assignables en masse
    protected $fillable = [
        'name_product_cat',
    ];

    // Déclaration des relations

    /**
     * Obtenir les produits associés à cette catégorie de produits.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'products_category_id');
    }
}