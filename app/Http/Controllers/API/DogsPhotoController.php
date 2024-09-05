<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DogsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DogsPhotoController extends Controller
{
    /**
     * Afficher une liste des photos de chiens.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dogsPhotos = DogsPhoto::with('dog')->get(); // Inclut les relations si nécessaire
        return response()->json($dogsPhotos);
    }

    /**
     * Stocker une nouvelle photo de chien.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'dog_id' => 'required|exists:dogs,id',
            'photo_name_dog' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $file = $request->file('photo_name_dog');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('dogs_photos', $fileName, 'public');

        $dogsPhoto = new DogsPhoto();
        $dogsPhoto->dog_id = $request->input('dog_id');
        $dogsPhoto->photo_name_dog = $fileName;
        $dogsPhoto->save();

        return response()->json($dogsPhoto, Response::HTTP_CREATED);
    }

    /**
     * Afficher une photo de chien spécifique.
     *
     * @param  \App\Models\DogsPhoto  $dogsPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(DogsPhoto $dogsPhoto)
    {
        return response()->json($dogsPhoto);
    }

    /**
     * Mettre à jour une photo de chien spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DogsPhoto  $dogsPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DogsPhoto $dogsPhoto)
    {
        $request->validate([
            'photo_name_dog' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('photo_name_dog')) {
            // Chemin relatif de l'ancienne photo
            $oldPhotoPath = 'dogs_photos/' . $dogsPhoto->photo_name_dog;

            // Supprimer l'ancienne photo du stockage
            if (Storage::disk('public')->exists($oldPhotoPath)) {
                Storage::disk('public')->delete($oldPhotoPath);
            }

            // Enregistrer la nouvelle photo
            $file = $request->file('photo_name_dog');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dogs_photos', $fileName, 'public');

            $dogsPhoto->photo_name_dog = $fileName;
        }

        $dogsPhoto->save();
        return response()->json($dogsPhoto);
    }

    /**
     * Supprimer une photo de chien spécifique.
     *
     * @param  \App\Models\DogsPhoto  $dogsPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(DogsPhoto $dogsPhoto)
    {
        // Chemin relatif de la photo à supprimer
        $filePath = 'dogs_photos/' . $dogsPhoto->photo_name_dog;

        // Supprimer la photo du stockage
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $dogsPhoto->delete();

        return response()->json(['message' => 'Photo deleted successfully']);
    }
}