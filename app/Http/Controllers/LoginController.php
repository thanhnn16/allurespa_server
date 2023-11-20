<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {
            if (Auth::user()->role != 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'phone_number' => 'Bạn không có quyền truy cập vào trang này. Liên hệ với quản trị viên để biết thêm chi tiết.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'phone_number' => 'Số điện thoại hoặc mật khẩu không đúng.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
