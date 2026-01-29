# Laravel Backend API

This is the backend API built with Laravel.

## Requirements
- PHP 8.1+
- Composer
- MySQL (WAMP / XAMPP)
- Laravel 9 or 10

## Setup Instructions

1. Clone the repository
git clone https://github.com/username/backend-repo.git
cd backend-repo

2. Install dependencies
composer install

3. Environment setup
cp .env.example .env
php artisan key:generate

4. Database setup
- Create an empty MySQL database named: voyago
- Update database credentials in .env

5. Run migrations and seeders
php artisan migrate --seed

6. Run the server
php artisan serve

API will run on:
http://127.0.0.1:8000/api

## Default Account
Email: admin@gmail.com  
Password: 123456789
