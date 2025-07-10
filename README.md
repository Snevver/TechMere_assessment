# TechMere Assessment

Movie list app where you can search for movies using the IMDB API. Besides that you can add your own movies, add them to your list, and track what you've watched.

## Requirements

- PHP 8.1+
- Composer
- Node.js and npm
- MySQL database

## Installation

1. Clone and go to project folder

   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```
2. Set up your database in `.env` file:

   ```
   DB_CONNECTION=mysql
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
3. Run migrations and build assets:

   ```bash
   php artisan migrate:fresh --seed
   npm run build
   php artisan serve
   ```

Go to `http://localhost:8000` and register a new account or login.

## What it does

- User authentication (register/login) with sessions
- Add movies to your personal list with title, description, year
- Mark them as "want to watch" or "watched"
- Give ratings (1-5 stars)
- Add multiple genres to movies
- Delete movies with modal confirmation
- Responsive dark theme UI
- Uses MySQL database with relationships

## Features

- Movie search using IMDB API (https://rest.imdbapi.dev/)
  - Search through movies and TV shows
  - Filter results by media type (Movies/TV Shows)
  - Pagination with 5 items per page
  - View ratings, year, and cover images
- Clean movie cards with scrollable descriptions
- Modal dialogs instead of browser alerts
- Secure user authentication and authorization
- Genre management and tagging
- Movie status tracking and ratings
- Responsive design that works on mobile

## API Integration

The app uses the IMDB API (https://rest.imdbapi.dev/) for searching movies and TV shows:
- Endpoint: `/v2/search/titles?query={input}`
- Returns detailed movie information including:
  - Title and original title
  - Release year
  - Media type (movie/tvSeries)
  - Cover images
  - Ratings and vote counts

## AI Usage

Used GitHub Copilot throughout development as helping hand for:

- Writing Laravel migrations, models, and controllers (I didn't have any experience with this)
- Fixing database relationships and query issues
- JavaScript functionality and Vite integration (Also never used Vite before)
- CSS styling with Tailwind classes
- Modal component creation and integration
- Route configuration and middleware setup
- IMDB API integration and response handling

---

**Author:** [Sven Hoeksema](https://snevver.nl/)
