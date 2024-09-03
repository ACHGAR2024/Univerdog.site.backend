<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 
use Google_Client;

use Tymon\JWTAuth\Facades\JWTAuth;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Session\Middleware\StartSession;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Password as PasswordFacade;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function loginWithGoogle(Request $request)
    {
        $email = $request->input('email');
        $googleId = $request->input('google_id');
    
        // Rechercher l'utilisateur par email
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            // L'utilisateur n'existe pas, retourner une erreur 404 (Not Found)
        return response()->json(['error' => 'Compte inexistant'], 404);
        }
    
        // Vérifier si l'utilisateur se connecte via Google
        if ($user->google_id === $googleId) {
            // Authentifier l'utilisateur et générer un token
            $tokenResult = $user->createToken('Personal Access Token'); // Correction ici
            $token = $tokenResult->accessToken; // Accéder au token correctement
    
            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 3600
            ]);
        }
    
        return response()->json(['message' => 'Authentification Google échouée'], 401);
    }
    
    public function redirectToAuth()
    {
        return response()->json([
            'url' => Socialite::driver('google')
                         ->stateless()
                         ->redirect()
                         ->getTargetUrl(),
        ]);
    }
    

    public function handleAuthCallback()
    {
        try {
            $socialiteUser = Socialite::driver('google')
                ->stateless()
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }
    
        // Find or create the user
        $user = User::query()->firstOrCreate(
            ['email' => $socialiteUser->getEmail()],
            [
                'email_verified_at' => now(),
                'name' => $socialiteUser->getName(),
                'google_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
                'password' => bcrypt('temporary_password'), // Adding a temporary password
            ]
        );
    
        // Log in the user
        Auth::login($user);
    
        // Generate the token
        $tokenResult = $user->createToken('google-token');
        $token = $tokenResult->accessToken; // Correctly accessing the token
    
        // Redirect to /dashboard with the token in a query parameter
        return redirect('http://localhost:5173/login');

       /*return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);*/
    }
    


    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json(['users' => $users]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json(['message' => 'User successfully registered', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

// app/Http/Controllers/AuthController.php

public function handleGoogleLogin(Request $request)
{
    // Validation des données entrantes
    $request->validate([
        'tokenId' => 'required|string',
    ]);

    // Initialiser le client Google
    $client = new Google_Client(['client_id' => config('services.google.client_id')]);
    $payload = $client->verifyIdToken($request->tokenId);

    if ($payload) {
        // Trouver ou créer un utilisateur basé sur le profil Google
        $user = User::firstOrCreate(
            ['email' => $payload['email']],
            ['name' => $payload['name']]
        );

        // Générez et retournez un token d'accès
        return response()->json([
            'token' => $user->createToken('authToken')->accessToken
        ]);
    } else {
        return response()->json(['error' => 'Invalid token'], 401);
    }
}




    
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'User successfully logged out'])->withHeaders(['Location' => 'http://localhost:5173']);
      
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    public function update(Request $request, User $user)
{
    // Récupère l'utilisateur authentifié
    $authenticatedUser = Auth::user();

    // Vérifie que l'utilisateur authentifié peut effectuer cette action
    if ($authenticatedUser->id !== $user->id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Sauvegarde temporaire de l'ancien chemin de l'image
    $file_temp = $user->image;

    // Validation des données reçues
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'password' => 'sometimes|string|min:6',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Taille maximale de 2MB pour les images
    ]);

    // Préparation des données à mettre à jour, en excluant potentiellement l'image
    $input = $request->except('image', 'password');

    // Si un nouveau mot de passe est fourni, le hasher et l'ajouter aux données à sauvegarder
    if ($request->filled('password')) {
        $input['password'] = bcrypt($request->password);
    }

    // Si une nouvelle image est téléchargée, la traiter et la sauvegarder
    if ($request->hasFile('image')) {
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
        $path = $request->file('image')->storeAs('images', $filename, 'public');

        // Supprimer l'ancienne image si elle existe
        if ($file_temp) {
            Storage::disk('public')->delete('images/' . basename($file_temp));
        }

        // Mettre à jour le chemin de la nouvelle image dans les données à sauvegarder
        $input['image'] = '/storage/images/' . $filename;
    }

    // Mettre à jour l'utilisateur avec les nouvelles données
    $user->update($input);

    // Construire l'URL de l'image mise à jour
    if (isset($input['image'])) {
        $imageUrl = asset($input['image']);
        // Ajouter l'URL de l'image à l'objet utilisateur mis à jour
        $user->image = $imageUrl;
    }

    // Retourner une réponse JSON avec l'utilisateur mis à jour et un message de succès
    $responseData = [
        'user' => $user,
        'message' => 'User updated successfully'
    ];

    return response()->json($responseData, 200);
}

public function updateAdditionalInfo(Request $request, User $user)
    {
        // Récupère l'utilisateur authentifié
        $authenticatedUser = Auth::user();

        // Vérifie que l'utilisateur authentifié peut effectuer cette action
        if ($authenticatedUser->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validation des nouvelles données reçues
        $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'address' => 'sometimes|string|nullable',
            'postal_code' => 'sometimes|string|max:8|nullable',
            'phone' => 'sometimes|string|max:20|nullable',
        ]);

        // Mise à jour des informations supplémentaires de l'utilisateur
        $input = $request->only('first_name', 'address', 'postal_code', 'phone');
        $user->update($input);

        // Retourner une réponse JSON avec l'utilisateur mis à jour et un message de succès
        return response()->json([
            'user' => $user,
            'message' => 'Informations mises à jour avec succès'
        ], 200);
    }
    public function destroy(User $user)
    {
        $authenticatedUser = Auth::user();
    
        // Vérifiez si l'utilisateur authentifié est un administrateur
        if ($authenticatedUser->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Supprimer l'utilisateur
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully']);
    }
    
   // Ajoutez cette méthode dans votre AuthController
public function updateRole(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    // Vérifiez si l'utilisateur est autorisé à effectuer cette action
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $validator = Validator::make($request->all(), [
        'role' => 'required|string|in:user,agent'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user->role = $request->role;
    $user->save();

    return response()->json(['message' => 'Role updated successfully', 'user' => $user]);
}
 
        
public function forgotPassword(Request $request, $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email non trouvé.'], 404);
        }

        // Générer un token unique
        $token = Str::random(60);

        // Enregistrer le token dans la base de données
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Vous pouvez ici envoyer un email à l'utilisateur avec le lien de réinitialisation
        // contenant le token. 
        // Exemple : http://votre-domaine.com/reset-password/{token}
        Mail::to($email)->send(new ResetPasswordMail($token, $email));

        return response()->json(['message' => 'Un email de réinitialisation de mot de passe a été envoyé. valable pour 60 minutes.', 'token' => $token], 200);
    }

    
}