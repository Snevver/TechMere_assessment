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

    /**
     * Method to delete a movie
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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
    
    /**
     * Method to update a movie
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMovie(Request $request, $id) {
        Log::info("Updating movie", [
            'user_id' => Auth::id(),
            'movie_id' => $id
        ]);
        
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
        
        try {
            $movie = UserMovie::where('user_id', Auth::id())->findOrFail($id);
            
            // Update the movie record
            $movie->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'year' => $validatedData['year'] ?? null,
                'status' => $validatedData['watched'] ? 'watched' : 'want_to_watch',
                'rating' => $validatedData['watched'] ? ($validatedData['rating'] ?? null) : null,
            ]);
            
            if (isset($validatedData['genres'])) {
                $movie->genres()->sync($validatedData['genres']);
            }
            
            Log::info('Movie updated successfully', [
                'user_id' => Auth::id(),
                'movie_id' => $id
            ]);
            
            return response()->json([
                'message' => 'Movie updated successfully',
                'movie' => [
                    'id' => $movie->id,
                    'title' => $movie->title,
                    'status' => $movie->status
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error updating movie', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'movie_id' => $id
            ]);
            
            return response()->json([
                'error' => 'Failed to update movie'
            ], 500);
        }
    }

    /**
     * Search for movies using the IMDB API and paginate results.
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function searchMovies(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1);
        $mediaType = $request->input('media_type', 'all');

        if (!$query) {
            return view('overview', ['movies' => [], 'pagination' => null]);
        }

        $apiUrl = "https://rest.imdbapi.dev/v2/search/titles?query=" . urlencode($query) . "&page=" . $page;

        Log::info('Fetching movies from API', [
            'api_url' => $apiUrl,
            'media_type' => $mediaType
        ]);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($apiUrl);
            $data = json_decode($response->getBody()->getContents(), true);

            $allMovies = $data['titles'] ?? [];
            
            // Filter by media type if specified
            if ($mediaType !== 'all') {
                $allMovies = array_values(array_filter($allMovies, function($movie) use ($mediaType) {
                    return isset($movie['type']) && $movie['type'] === $mediaType;
                }));
            }
            
            $totalResults = count($allMovies);
            $offset = ($page - 1) * 5;
            
            // Reset page if offset is beyond total results
            if ($offset >= $totalResults && $totalResults > 0) {
                $page = ceil($totalResults / 5);
                $offset = ($page - 1) * 5;
            }
            
            $movies = array_slice($allMovies, $offset, 5);

            $pagination = [
                'current_page' => $page,
                'total_pages' => ceil($totalResults / 5),
                'query' => $query
            ];

            return view('overview', ['movies' => $movies, 'pagination' => $pagination]);
        } catch (\Exception $e) {
            Log::error("Error fetching movies: " . $e->getMessage());
            return view('overview', ['movies' => [], 'pagination' => null]);
        }
    }
}
