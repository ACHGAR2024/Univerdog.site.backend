<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AvailabilityController extends Controller
{
    /**
     * Afficher une liste des disponibilités. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availabilities = Availability::all();
        return response()->json($availabilities);
    }


/**
     * Afficher une liste des disponibilités pour un professionnel spécifique.
     *
     * @param  int  $professional_id
     * @return \Illuminate\Http\Response
     */
    public function showByProfessional($professional_id)
    {
        // Valider le professional_id
        $availabilities = Availability::where('professional_id', $professional_id)->get();

        if ($availabilities->isEmpty()) {
            return response()->json(['message' => 'No availabilities found for this professional.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($availabilities);
    }
    
    /**
     * Stocker une nouvelle disponibilité.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'professional_id' => 'required|exists:professionals,id',
        ]);

        $availability = Availability::create($validatedData);
        return response()->json($availability, Response::HTTP_CREATED);
    }

    /**
     * Afficher une disponibilité spécifique.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function show(Availability $availability)
    {
        return response()->json($availability);
    }

    /**
     * Mettre à jour une disponibilité spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Availability $availability)
    {
        $validatedData = $request->validate([
            'day' => 'sometimes|required|string',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i',
            'professional_id' => 'sometimes|required|exists:professionals,id',
        ]);

        $availability->update($validatedData);
        return response()->json($availability);
    }

    /**
     * Supprimer une disponibilité spécifique.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Availability $availability)
    {
        $availability->delete();
        return response()->json("Availability deleted successfully");
    }
}