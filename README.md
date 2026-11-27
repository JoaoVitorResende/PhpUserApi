![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?logo=sqlite&logoColor=white)

# PhpUserApi

A simple user CRUD REST API built with PHP and Laravel, with token authentication using Laravel Sanctum. Backend only, no front-end.

## Features

- Full CRUD for users
- Token authentication with Laravel Sanctum (login and logout)
- Protected routes with the `auth:sanctum` middleware
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

## Authentication

The API uses bearer tokens. Create a user, log in to get a token, and send it in the `Authorization` header on protected routes.

1. Create a user with `POST /api/users` (public route).
2. Log in with `POST /api/login` to receive a token.
3. Send `Authorization: Bearer <token>` on every protected request.
4. Log out with `POST /api/logout` to revoke the token.

Always send the `Accept: application/json` header, so that validation and authentication errors are returned as JSON.

## Endpoints

| Method | Route           | Description      | Auth     | Success |
|--------|-----------------|------------------|----------|---------|
| GET    | /api/ping       | Health check     | Public   | 200     |
| POST   | /api/users      | Create a user    | Public   | 201     |
| POST   | /api/login      | Log in           | Public   | 200     |
| POST   | /api/logout     | Log out          | Required | 204     |
| GET    | /api/users      | List all users   | Required | 200     |
| GET    | /api/users/{id} | Get a user by id | Required | 200     |
| PUT    | /api/users/{id} | Update a user    | Required | 200     |
| DELETE | /api/users/{id} | Delete a user    | Required | 204     |

## Request body

User fields (create and update):

| Field    | Rules                         |
|----------|-------------------------------|
| name     | required, string, max 255     |
| email    | required, valid email, unique |
| password | required, string, min 8       |

On update, all fields are optional, but any field sent must be valid.

Login fields:

| Field    | Rules                |
|----------|----------------------|
| email    | required, valid email |
| password | required, string     |

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
    "created_at": "2026-11-27T10:48:20.000000Z"
  }
}
```

Log in:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"maria@example.com","password":"12345678"}'
```

Response (200):

```json
{
  "token": "1|your-token-here",
  "user": {
    "id": 1,
    "name": "Maria",
    "email": "maria@example.com",
    "created_at": "2026-11-27T10:48:20.000000Z"
  }
}
```

List users with the token:

```bash
curl http://localhost:8000/api/users \
  -H "Accept: application/json" \
  -H "Authorization: Bearer 1|your-token-here"
```

Update a user:

```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer 1|your-token-here" \
  -d '{"name":"Maria Silva"}'
```

Log out:

```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Accept: application/json" \
  -H "Authorization: Bearer 1|your-token-here"
```

## Error responses

- `401` with `{"message": "Unauthenticated."}` when the token is missing, invalid or revoked.
- `401` with `{"message": "Invalid credentials"}` when the login email or password is wrong.
- `404` with `{"message": "User not found"}` when the user does not exist.
- `422` with the validation errors when the request body is invalid.

## Project structure

```
app/
  Http/
    Controllers/
      AuthController.php
      UserController.php
    Requests/
      LoginRequest.php
      StoreUserRequest.php
      UpdateUserRequest.php
    Resources/
      UserResource.php
  Models/
    User.php
routes/
  api.php
```