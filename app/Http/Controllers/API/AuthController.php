<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable|string|max:15',
            'institution_code' => 'nullable|string|max:10',
            'guardian_email' => 'nullable|string|email|max:255',
            'role' => 'required|in:admin,pelajar,guru',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'phone_number' => $request->phone_number,
            'institution_code' => $request->institution_code,
            'guardian_email' => $request->guardian_email,
            'role' => $request->role,
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        // Validate login data
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($loginData)) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Store user information in the session
            $request->session()->put('user', $user);

            return response()->json(['user' => $user], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        // Menghapus semua token pengguna
        $request->user()->tokens()->delete();

        // Menghapus session jika menggunakan session-based authentication
        Auth::guard('web')->logout();

        return response()->json(['message' => 'Logged out successfully!'], 200);
    }

    public function getUser(Request $request)
    {
        // Check if user session exists and return user details
        if ($request->session()->has('user')) {
            return response()->json(['user' => $request->session()->get('user')], 200);
        }

        return response()->json(['message' => 'No authenticated user found'], 404);
    }
}
