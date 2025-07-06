# TechMere Assessment

A Laravel-based web application for movie management with user authentication.

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL database

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd TechMere_assessment/techmere_assessment
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   - Configure your database connection in `.env`
   - Run migrations:
   ```bash
   php artisan migrate
   ```

6. **Build assets**
   ```bash
   npm run dev
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`

## Features

- User registration and authentication
- Login/logout functionality
- Protected routes with middleware
- Movie management interface
- Responsive design with Tailwind CSS

## Routes

- `/` - Home page (requires authentication)
- `/login` - Login page
- `/register` - Registration page

---

## Usage of AI / copilot
I used AI in some places (see the log.md for details) to enhance some of the features or help me code more efficient.
I also used AI to make this README more clear.

---

**Author:** [Sven Hoeksema](https://snevver.nl/)