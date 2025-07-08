// CSRF token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Function to load movies from the API
async function loadMovies() {
    const loading = document.getElementById('loading');
    const moviesContainer = document.getElementById('movies-container');
    const emptyState = document.getElementById('empty-state');
    const errorState = document.getElementById('error-state');
    
    // Show loading state
    loading.classList.remove('hidden');
    moviesContainer.classList.add('hidden');
    emptyState.classList.add('hidden');
    errorState.classList.add('hidden');
    
    try {

        // Fetch movies from the database
        const response = await fetch('/api/get-movies', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        // Hide loading
        loading.classList.add('hidden');
        
        if (data.movies && data.movies.length > 0) {
            // Show movies
            displayMovies(data.movies);
            moviesContainer.classList.remove('hidden');
        } else {
            // Show empty state
            emptyState.classList.remove('hidden');
        }
        
    } catch (error) {
        console.error('Error loading movies:', error);
        loading.classList.add('hidden');
        errorState.classList.remove('hidden');
    }
}

// Function to display movies in the grid
function displayMovies(movies) {
    const container = document.getElementById('movies-container');
    container.innerHTML = '';
    
    movies.forEach(movie => {
        const movieCard = createMovieCard(movie);
        container.appendChild(movieCard);
    });
}

// Function to create a movie card element
function createMovieCard(movie) {
    const card = document.createElement('div');
    card.className = 'bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow flex flex-col h-full';
    
    // Format the genres
    const genresHtml = movie.genres?.map(genre => 
        `<span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold mr-2 mb-1 px-2.5 py-0.5 rounded">${genre.name}</span>`
    ).join('') || '';
    
    // Format the status
    const statusText = movie.status === 'watched' ? 'Watched' : 'Want to Watch';
    const statusColor = movie.status === 'watched' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400';
    
    // Format the rating
    const ratingHtml = movie.rating ? `<p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Rating: ${movie.rating}/5 ⭐</p>` : '';

    card.innerHTML = `
        <div class="flex-grow">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">${movie.title}</h2>
            <p class="text-sm ${statusColor} mb-1 font-medium">Status: ${statusText}</p>
            ${movie.description ? `<div class="max-h-20 overflow-y-auto mb-4"><p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">${movie.description}</p></div>` : ''}
            ${movie.year ? `<p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Year: ${movie.year}</p>` : ''}
            ${ratingHtml}
            ${genresHtml ? `<div class="mt-3"><p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Genres:</p><div class="max-h-16 overflow-y-auto">${genresHtml}</div></div>` : ''}
        </div>
        <div class="mt-4 flex gap-2">
            <button class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors hover:cursor-pointer">Edit</button>
            <button onclick="deleteMovie(${movie.id})" class="px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors hover:cursor-pointer">Delete</button>
        </div>
    `;
    
    return card;
}

// Function to delete a movie
async function deleteMovie(movieId) {
    showModal('Delete Movie', 'Are you sure you want to delete this movie? This action cannot be undone.', 'confirm', async function(confirmed) {
        if (!confirmed) return;
        
        try {
            const response = await fetch(`/api/delete-movie/${movieId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            showModal('Success', 'Movie deleted successfully!', 'success');
            loadMovies();
        } catch (error) {
            console.error('Error deleting movie:', error);
            showModal('Error', 'Error deleting movie. Please try again.', 'error');
        }
    });
}

// Make deleteMovie function globally available
window.deleteMovie = deleteMovie;

// Load movies when the page loads
document.addEventListener('DOMContentLoaded', loadMovies);