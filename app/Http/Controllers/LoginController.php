<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function loginGetToken(Request $request): JsonResponse
    {
        $request->validate([
            'phone_number' => ['required', 'numeric', 'digits_between:10,13'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {
            $token = $request->user()->createToken('miwth16')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => Auth::user()
            ]);
        }
        return response()->json([
            'message' => 'Số điện thoại hoặc mật khẩu không đúng.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
