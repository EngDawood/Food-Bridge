# FoodBridge

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About FoodBridge

**FoodBridge** is a Laravel-based web application designed to reduce food waste by connecting food donors, beneficiaries, and volunteers in Al-Jouf, Saudi Arabia. This is a student thesis project for Jouf University's Computer Science program, aligned with Saudi Vision 2030 sustainability goals.

## Detailed Installation Guide

To set up the FoodBridge project on your local machine, please follow these steps:

1.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

2.  **Install Node.js dependencies:**
    ```bash
    npm install
    ```

3.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate your application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure your `.env` file:**
    Open the `.env` file and set up your database connection details (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Build frontend assets:**
    ```bash
    npm run build
    ```

8.  **Start the development server:**
    ```bash
    php artisan serve
    ```

You should now be able to access the application at `http://127.0.0.1:8000`.

## About Laravel

This project is built on Laravel, a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Technology Stack

**Backend:**
* Laravel 12 (PHP 8.2+)
* MySQL 8.2
* Composer for dependency management

**Frontend:**
* HTML5, Blade templating
* Tailwind CSS 4.0
* shadcn/ui 3.5.0 (Modern UI component library)
* Chart.js 4.5.1 (Data visualization)
* JavaScript (vanilla)
* Vite 6.0.11 build tool
* Axios 1.7.4 (HTTP client)

**Development Tools:**
* Laravel Pint (code styling)
* Laravel Sail (Docker environment)
* PHPUnit (testing)
* Faker (test data generation)

## Core Features

1. **Multi-Role Authentication System**
   * Donors: Post surplus food donations
   * Beneficiaries: Request food and view matches
   * Volunteers: Manage delivery tasks
   * Admins: System oversight and reporting

2. **Food Donation Management**
   * CRUD operations for donations
   * Status tracking (pending, scheduled, delivered)
   * Expiration date and quantity tracking

3. **Request Matching System**
   * Automatic matching between donations and requests
   * Location-based coordination
   * Real-time notifications

4. **Delivery Coordination**
   * Volunteer task assignment
   * Delivery status tracking
   * Pickup and drop-off management

5. **Feedback & Rating System**
   * User feedback collection
   * Rating system for transactions
   * Quality assurance

## Common Development Commands

### Laravel Application Commands

```bash
# Development server
php artisan serve                    # Start local development server
composer run dev                     # Start with queue, logs, and Vite

# Database operations
php artisan migrate                  # Run migrations
php artisan migrate:fresh --seed    # Fresh migration with seeding
php artisan db:seed                 # Run seeders only

# Cache and optimization
php artisan config:clear            # Clear config cache
php artisan route:clear             # Clear route cache
php artisan view:clear              # Clear view cache
php artisan optimize:clear          # Clear all caches

# Code quality
./vendor/bin/pint                   # Run Laravel Pint (code styling)
php artisan test                    # Run PHPUnit tests

# Tinker (REPL)
php artisan tinker                  # Interactive PHP shell
```

### Frontend Asset Commands

```bash
# Vite development
npm run dev                         # Start Vite dev server
npm run build                       # Build for production

# Dependencies
npm install                         # Install Node.js dependencies
composer install                   # Install PHP dependencies
```

### Database Management

```bash
# Fresh start
php artisan migrate:fresh --seed    # Reset and seed database
php artisan make:migration          # Create new migration
php artisan make:factory            # Create model factory
php artisan make:seeder             # Create database seeder
```

## Default Users for Testing

When you seed the database (`php artisan db:seed` or `php artisan migrate:fresh --seed`), the following users are created for testing purposes:

### Admin
- **Email**: `admin@foodbridge.sa`
- **Password**: `yyy`

### Donors
- **Email**: `nora@foodbridge.sa`
- **Password**: `password`

- **Email**: `khaled@foodbridge.sa`
- **Password**: `password`

- **Email**: `alkheir@foodbridge.sa`
- **Password**: `password`

### Beneficiaries
- **Email**: `fatima@foodbridge.sa`
- **Password**: `password`

- **Email**: `abdullah@foodbridge.sa`
- **Password**: `password`

- **Email**: `maryam@foodbridge.sa`
- **Password**: `password`

### Volunteers
- **Email**: `mohammed@foodbridge.sa`
- **Password**: `password`

- **Email**: `sara@foodbridge.sa`
- **Password**: `password`

## Important Directory Structure

```
/home/dawood/FoodBridge/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   ├── Services/
│   ├── Contracts/Services/
│   ├── Helpers/
│   └── Providers/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── routes/
└── tests/
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
The FoodBridge application is also open-sourced under the [MIT license](https://opensource.org/licenses/MIT).