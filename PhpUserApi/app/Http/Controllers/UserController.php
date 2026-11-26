<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return UserResource::collection(User::all())->response();
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return (new UserResource($user))->response();
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->validated());

        return (new UserResource($user))->response();
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