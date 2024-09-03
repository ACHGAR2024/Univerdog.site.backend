<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator; 

class PasswordResetController extends Controller
{
    public function showResetForm($token)
{
    // Vérifiez que le token est valide
    $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();

    if (!$resetToken) {
        return abort(404);
    }

    return view('auth.reset_password', ['token' => $token, 'email' => request()->query('email')]);
}


public function resetPassword(Request $request)
{
    // Valider les données du formulaire
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
        'token' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Vérifier le token
    $passwordReset = DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->where('token', $request->token)
                        ->first();

    if (!$passwordReset) {
        return response()->json(['error' => 'Token invalide ou expiré'], 400);
    }

    // Récupérer l'utilisateur
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['error' => 'Utilisateur non trouvé'], 404);
    }

    // Mettre à jour le mot de passe
    $user->password = bcrypt($request->password);
    $user->save();

    // Supprimer le token de réinitialisation pour éviter les réutilisations
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    //return response()->json(['message' => 'Mot de passe réinitialisé avec succès.'], 200);
    
// Rediriger vers la page de connexion avec un message de succès
return redirect('http://localhost:5174/login')->with('status', 'Mot de passe réinitialisé avec succès.');

}


}