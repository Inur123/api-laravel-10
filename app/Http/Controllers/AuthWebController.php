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
        return back()->withErrors(['email' => 'Email not found.'])->onlyInput('email');
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Password Salah.'])->onlyInput('password');
    }

    // Attempt login
    if (Auth::attempt($request->only('email', 'password'))) {
        // Set a flash message
        return redirect()->intended('/dashboard')->with('success', 'Login berhasil! Selamat datang kembali.');
    }

    return back()->withErrors(['email' => 'Login failed. Please try again.']);
}


    public function logout()
    {
        Auth::logout();
        return redirect('/login'); // Redirect ke halaman login setelah logout
    }
}
