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
            'date_of_birth' => 'nullable|date', // Validate date of birth
            'phone_number' => 'nullable|string|max:15', // Validate phone number
            'institution_code' => 'nullable|string|max:10', // Validate institution code
            'guardian_email' => 'nullable|string|email|max:255', // Validate guardian email
            'role' => 'required|in:admin,pelajar,guru', // Validate role
        ]);

        // Create the user with additional fields
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth, // Store date of birth
            'phone_number' => $request->phone_number, // Store phone number
            'institution_code' => $request->institution_code, // Store institution code
            'guardian_email' => $request->guardian_email, // Store guardian email
            'role' => $request->role, // Store role
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        // Validasi data yang dikirim oleh pengguna
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $loginData['email'])->first();

        // Memeriksa apakah pengguna ada
        if (!$user) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        // Memeriksa apakah password yang diberikan cocok
        if (!Hash::check($loginData['password'], $user->password)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        // Membuat token untuk pengguna
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan data pengguna dan token, termasuk role
        return response(['user' => $user, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Logged out'], 200);
    }
}
