<?php

namespace App\Http\Controllers;

//use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;

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
        $user = User::create($attributes);
        auth()->login($user);
        return redirect('/dashboard');
    }

    public function create()
    {
        return view('auth.register');
    }
}
