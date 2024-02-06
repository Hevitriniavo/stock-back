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
    public function __construct(
        private readonly UserController $controller
    ){}

    public function login(LoginUserRequest $request): JsonResponse
    {
        $token = auth()->attempt($request->validated());
        if ($token) {
            return $this->respondWithToken($token);
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

        $user = User::create($this->controller->extractData($request));

        if ($user) {
            // $token = auth()->login($user);
            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Error of creating user'
            ], 500);
        }
    }


    public function respondWithToken($token):JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $newToken = JWTAuth::refresh(JWTAuth::parseToken());
        $user = auth()->user();
        return $this->respondWithToken($newToken);
    }


    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
