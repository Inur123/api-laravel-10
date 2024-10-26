<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MenstrualCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MenstrualCycleController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'last_period_start' => 'required|date',
            'last_period_finish' => 'required|date|after:last_period_start', // Ensure finish is after start
        ]);

        // Save the menstrual cycle data
        $menstrualCycle = MenstrualCycle::create([
            'user_id' => Auth::id(),
            'last_period_start' => $request->last_period_start,
            'last_period_finish' => $request->last_period_finish,
            'is_completed' => false, // Default value set to false
            'progress' => 0, // Initialize progress
        ]);

        return response()->json(['message' => 'Menstrual cycle data stored successfully!', 'data' => $menstrualCycle], 201);
    }

    public function index()
    {
        // Retrieve all menstrual cycles for the authenticated user
        $cycles = MenstrualCycle::where('user_id', Auth::id())->get();
        $currentDate = Carbon::now(); // Get the current date

        $formattedCycles = $cycles->map(function ($cycle) use ($currentDate) {
            $lastPeriodStart = Carbon::parse($cycle->last_period_start);
            $lastPeriodFinish = Carbon::parse($cycle->last_period_finish);
            $updatedAt = Carbon::parse($cycle->updated_at); // Get the updated_at date

            $totalDays = $lastPeriodFinish->diffInDays($lastPeriodStart) + 1; // Total days including the finish day
            $daysPassed = $updatedAt->diffInDays($lastPeriodStart) + 1; // Days passed including the start day

            // Determine if the cycle is completed and calculate progress
            // Updated logic: is_completed is true if the last_period_finish is past the current date
            $isCompleted = $currentDate->greaterThan($lastPeriodFinish) && $currentDate->greaterThan($updatedAt);

            // Calculate progress based on whether it's completed or not
            $progress = !$isCompleted && $totalDays > 0 ? min(100, round(($daysPassed / $totalDays) * 100)) : ($isCompleted ? 100 : 0);

            return [
                'id' => $cycle->id,
                'user_id' => $cycle->user_id,
                'last_period_start' => $cycle->last_period_start,
                'last_period_finish' => $cycle->last_period_finish,
                'is_completed' => $isCompleted, // Update to reflect the new logic
                'progress' => $progress, // Set progress to 100 if completed
                'created_at' => $cycle->created_at,
                'updated_at' => $cycle->updated_at,
            ];
        });

        return response()->json(['message' => 'Data retrieved successfully', 'menstrual_cycles' => $formattedCycles], 200);
    }


    public function checkCycle()
    {
        $userId = Auth::id();
        // Retrieve the last menstrual cycle from the database
        $lastCycle = MenstrualCycle::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Check if the last cycle exists
        if ($lastCycle) {
            $currentDate = Carbon::now();
            $lastPeriodFinish = Carbon::parse($lastCycle->last_period_finish);
            $updatedAt = Carbon::parse($lastCycle->updated_at);

            // If the current date is greater than the finish date
            if ($currentDate->greaterThan($lastPeriodFinish) || $currentDate->greaterThan($updatedAt)) {
                // Mark the cycle as completed
                $lastCycle->update(['is_completed' => true]);

                return response()->json([
                    'message' => 'Siklus menstruasi telah selesai.',
                    'is_completed' => true, // Return true explicitly
                ], 200);
            } else {
                // Calculate progress
                if ($updatedAt->lessThanOrEqualTo($lastPeriodFinish)) {
                    $totalDays = $lastPeriodFinish->diffInDays($lastCycle->last_period_start);
                    $remainingDays = $lastPeriodFinish->diffInDays($updatedAt);
                    $progress = min(100, round((($totalDays - $remainingDays) / $totalDays) * 100));

                    return response()->json([
                        'message' => 'Siklus menstruasi masih berlangsung.',
                        'is_completed' => false, // Return false explicitly
                        'progress' => $progress,
                    ], 200);
                }
            }
        }

        return response()->json(['message' => 'Data siklus menstruasi tidak ditemukan.'], 404);
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'last_period_start' => 'required|date',
            'last_period_finish' => 'required|date',
        ]);

        // Retrieve the latest menstrual cycle for the authenticated user
        $menstrualCycle = MenstrualCycle::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        // Check if the cycle was found
        if (!$menstrualCycle) {
            return response()->json(['message' => 'Siklus menstruasi tidak ditemukan.'], 404);
        }

        try {
            // Update the cycle data with new information
            $menstrualCycle->update([
                'last_period_start' => $request->last_period_start,
                'last_period_finish' => $request->last_period_finish,
                'is_completed' => false, // Reset to false
                'progress' => 0, // Reset progress
            ]);

            return response()->json(['message' => 'Menstrual cycle data updated successfully!', 'data' => $menstrualCycle], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating menstrual cycle: ' . $e->getMessage()], 500);
        }
    }

}
