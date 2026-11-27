![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white)

# PhpUserApi

A simple user CRUD REST API built with PHP and Laravel. Backend only, no front-end.

## Features

- Full CRUD for users
- Input validation with Form Requests
- Response formatting with API Resources
- SQLite database, no extra setup required

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

| Method | Route           | Description      | Success |
|--------|-----------------|------------------|---------|
| GET    | /api/ping       | Health check     | 200     |
| POST   | /api/users      | Create a user    | 201     |
| GET    | /api/users      | List all users   | 200     |
| GET    | /api/users/{id} | Get a user by id | 200     |
| PUT    | /api/users/{id} | Update a user    | 200     |
| DELETE | /api/users/{id} | Delete a user    | 204     |

Always send the `Accept: application/json` header so that validation errors are returned as JSON.

## Request body

| Field    | Rules                              |
|----------|------------------------------------|
| name     | required, string, max 255          |
| email    | required, valid email, unique      |
| password | required, string, min 8            |

On update, all fields are optional, but any field sent must be valid.

## Examples

Create a user:

```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Maria","email":"maria@example.com","password":"12345678"}'
```

Response (201):

```json
{
  "data": {
    "id": 1,
    "name": "Maria",
    "email": "maria@example.com",
    "created_at": "2026-11-26T15:49:54.000000Z"
  }
}
```

Update a user:

```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Maria Silva"}'
```

## Error responses

- `404` with `{"message": "User not found"}` when the user does not exist.
- `422` with the validation errors when the request body is invalid.

## Project structure

```
app/
  Http/
    Controllers/UserController.php
    Requests/StoreUserRequest.php
    Requests/UpdateUserRequest.php
    Resources/UserResource.php
  Models/User.php
routes/api.php
```