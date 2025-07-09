# TechMere Assessment

Simple movie list app where you can add movies and track what you've watched.

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

- Clean movie cards with scrollable descriptions
- Modal dialogs instead of browser alerts
- Secure user authentication and authorization
- Genre management and tagging
- Movie status tracking and ratings
- Responsive design that works on mobile

## AI Usage

Used GitHub Copilot throughout development as helping hand for:

- Writing Laravel migrations, models, and controllers (I didn't have any experience with this)
- Fixing database relationships and query issues
- JavaScript functionality and Vite integration (Also never used Vite before)
- CSS styling with Tailwind classes
- Modal component creation and integration
- Route configuration and middleware setup

---

**Author:** [Sven Hoeksema](https://snevver.nl/)
