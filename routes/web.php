<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/forgotpw', function (Request $request) {
    $credentials = $request->only('email');

    $response = Password::sendResetLink($credentials);

    return $response == Password::RESET_LINK_SENT
                ? response()->json(['status' => __($response)], 200)
                : response()->json(['email' => __($response)], 400);
});