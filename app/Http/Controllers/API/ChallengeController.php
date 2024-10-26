<?php

namespace App\Http\Controllers\API;

use App\Models\Challenge;
use App\Models\DailyTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDailyTaskProgress;

class ChallengeController extends Controller
{
    // Get all challenges
    public function index()
    {
        $userId = Auth::id(); // Get the authenticated user ID

        $challenges = Challenge::with(['dailyTasks' => function ($query) use ($userId) {
            $query->with(['userProgress' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }]);
        }])->get(); // Eager load dailyTasks with user-specific progress

        return response()->json(['message' => 'Challenges retrieved successfully', 'data' => $challenges], 200);
    }

    // Create a new challenge
    public function store(Request $request)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the challenge with the authenticated user's ID
        $challenge = Challenge::create(array_merge($validatedData, ['user_id' => Auth::id()]));

        return response()->json(['message' => 'Challenge created successfully', 'data' => $challenge], 201);
    }

    // Show a specific challenge
    public function show($id)
    {
        $challenge = Challenge::with('dailyTasks')->find($id);

        if (!$challenge) {
            return response()->json(['message' => 'Challenge not found'], 404);
        }

        return response()->json(['message' => 'Challenge retrieved successfully', 'data' => $challenge], 200);
    }

    // Update a specific challenge
    public function update(Request $request, $id)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $challenge = Challenge::find($id);

        if (!$challenge) {
            return response()->json(['message' => 'Challenge not found'], 404);
        }

        // Validate request data
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the challenge
        $challenge->update($validatedData);

        return response()->json(['message' => 'Challenge updated successfully', 'data' => $challenge], 200);
    }

    // Delete a specific challenge
    public function destroy($id)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $challenge = Challenge::find($id);

        if (!$challenge) {
            return response()->json(['message' => 'Challenge not found'], 404);
        }

        // Delete the challenge
        $challenge->delete();

        return response()->json(['message' => 'Challenge deleted successfully'], 200);
    }

    // Create daily task for a specific challenge
    public function createDailyTask(Request $request, $challengeId)
    {
        // Validate request data
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        // Find the challenge
        $challenge = Challenge::findOrFail($challengeId);

        // Create the daily task associated with the challenge
        $dailyTask = $challenge->dailyTasks()->create($validatedData);

        return response()->json(['message' => 'Daily task created successfully', 'data' => $dailyTask], 201);
    }

    public function markTaskAsCompleted(Request $request, $taskId)
    {
        $userId = Auth::id(); // Get the authenticated user ID

        // Validate request data
        $request->validate([
            'completed' => 'required|boolean', // Ensure 'completed' is a boolean
        ]);

        // Find the daily task
        try {
            $dailyTask = DailyTask::with('challenge')->findOrFail($taskId); // Eager load the challenge relationship

            // Check if the challenge exists
            if (!$dailyTask->challenge) {
                return response()->json(['message' => 'Challenge not found for this daily task'], 404);
            }

            $challengeId = $dailyTask->challenge->id;

            // Check for existing user progress
            $userProgress = UserDailyTaskProgress::where('daily_task_id', $taskId)
                ->where('user_id', $userId)
                ->first();

            // If progress exists, update the completion status
            if ($userProgress) {
                $userProgress->is_completed = $request->completed; // Set based on the request
                $userProgress->save(); // Save immediately after updating the completion status
            } else {
                // If no progress exists, create a new entry
                $userProgress = UserDailyTaskProgress::create([
                    'daily_task_id' => $taskId,
                    'user_id' => $userId,
                    'is_completed' => $request->completed, // Set based on the request
                    'challenge_id' => $challengeId // Include challenge_id
                ]);
            }

            // Calculate the total number of tasks and completed tasks for the challenge
            $totalTasks = DailyTask::where('challenge_id', $challengeId)->count();
            $completedTasks = UserDailyTaskProgress::where('challenge_id', $challengeId)
                ->where('user_id', $userId)
                ->where('is_completed', true)
                ->count();

            // Calculate the progress percentage
            $progressPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            // Update the progress percentage
            $userProgress->progress_percentage = $progressPercentage; // Update progress percentage
            $userProgress->save(); // Save the updated user progress

            return response()->json(['message' => 'Daily task completion status updated', 'data' => $userProgress], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    public function getUserProgress($challengeId)
    {
        $userId = Auth::id(); // Get the authenticated user ID

        // Find the challenge
        $challenge = Challenge::with('dailyTasks')->findOrFail($challengeId);

        // Count total daily tasks for the challenge
        $totalTasks = $challenge->dailyTasks()->count();

        // Count completed tasks for the authenticated user
        $completedTasks = UserDailyTaskProgress::where('user_id', $userId)
            ->whereHas('dailyTask', function ($query) use ($challengeId) {
                $query->where('challenge_id', $challengeId);
            })
            ->where('is_completed', true)
            ->count();

        // Calculate progress percentage
        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        return response()->json(['progress' => $progress], 200);
    }

    public function getUserDailyProgress($challengeId)
{
    $userId = Auth::id(); // Get the authenticated user ID

    // Find the challenge and load related daily tasks
    $challenge = Challenge::with('dailyTasks')->findOrFail($challengeId);

    // Get the user's progress for each daily task in this challenge
    $progressData = $challenge->dailyTasks->map(function ($task) use ($userId) {
        // Check if the user has completed this task
        $userProgress = UserDailyTaskProgress::where('daily_task_id', $task->id)
            ->where('user_id', $userId)
            ->first();

        return [
            'task_id' => $task->id,
            'description' => $task->description,
            'is_completed' => $userProgress ? $userProgress->is_completed : false,
            'progress_percentage' => $userProgress ? $userProgress->progress_percentage : 0, // Tambahkan ini
        ];
    });

    // Calculate overall progress
    $totalTasks = $challenge->dailyTasks->count();
    $completedTasks = $progressData->where('is_completed', true)->count();
    $progressPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

    return response()->json([
        'challenge_id' => $challengeId,
        'total_tasks' => $totalTasks,
        'completed_tasks' => $completedTasks,
        'progress_percentage' => $progressPercentage,
        'tasks' => $progressData,
    ], 200);
}

}
