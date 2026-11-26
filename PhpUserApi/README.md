![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white)

# PhpUserApi

A simple user CRUD REST API built with PHP and Laravel. Backend only, no front-end.

## Requirements

- PHP 8.2+
- Composer

## Getting started

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

The API will be available at `http://localhost:8000/api`.

## Endpoints

| Method | Route             | Description        |
|--------|-------------------|--------------------|
| GET    | /api/ping         | Health check       |
| POST   | /api/users        | Create a user      |
| GET    | /api/users        | List all users     |
| GET    | /api/users/{id}   | Get a user by id   |
| PUT    | /api/users/{id}   | Update a user      |
| DELETE | /api/users/{id}   | Delete a user      |

## Example

```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Joao","email":"joao@example.com","password":"12345678"}'
```

Validation errors return `422` and missing users return `404`.