<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Genre;

/**
 * The root route
 */
Route::get('/', function () {
    // Fetch all genres from the database
    $genres = Genre::all();
    return view('home', compact('genres'));
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

/**
 * Route to the user's movie list.
 */
Route::get('/my-list', function () {
    return view('myList');
})->middleware('auth')->name('myList');

// POST routes for login, logout and registration
Route::post('/api/login', [AuthController::class, 'login'])->middleware('guest')->name('login.post');
Route::post('/api/register', [AuthController::class, 'register'])->middleware('guest')->name('register.post');
Route::post('/api/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout.post');

// Movie API routes
Route::middleware('auth')->group(function () {
    Route::post('/api/save-movie', [App\Http\Controllers\MovieController::class, 'saveMovie'])->name('movie.save');
    Route::get('/api/get-movies', [App\Http\Controllers\MovieController::class, 'getMovies'])->name('movie.list');
    Route::delete('/api/delete-movie/{id}', [App\Http\Controllers\MovieController::class, 'deleteMovie'])->name('movie.delete');
});

// Fallback route (route to the 404 page)
Route::fallback(function () {
    return view('errors.404');
});