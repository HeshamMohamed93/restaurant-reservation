# Restaurant Reservation

## Introduction
The Reservation system is a digital platform designed to manage small restaurant reservation and management system

## Getting Started
### Installation
- Clone the repository from GitHub.
- Install docker => docker compose up -d --build OR use Xampp to up and running project.
- Install dependencies using Composer.
- Configure the environment variables.

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

## Postman Collection

You can find the Postman collection for testing the API endpoints [here](https://speeding-meadow-176611.postman.co/workspace/My-Workspace~a489fae2-2dec-40b2-89be-c4615e45c574/collection/1053931-0935f13e-0610-4942-8863-814c50e2e073?action=share&creator=1053931&active-environment=2132092-17d44f77-08fd-47eb-ac45-88685bf92481).

### Authentication

All endpoints require authentication using Sanctum Laravel authentication. Tokens are used in all requests to 
authenticate users as customer or waiter.

## Support
For any questions or assistance, please contact our developer, Hesham Mohamed, at [hesham.mohamed19930@gmail.com](mailto:hesham.mohamed19930@gmail.com).
