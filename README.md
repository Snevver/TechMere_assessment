# TechMere Assessment

Simple movie list app where you can add movies and track what you've watched.

## Requirements

- PHP 8.1+
- Composer
- Node.js and npm

## Installation

1. Clone and go to project folder
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate:fresh --seed
   npm run dev
   php artisan serve
   ```

Go to `http://localhost:8000` and login with:
- Email: test@example.com
- Password: password

## What it does

- Add movies to your personal list
- Mark them as "want to watch" or "watched" 
- Give ratings (1-5 stars)
- Add genres to movies
- Uses SQLite database (no setup needed)
- Gets movie info from TMDB API

## AI Usage

Used GitHub Copilot to help with:
- Writing migrations and models faster
- Fixing database connection issues  
- CSS styling with Tailwind

---

**Author:** [Sven Hoeksema](https://snevver.nl/)
