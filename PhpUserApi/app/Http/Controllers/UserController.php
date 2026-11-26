<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create($data);

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

public function update(Request $request, int $id): JsonResponse
{
    $user = User::find($id);

    if ($user === null) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $data = $request->validate([
        'name' => ['sometimes', 'required', 'string', 'max:255'],
        'email' => ['sometimes', 'required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'password' => ['sometimes', 'required', 'string', 'min:8'],
    ]);

    $user->update($data);

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