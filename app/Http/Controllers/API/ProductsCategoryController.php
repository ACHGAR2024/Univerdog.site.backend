<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsCategoryController extends Controller
{
    /**
     * Afficher une liste des catégories de produits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductsCategory::all();
        return response()->json($categories);
    }

    /**
     * Stocker une nouvelle catégorie de produit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_product_cat' => 'required|string|max:100',
        ]);

        $category = ProductsCategory::create($validatedData);
        return response()->json($category, Response::HTTP_CREATED);
    }

    /**
     * Afficher une catégorie de produit spécifique.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsCategory $category)
    {
        return response()->json($category);
    }

    /**
     * Mettre à jour une catégorie de produit spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductsCategory $category)
    {
        $validatedData = $request->validate([
            'name_product_cat' => 'sometimes|required|string|max:100',
        ]);

        $category->update($validatedData);
        return response()->json($category);
    }

    /**
     * Supprimer une catégorie de produit spécifique.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsCategory $category)
    {
        $category->delete();
        return response()->json("Category product deleted successfully");
    }
}