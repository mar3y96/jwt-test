<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\loginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;

class AuthController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {
        
        $data = $this->userService->register($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $data['user'],
            'authorisation' => [
                'token' => $data['token'],
                'type' => 'bearer',
            ]
        ]);
    }

    public function login(loginUserRequest $request)
    {
        $data = $this->userService->login($request->validated());
        return response()->json([
                'status' => 'success',
                'user' => $data['user'],
                'authorisation' => [
                    'token' => $data['token'],
                    'type' => 'bearer',
                ]
            ]);

    }


    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
