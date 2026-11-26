<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json($user, 201);
    }

public function index(): JsonResponse
{
    return response()->json(User::all());
}

public function show(int $id): JsonResponse
{
    $user = User::find($id);

    if ($user === null) {
        return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json($user);
}

public function update(UpdateUserRequest $request, int $id): JsonResponse
{
    $user = User::find($id);

    if ($user === null) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->update($request->validated());

    return response()->json($user);
}

public function destroy(int $id): JsonResponse
{
    $user = User::find($id);

    if ($user === null) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(null, 204);
}

}