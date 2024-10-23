<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MenstrualCycle;
use App\Http\Controllers\Controller;
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
        // Retrieve the user from session
        $user = $request->session()->get('user');

        // Retrieve the latest menstrual cycle for the user
        $latestCycle = MenstrualCycle::where('user_id', $user->id)->latest()->first();

        // Prepare the user data without additional menstrual cycle fields
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'date_of_birth' => $user->date_of_birth,
            'phone_number' => $user->phone_number,
            'institution_code' => $user->institution_code,
            'guardian_email' => $user->guardian_email,
            'role' => $user->role,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];

        // If a menstrual cycle exists, attach it directly to the user object
        if ($latestCycle) {
            $userData['menstrual_cycles'] = $latestCycle;
        } else {
            $userData['menstrual_cycles'] = null;
        }

        // Return the user object with the menstrual cycle included
        return response()->json($userData, 200);
    }

    return response()->json(['message' => 'No authenticated user found'], 404);
}


}
