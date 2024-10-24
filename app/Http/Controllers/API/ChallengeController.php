<?php

// App\Http\Controllers\API\ChallengeController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Daily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    // Store new challenge - Only admin can create
    public function store(Request $request)
    {
        // Only admin can add data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'progress' => 'required|integer|min:0|max:100',
            'daily_tasks' => 'required|array|min:1', // Validate that daily tasks are provided
            'daily_tasks.*.description' => 'required|string', // Validate each task description
            'daily_tasks.*.is_completed' => 'required|boolean', // Validate each task completion status
        ]);

        // Create new challenge
        $challenge = Challenge::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'progress' => $request->progress,
        ]);

        // Create daily tasks associated with the challenge
        foreach ($request->daily_tasks as $task) {
            Daily::create([
                'challenge_id' => $challenge->id,
                'description' => $task['description'],
                'is_completed' => $task['is_completed'],
            ]);
        }

        return response()->json(['message' => 'Challenge and daily tasks created successfully!', 'data' => $challenge], 201);
    }

    // Store a daily task for a specific challenge
    public function storeDaily(Request $request, $challengeId)
    {
        // Validate request
        $request->validate([
            'description' => 'required|string',
            'is_completed' => 'required|boolean',
        ]);

        // Find the challenge
        $challenge = Challenge::find($challengeId);
        if (!$challenge || $challenge->user_id !== Auth::id()) {
            return response()->json(['message' => 'Challenge not found or unauthorized.'], 404);
        }

        // Create a new daily task
        $daily = Daily::create([
            'challenge_id' => $challenge->id,
            'description' => $request->description,
            'is_completed' => $request->is_completed,
        ]);

        return response()->json(['message' => 'Daily task added successfully!', 'data' => $daily], 201);
    }

    // Get all challenges with their daily tasks
    public function index()
    {
        $challenges = Challenge::where('user_id', Auth::id())
            ->with('dailies') // Include related dailies
            ->get();

        return response()->json(['message' => 'Challenges retrieved successfully', 'data' => $challenges], 200);
    }

    // Update the progress of a challenge
    public function updateProgress(Request $request, $challengeId)
    {
        // Validate request
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        // Find the challenge
        $challenge = Challenge::find($challengeId);
        if (!$challenge || ($challenge->user_id !== Auth::id() && Auth::user()->role !== 'admin')) {
            return response()->json(['message' => 'Challenge not found or unauthorized.'], 404);
        }

        // Update challenge progress
        $challenge->update(['progress' => $request->progress]);

        return response()->json(['message' => 'Challenge progress updated successfully!', 'data' => $challenge], 200);
    }

    public function updateDaily(Request $request, $dailyId)
    {
        // Validasi input berdasarkan peran pengguna
        if (Auth::user()->role !== 'admin') {
            $request->validate([
                'is_completed' => 'required|boolean',
            ]);
        } else {
            // Admin dapat memperbarui description dan is_completed
            $request->validate([
                'description' => 'required|string',
                'is_completed' => 'required|boolean',
            ]);
        }

        // Cari daily task
        $daily = Daily::find($dailyId);
        if (!$daily || ($daily->challenge->user_id !== Auth::id() && Auth::user()->role !== 'admin')) {
            return response()->json(['message' => 'Daily task not found or unauthorized.'], 404);
        }

        // Tentukan data yang akan diperbarui
        $dataToUpdate = ['is_completed' => $request->is_completed];
        if (Auth::user()->role === 'admin') {
            $dataToUpdate['description'] = $request->description;
        }

        // Perbarui daily task
        $daily->update($dataToUpdate);

        // Ambil challenge terkait
        $challenge = Challenge::find($daily->challenge_id);
        if ($challenge) {
            // Hitung total dan tugas harian yang telah diselesaikan
            $totalTasksCount = $challenge->dailies()->count();
            $completedTasksCount = $challenge->dailies()->where('is_completed', true)->count();

            // Update status is_completed dari challenge jika semua tugas harian selesai
            $challenge->update([
                'is_completed' => $completedTasksCount === $totalTasksCount,
                'progress' => ($completedTasksCount / $totalTasksCount) * 100, // Update progres (dalam persen)
            ]);
        }

        return response()->json(['message' => 'Daily task updated successfully!', 'data' => $daily], 200);
    }



    // Mark daily task as completed
    public function completeDailyTask(Request $request, $dailyId)
    {
        // Only students and teachers can complete daily tasks
        if (Auth::user()->role !== 'student' && Auth::user()->role !== 'teacher') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Find the daily task
        $daily = Daily::find($dailyId);
        if (!$daily) {
            return response()->json(['message' => 'Daily task not found.'], 404);
        }

        // Update the daily task to mark it as completed
        $daily->update(['is_completed' => true]);

        // Update the challenge's progress and check if all tasks are completed
        $challenge = Challenge::find($daily->challenge_id);
        if ($challenge) {
            // Check if all daily tasks are completed
            $allTasksCompleted = Daily::where('challenge_id', $challenge->id)->where('is_completed', false)->count() === 0;

            if ($allTasksCompleted) {
                // Optionally, you can mark the challenge as completed
                // $challenge->update(['is_completed' => true]);
            }

            // Calculate new progress based on completed daily tasks
            $completedTasksCount = Daily::where('challenge_id', $challenge->id)->where('is_completed', true)->count();
            $totalTasksCount = Daily::where('challenge_id', $challenge->id)->count();

            // Calculate the new progress percentage
            if ($totalTasksCount > 0) {
                $newProgress = ($completedTasksCount / $totalTasksCount) * 100;
                $challenge->update(['progress' => $newProgress]);
            }
        }

        return response()->json(['message' => 'Daily task marked as completed!', 'data' => $daily], 200);
    }
}
