<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Retourner les informations de l'utilisateur authentifié
        return response()->json([
            'user' => Auth::user(),
        ]);
    }
}