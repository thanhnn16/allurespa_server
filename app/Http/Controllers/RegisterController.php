<?php

namespace App\Http\Controllers;

//use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function store()
    {
        $attributes = request()->validate([
            'phone_number' => 'required|min_digits:10|max_digits:13|numeric|unique:users,phone_number',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5',
            'terms' => 'required'
        ]);
        User::create($attributes);
        return redirect('/login')->with('success', 'Đăng ký thành công. Đăng nhập để tiếp tục.');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function registerGetToken(): JsonResponse
    {
        $user = request()->validate([
            'phone_number' => 'required|min_digits:10|max_digits:13|numeric|unique:users,phone_number',
            'password' => 'required|min:6',
        ]);
        try {
            $user = User::create($user);
            $token = $user->createToken('miwth16')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user_id' => $user->id,
                'phone_number' => $user->phone_number,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

}
