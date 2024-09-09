<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PhotoController;
use App\Http\Controllers\API\MessageController; 
use App\Http\Controllers\API\EventController; 
use App\Http\Controllers\API\PlaceReservationController; 
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ProfessionalController;
use App\Http\Controllers\API\AvailabilityController;
use App\Http\Controllers\API\SpecialtyController;
use App\Http\Controllers\API\DogController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\ProductsCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\DogsPhotoController;
use App\Http\Controllers\API\ProductsPhotoController;


// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/google-login', [AuthController::class, 'handleGoogleLogin']);
Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'index']);

Route::get('auth/google', [AuthController::class, 'redirectToAuth']);
Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);
Route::post('loginGoogle', [AuthController::class, 'loginWithGoogle']);

Route::post('/forgotpw/{email}', [AuthController::class, 'forgotPassword']);
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route pour récupérer l'utilisateur actuellement authentifié
Route::get('user/{user}', [UserController::class, 'indexprofil']);

// Routes des places (avec middleware auth:api pour protéger les routes nécessitant une authentification)
Route::middleware('auth:api')->group(function () {

    Route::post('places', [PlaceController::class, 'store']);
    Route::put('places/{place}', [PlaceController::class, 'update']);
    Route::delete('places/{place}', [PlaceController::class, 'destroy']);

    // Nouvelle route pour gérer les photos des places
    Route::post('places/{place}/photos', [PhotoController::class, 'store']);
    Route::put('places/{place}/photos/{photo}', [PhotoController::class, 'update']);
    Route::delete('places/{place}/photos/{photo}', [PhotoController::class, 'destroy']);
    // destroyAllPhotos : Supprimer toutes les photos d'une place
    Route::delete('places/{place}/photos', [PhotoController::class, 'destroyAllPhotos']);

    


    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);   
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Routes pour les messages
    Route::post('messages', [MessageController::class, 'store']);
    Route::post('messages/favorite', [MessageController::class, 'addFavorite']);
    Route::post('messages/report', [MessageController::class, 'report']);
    
    Route::delete('messages/{message}', [MessageController::class, 'destroy']);


    // Routes pour les événements ********************
    Route::post('events', [EventController::class, 'store']);
    Route::put('events/{event}', [EventController::class, 'update']);
    Route::delete('events/{event}', [EventController::class, 'destroy']);

    // Routes pour les réservations de places*********
    Route::post('places_reservations', [PlaceReservationController::class, 'store']);
    Route::put('places_reservations/{reservation}', [PlaceReservationController::class, 'update']);
    Route::delete('places_reservations/{reservation}', [PlaceReservationController::class, 'destroy']);


    Route::get('users', [AuthController::class, 'index']);


    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('update/{user}', [AuthController::class, 'update']);
    Route::delete('users/{user}', [AuthController::class, 'destroy']);
    
    // Route pour récupérer l'utilisateur actuellement authentifié
    Route::get('user', [UserController::class, 'currentUser']);

    // Route pour mettre à jour le role de l'utilisateur
    Route::patch('users/{id}/role', [AuthController::class, 'updateRole']);


// Routes pour les notifications
Route::post('notifications', [NotificationController::class, 'store']);
Route::put('notifications/{notification}', [NotificationController::class, 'update']);
Route::delete('notifications/{notification}', [NotificationController::class, 'destroy']);
 
// Routes pour les avis
Route::post('reviews', [ReviewController::class, 'store']);
Route::put('reviews/{review}', [ReviewController::class, 'update']);
Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

// Routes pour les professionnels
Route::post('professionals', [ProfessionalController::class, 'store']);
Route::put('professionals/{professional}', [ProfessionalController::class, 'update']);
Route::delete('professionals/{professional}', [ProfessionalController::class, 'destroy']);


// Routes pour les disponibilités
Route::post('availability', [AvailabilityController::class, 'store']);
Route::put('availability/{availability}', [AvailabilityController::class, 'update']);
Route::delete('availability/{availability}', [AvailabilityController::class, 'destroy']);

// Routes pour les spécialités
Route::post('speciality', [SpecialtyController::class, 'store']);
Route::put('speciality/{specialty}', [SpecialtyController::class, 'update']);
Route::delete('speciality/{specialty}', [SpecialtyController::class, 'destroy']);

// Routes pour les chiens
Route::post('dogs', [DogController::class, 'store']);
Route::put('dogs/{dog}', [DogController::class, 'update']);
Route::delete('dogs/{dog}', [DogController::class, 'destroy']);

// Routes pour les rendez-vous
Route::post('appointments', [AppointmentController::class, 'store']);
Route::put('appointments/{appointment}', [AppointmentController::class, 'update']);
Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy']);

// Routes pour les catégories de produits
Route::post('products-categories', [ProductsCategoryController::class, 'store']);
Route::put('products-categories/{category}', [ProductsCategoryController::class, 'update']);
Route::delete('products-categories/{category}', [ProductsCategoryController::class, 'destroy']);

// Routes pour les produits
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{product}', [ProductController::class, 'update']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);

// Routes pour les photos de chiens
Route::post('dogs-photos', [DogsPhotoController::class, 'store']);
Route::put('dogs-photos/{dogsPhoto}', [DogsPhotoController::class, 'update']);
Route::delete('dogs-photos/{dogsPhoto}', [DogsPhotoController::class, 'destroy']);


// Routes pour les photos de produits
Route::post('products-photos', [ProductsPhotoController::class, 'store']);
Route::put('products-photos/{productsPhoto}', [ProductsPhotoController::class, 'update']);
Route::delete('products-photos/{productsPhoto}', [ProductsPhotoController::class, 'destroy']);




    //Fin des routes avec middleware
    
});


    
// Routes des places accessibles publiquement
Route::get('places', [PlaceController::class, 'index']);
Route::get('places/{place}', [PlaceController::class, 'show']);
Route::get('places/category/{categoryId}', [PlaceController::class, 'getPlacesByCategory']);

