<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Menampilkan tampilan login
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Set an error message
            return redirect()->back()->with('error', 'Email not found.')->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            // Set an error message for incorrect password
            return redirect()->back()->with('error', 'Password Salah.')->withInput();
        }

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Set a success message
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil! Selamat datang kembali.');
        }

        // If login fails
        return redirect()->back()->with('error', 'Login failed. Please try again.')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil!'); // Set a success message on logout
    }
}
