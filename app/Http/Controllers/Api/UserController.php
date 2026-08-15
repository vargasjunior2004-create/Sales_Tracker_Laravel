<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::orderBy('id')->get();

        return response()->json(UserResource::collection($users)->resolve());
    }

    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        return response()->json(new UserResource($user), 201);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        if (isset($data['password']) && $data['password'] !== null) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json(new UserResource($user));
    }
}
