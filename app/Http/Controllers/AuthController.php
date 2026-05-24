<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.'
                ])
                ->withInput([
                    'email' => $request->email
                ]);
        }

        Session::put('auth_user', [
            'id' => $user->id,
            'fullName' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('auth.login')
            ->with('success', 'Account created successfully!');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email not found.'
            ]);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

        $resetLink = route('password.reset', ['token' => $token]) . '?email=' . urlencode($request->email);

        Mail::raw(
            "Click this link to reset your password:\n\n" . $resetLink,
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Your Password');
            }
        );

        return back()->with('success', 'Password reset link sent to your email.');
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$reset) {
            return back()->withErrors([
                'email' => 'Invalid reset request.'
            ]);
        }

        if (!Hash::check($request->token, $reset->token)) {
            return back()->withErrors([
                'email' => 'Invalid or expired token.'
            ]);
        }

        DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now(),
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Password reset successful. Please login.');
    }

    public function logout()
    {
        Session::forget('auth_user');

        return redirect()->route('auth.login');
    }
}