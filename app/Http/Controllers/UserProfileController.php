<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
            'full_name' => ['required', 'max:255'],
        ]);

        $attributes['note'] = $request->get('note');
        $attributes['password'] = bcrypt(request()->get('new_password'));

        auth()->user()->update([
            'email' => $attributes['email'],
            'full_name' => $attributes['full_name'],
            'note' => $attributes['note'],
            'password' => $attributes['password'],
        ]);

        return back()->with('succes', 'Cập nhật hồ sơ thành công');
    }
}
