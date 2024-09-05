<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductsPhotoController extends Controller
{
    /**
     * Afficher une liste des photos de produits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsPhotos = ProductsPhoto::with('product')->get(); // Inclut les relations si nécessaire
        return response()->json($productsPhotos);
    }

    /**
     * Stocker une nouvelle photo de produit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'photo_name_product' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $file = $request->file('photo_name_product');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('products_photos', $fileName, 'public');

        $productsPhoto = new ProductsPhoto();
        $productsPhoto->product_id = $request->input('product_id');
        $productsPhoto->photo_name_product = $fileName;
        $productsPhoto->save();

        return response()->json($productsPhoto, Response::HTTP_CREATED);
    }

    /**
     * Afficher une photo de produit spécifique.
     *
     * @param  \App\Models\ProductsPhoto  $productsPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsPhoto $productsPhoto)
    {
        return response()->json($productsPhoto);
    }

    /**
     * Mettre à jour une photo de produit spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsPhoto  $productsPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductsPhoto $productsPhoto)
    {
        $request->validate([
            'photo_name_product' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('photo_name_product')) {
            // Chemin relatif de l'ancienne photo
            $oldPhotoPath = 'products_photos/' . $productsPhoto->photo_name_product;
            // Supprimer l'ancienne photo du stockage
            if (Storage::disk('public')->exists($oldPhotoPath)) {
                Storage::disk('public')->delete($oldPhotoPath);
            }
            // Enregistrer la nouvelle photo
            $file = $request->file('photo_name_product');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('products_photos', $fileName, 'public');

            $productsPhoto->photo_name_product = $fileName;
        }

        $productsPhoto->save();
        return response()->json($productsPhoto);
    }

    /**
     * Supprimer une photo de produit spécifique.
     *
     * @param  \App\Models\ProductsPhoto  $productsPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsPhoto $productsPhoto)
    {
        // Construire correctement le chemin de l'image
        $filePath = 'products_photos/' . $productsPhoto->photo_name_product;

        // Supprimer la photo du stockage
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Supprimer l'enregistrement de la base de données
        $productsPhoto->delete();

        return response()->json(['message' => 'Photo deleted successfully']);
    }
}