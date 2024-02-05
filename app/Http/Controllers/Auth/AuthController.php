<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
         $token = auth()->attempt($request->validated());
         if ($token) {
             return $this->respondWithToken($token, auth()->user());
         } else {
             return response()->json([
                 'status' => 'failed',
                 'message' => 'Invalid credentials'
             ], 401);
         }

    }

    public function register(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create((new UserController())->extractData($data));

        if ($user) {
           // $token = auth()->login($user);
            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token, $user);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error of creating user'
            ], 500);
        }
    }

    public function respondWithToken($token,  $user):JsonResponse
    {
        return response()->json([
            'status' => 'success',
            "user" => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $newToken = JWTAuth::refresh(JWTAuth::parseToken());
        $user = auth()->user();
        return $this->respondWithToken($newToken, $user);
    }


    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
