<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/**
 * The root route
 */
Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

/**
 * Route to the login page.
 */
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

/**
 * Route to the register page.
 */
Route::get('/register', function () {
    return view('register');
})->name('register');

// POST routes for login, logout and registration
Route::post('/api/login', [AuthController::class, 'login'])->middleware('guest')->name('login.post');
Route::post('/api/register', [AuthController::class, 'register'])->middleware('guest')->name('register.post');
Route::post('/api/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout.post');

// Fallback route (route to the 404 page)
Route::fallback(function () {
    return view('errors.404');
});