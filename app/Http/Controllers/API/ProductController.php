<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Afficher une liste des produits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->get(); // Inclut les relations si nécessaire
        return response()->json($products);
    }

    /**
     * Stocker un nouveau produit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_product' => 'required|string|max:255',
            'description_product' => 'nullable|string',
            'price' => 'required|numeric',
            'affiliation_link' => 'nullable|url',
            'products_category_id' => 'required|exists:products_category,id',
        ]);

        $product = Product::create($validatedData);
        return response()->json($product, Response::HTTP_CREATED);
    }

    /**
     * Afficher un produit spécifique.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Mettre à jour un produit spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name_product' => 'sometimes|required|string|max:255',
            'description_product' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'affiliation_link' => 'nullable|url',
            'products_category_id' => 'sometimes|required|exists:products_category,id',
        ]);

        $product->update($validatedData);
        return response()->json($product);
    }

    /**
     * Supprimer un produit spécifique.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json("Product deleted successfully");
    }
}