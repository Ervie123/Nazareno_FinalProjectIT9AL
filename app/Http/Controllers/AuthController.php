<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::get('auth_user')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->withInput(['email' => $request->email]);
        }

        Session::put('auth_user', [
            'id'       => $user->id,
            'fullName' => $user->name,
            'email'    => $user->email,
            'role'     => $user->role,
        ]);

        return redirect()->route('dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('auth.login')
            ->with('success', 'Account created! Please sign in.');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        return back()->with('success', 'Reset code sent! (Demo — no actual email sent)');
    }

    public function logout()
    {
        Session::forget('auth_user');
        return redirect()->route('auth.login');
    }
}
