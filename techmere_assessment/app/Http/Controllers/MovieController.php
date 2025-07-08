<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserMovie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{    
    /**
     * Method to save a movie added by a user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveMovie(Request $request) {      
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'year' => 'nullable|integer|min:1900|max:2030',
            'watched' => 'boolean',
            'rating' => 'nullable|integer|min:1|max:10'
        ]);
        
        // Get the movie data from the request      
        $title = $validatedData['title'];
        $description = $validatedData['description'] ?? null;
        $genres = $validatedData['genres'] ?? [];
        $year = $validatedData['year'] ?? null;
        $watched = $validatedData['watched'] ?? false;
        $rating = $validatedData['rating'] ?? null;
        
        try {
            // Create the movie record
            $userMovie = UserMovie::create([
                'user_id' => Auth::id(),
                'title' => $title,
                'description' => $description,
                'year' => $year,
                'status' => $watched ? 'watched' : 'want_to_watch',
                'rating' => $watched ? $rating : null,
            ]);
            
            // Attach genres if provided
            if (!empty($genres)) {
                $userMovie->genres()->attach($genres);
            }
            
            return response()->json([
                'message' => 'Movie saved successfully',
                'movie' => [
                    'id' => $userMovie->id,
                    'title' => $userMovie->title,
                    'status' => $userMovie->status
                ]
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Error saving movie', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'error' => 'Failed to save movie. Please try again.'
            ], 500);
        }
    }

    /**
     * Method to get the user's movies
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMovies() {

        Log::info("Retrieving user movies", [
            'user_id' => Auth::id()
        ]);
        try {
            $movies = UserMovie::where('user_id', Auth::id())
                ->with('genres')
                ->orderBy('created_at', 'desc')
                ->get();
            
            Log::info('Retrieved user movies', [
                'user_id' => Auth::id(),
                'movie_count' => $movies->count()
            ]);
            
            return response()->json([
                'movies' => $movies
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error retrieving movies', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            
            return response()->json([
                'error' => 'Failed to retrieve movies'
            ], 500);
        }
    }

    public function deleteMovie($id) {
        Log::info("Deleting movie", [
            'user_id' => Auth::id(),
            'movie_id' => $id
        ]);
        
        try {
            $movie = UserMovie::where('user_id', Auth::id())->findOrFail($id);
            $movie->delete();
            
            Log::info('Movie deleted successfully', [
                'user_id' => Auth::id(),
                'movie_id' => $id
            ]);
            
            return response()->json([
                'message' => 'Movie deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error deleting movie', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'movie_id' => $id
            ]);
            
            return response()->json([
                'error' => 'Failed to delete movie'
            ], 500);
        }
    }
}
