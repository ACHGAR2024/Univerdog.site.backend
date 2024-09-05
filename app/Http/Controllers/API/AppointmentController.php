<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    /**
     * Afficher une liste des rendez-vous.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    /**
     * Stocker un nouveau rendez-vous.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date_appointment' => 'required|date',
            'time_appointment' => 'required|date_format:H:i',
            'status' => 'required|string|max:255',
            'dog_id' => 'required|exists:dogs,id',
            'professional_id' => 'required|exists:professionals,id',
        ]);

        $appointment = Appointment::create($validatedData);
        return response()->json($appointment, Response::HTTP_CREATED);
    }

    /**
     * Afficher un rendez-vous spécifique.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    /**
     * Mettre à jour un rendez-vous spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validatedData = $request->validate([
            'date_appointment' => 'sometimes|required|date',
            'time_appointment' => 'sometimes|required|date_format:H:i',
            'status' => 'sometimes|required|string|max:255',
            'dog_id' => 'sometimes|required|exists:dogs,id',
            'professional_id' => 'sometimes|required|exists:professionals,id',
        ]);

        $appointment->update($validatedData);
        return response()->json($appointment);
    }

    /**
     * Supprimer un rendez-vous spécifique..
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}