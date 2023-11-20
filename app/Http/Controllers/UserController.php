<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('pages.user-management', ['users' => $users]);
    }

    public function create()
    {
        return view('pages.user-management-create');
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('pages.user-management-show', ['user' => $user]);
    }
}
