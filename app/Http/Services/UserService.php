<?php


namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register($data)
    {
        $user = $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $token = Auth::login($user);
        return ['token' => $token, 'user' => $user];
    }

    public function login($data)
    {
        $token = Auth::attempt($data);
        if (!$token) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401));
        }
        $user = Auth::user();
        return ['token' => $token, 'user' => $user];
    }
}
