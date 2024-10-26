<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Challenge;
use App\Models\GirlyPedia;
use Illuminate\Http\Request;
use App\Models\GirlyPediaUser;
use App\Models\MenstrualCycle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserDailyTaskProgress;

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

        // Return success response with the created user
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

            // Optionally, you can also generate and return a token
            // $token = $user->createToken('YourAppName')->accessToken;
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
        $userId = $user->id; // Get user ID for later use

        // Retrieve the latest menstrual cycle for the user
        $latestCycle = MenstrualCycle::where('user_id', $userId)->latest()->first();

        // Retrieve all Girly Pedia items and the user's progress
        $girlyPediaItems = GirlyPedia::all(); // Or filter based on user or other criteria

        // Calculate the total number of items and the number of completed items
        $totalItems = $girlyPediaItems->count();
        $completedItemsCount = GirlyPediaUser::where('user_id', $userId)->where('is_completed', true)->count();

        // Calculate progress percentage for Girly Pedia
        $progressPercentage = $totalItems > 0 ? ($completedItemsCount / $totalItems) * 100 : 0;

        // Prepare user data
        $userData = [
            'id' => $userId,
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
            'menstrual_cycles' => $latestCycle ?: null,  // Menstrual cycle data
            'progress_percentage_girlypedia' => $progressPercentage,  // Girly Pedia progress percentage
        ];

        // Now get the user's challenge progress
        $userChallenges = Challenge::with('dailyTasks')->get(); // Get all challenges with their daily tasks

        $challengeProgressData = $userChallenges->map(function ($challenge) use ($userId) {
            // Calculate overall progress for the challenge
            $totalTasks = $challenge->dailyTasks->count();
            $completedTasks = UserDailyTaskProgress::whereIn('daily_task_id', $challenge->dailyTasks->pluck('id'))
                ->where('user_id', $userId)
                ->where('is_completed', true)
                ->count();

            // Calculate progress percentage for the challenge
            $progressPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            return [
                'challenge_id' => $challenge->id,
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'progress_percentage' => $progressPercentage,
            ];
        });

        // Calculate overall progress across all challenges by averaging progress percentages
        $totalProgressPercentage = $challengeProgressData->sum('progress_percentage');
        $totalChallenges = $challengeProgressData->count();

        // Calculate the final overall progress percentage based on average
        $overallProgressPercentage = $totalChallenges > 0 ? ($totalProgressPercentage / $totalChallenges) : 0;

        // Add challenge progress data and overall progress to user data
        $userData['challenges'] = $challengeProgressData;
        $userData['overall_progress_percentage'] = min(100, $overallProgressPercentage); // Ensure the value does not exceed 100

        // Return the user object with the menstrual cycle and challenges included
        return response()->json($userData, 200);
    }

    return response()->json(['message' => 'No authenticated user found'], 404);
}


    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'sometimes|required|string|min:8',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable|string|max:15',
            'institution_code' => 'nullable|string|max:10',
            'guardian_email' => 'nullable|string|email|max:255',
            'role' => 'sometimes|required|in:admin,pelajar,guru',
        ]);

        // Retrieve the authenticated user directly from the request
        $user = $request->user();

        // Update user data directly from the request
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
        $user->date_of_birth = $request->input('date_of_birth', $user->date_of_birth);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->institution_code = $request->input('institution_code', $user->institution_code);
        $user->guardian_email = $request->input('guardian_email', $user->guardian_email);
        $user->role = $request->input('role', $user->role);

        // Update password if provided
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated user data to the database
        $user->save();

        // Update the session data with the new user information
        $request->session()->put('user', $user);

        // Return success response with updated user data
        return response()->json(['message' => 'User data updated successfully!', 'user' => $user], 200);
    }

    public function getRegistrationStatistics()
{
    // Retrieve the number of registrations for each day in the last 30 days
    $registrations = User::selectRaw('DATE(created_at) as date, count(*) as count')
        ->where('created_at', '>=', now()->subDays(30)) // Adjust the period as needed
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return response()->json($registrations, 200);
}

}
