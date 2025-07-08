function showAddMovieForm() {
    document.getElementById('addMovieForm').classList.remove('hidden');
}

function hideAddMovieForm() {
    document.getElementById('addMovieForm').classList.add('hidden');
    document.getElementById('title').value = '';
    document.getElementById('year').value = '';
}

function saveMovie() {
    event.preventDefault();
    
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const genres = Array.from(document.querySelectorAll('input[name="genres[]"]:checked')).map(genre => genre.value);
    const year = document.getElementById('year').value;
    const watched = document.getElementById('watched').checked;
    const rating = document.getElementById('rating').value;

    const movieData = {
        title: title,
        description: description,
        genres: genres,
        year: year,
        watched: watched,
        rating: rating
    };

    fetch('/api/save-movie', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(movieData)
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Network response was not ok: ' + response.status);
        }
    })
    .then(data => {
        alert('Movie added successfully!');
        hideAddMovieForm();
    })
    .catch(error => {
        alert('Error saving movie. Please try again.');
    });
}