Route::get('messages', [MessageController::class, 'index']);

// Routes des photos accessibles publiquement
Route::get('places/{place}/photos', [PhotoController::class, 'index']);
Route::get('places/{place}/photos/{photo}', [PhotoController::class, 'show']);

// Routes des catégories accessibles publiquement
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);


// Routes des événements accessibles publiquement*****************
Route::get('events', [EventController::class, 'index']);
Route::get('events/{event}', [EventController::class, 'show']);

// Routes des réservations accessibles publiquement***************
Route::get('places_reservations', [PlaceReservationController::class, 'index']);
Route::get('places_reservations/{reservation}', [PlaceReservationController::class, 'show']);


// Routes des notifications accessibles publiquement
Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/{notification}', [NotificationController::class, 'show']);


// Routes des avis accessibles publiquement
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{review}', [ReviewController::class, 'show']);

// Routes des professionnels accessibles publiquement
Route::get('professionals', [ProfessionalController::class, 'index']);
Route::get('professionals_pro', [ProfessionalController::class, 'index_pro']);
Route::get('professionals/{professional}', [ProfessionalController::class, 'show']);

// Routes des disponibilités accessibles publiquement
Route::get('availability', [AvailabilityController::class, 'index']);
Route::get('availability/{availability}', [AvailabilityController::class, 'show']);
Route::get('availability_pro/{professional_id}', [availabilityController::class, 'showByProfessional']);

// Routes des specialites accessibles publiquement
Route::get('speciality', [SpecialtyController::class, 'index']);
Route::get('speciality_spe', [SpecialtyController::class, 'index_spe']);
Route::get('speciality/{specialty}', [SpecialtyController::class, 'show']);

// Routes des chiens accessibles publiquement
Route::get('dogs', [DogController::class, 'index']);
Route::get('dogs/{dog}', [DogController::class, 'show']);
Route::get('dogs_user/{user_id}', [DogController::class, 'dogShowUser']);

// Routes des rendez-vous accessibles publiquement
Route::get('appointments', [AppointmentController::class, 'index']);
Route::get('appointments/{appointment}', [AppointmentController::class, 'show']);
Route::get('appointments_pro/{professional_id}', [AppointmentController::class, 'showByProfessional']);
Route::get('appointments_pro/{professional_id}/{dog_id}', [AppointmentController::class, 'showByProAndDog']);

// Routes des catégories de produits accessibles publiquement
Route::get('products-categories', [ProductsCategoryController::class, 'index']);
Route::get('products-categories/{category}', [ProductsCategoryController::class, 'show']);

// Routes des produits accessibles publiquement
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

// Routes des photos de chiens accessibles publiquement
Route::get('dogs-photos', [DogsPhotoController::class, 'index']);
Route::get('dogs-photos/{dogsPhoto}', [DogsPhotoController::class, 'show']);

// Routes des photos de produits accessibles publiquement
Route::get('products-photos', [ProductsPhotoController::class, 'index']);
Route::get('products-photos/{productsPhoto}', [ProductsPhotoController::class, 'show']);





// Routes  protégées par auth:api et admin role
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Des routes spécifiques aux admins ici
    
    
});