let currentEditMovieId = null;
let allGenres = [];

// Function to show edit modal
function showEditModal(movieId, movieData) {
    currentEditMovieId = movieId;
    const overlay = document.getElementById('edit-modal-overlay');
    
    // Populate form fields
    document.getElementById('edit-title').value = movieData.title || '';
    document.getElementById('edit-description').value = movieData.description || '';
    document.getElementById('edit-year').value = movieData.year || '';
    document.getElementById('edit-watched').checked = movieData.status === 'watched';
    document.getElementById('edit-rating').value = movieData.rating || '';
    
    // Populate genres
    populateEditGenres(movieData.genres || []);
    
    // Show modal
    overlay.classList.remove('hidden');
};

// Function to hide edit modal
function hideEditModal() {
    const overlay = document.getElementById('edit-modal-overlay');
    overlay.classList.add('hidden');
    currentEditMovieId = null;
};

// Function to populate genres in edit modal
function populateEditGenres(selectedGenres) {
    const container = document.getElementById('edit-genres-container');
    container.innerHTML = '';
    
    const genres = [
        {id: 1, name: 'Action'}, {id: 2, name: 'Comedy'}, {id: 3, name: 'Horror'}, 
        {id: 4, name: 'Sci-Fi'}, {id: 5, name: 'Documentary'}, {id: 6, name: 'Crime'},
        {id: 7, name: 'Mystery'}, {id: 8, name: 'Adventure'}, {id: 9, name: 'Drama'}, 
        {id: 10, name: 'Romance'}, {id: 11, name: 'Thriller'}, {id: 12, name: 'Animation'}, 
        {id: 13, name: 'Fantasy'}, {id: 14, name: 'War'}
    ];
    
    genres.forEach(genre => {
        const isSelected = selectedGenres.some(sg => sg.id === genre.id);
        const genreHtml = `
            <label class="inline-flex items-center text-sm text-gray-300">
                <input type="checkbox" name="edit-genres[]" value="${genre.id}" ${isSelected ? 'checked' : ''} class="mr-2 rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                ${genre.name}
            </label>
        `;
        container.innerHTML += genreHtml;
    });
}

// Event listeners for edit modal
document.addEventListener('DOMContentLoaded', function() {
    // Cancel button
    document.getElementById('edit-cancel').addEventListener('click', hideEditModal);
    
    // Save button
    document.getElementById('edit-save').addEventListener('click', async function() {
        if (!currentEditMovieId) return;
        
        // Collect form data
        const movieData = {
            title: document.getElementById('edit-title').value,
            description: document.getElementById('edit-description').value,
            year: document.getElementById('edit-year').value,
            watched: document.getElementById('edit-watched').checked,
            rating: document.getElementById('edit-rating').value,
            genres: Array.from(document.querySelectorAll('input[name="edit-genres[]"]:checked')).map(cb => cb.value)
        };

        console.log('Saving movie data:', movieData);
        
        try {
            const response = await fetch(`/api/update-movie/${currentEditMovieId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(movieData)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            hideEditModal();
            showModal('Success', 'Movie updated successfully!', 'success');
            loadMovies();
            
        } catch (error) {
            console.error('Error updating movie:', error);
            showModal('Error', 'Error updating movie. Please try again.', 'error');
        }
    });
});

window.showEditModal = showEditModal;
window.hideEditModal = hideEditModal;