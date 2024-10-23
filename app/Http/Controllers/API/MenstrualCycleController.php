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
        'last_period_finish' => 'required|date',
    ]);

    // Save the menstrual cycle data
    $menstrualCycle = MenstrualCycle::create([
        'user_id' => Auth::id(),
        'last_period_start' => $request->last_period_start,
        'last_period_finish' => $request->last_period_finish,
        'is_completed' => false, // Default value set to false
    ]);

    return response()->json(['message' => 'Menstrual cycle data stored successfully!', 'data' => $menstrualCycle], 201);
}

public function index()
{
    // Retrieve all menstrual cycles for the authenticated user
    $cycles = MenstrualCycle::where('user_id', Auth::id())->get();

    // Format the response to convert 1/0 to true/false
    $formattedCycles = $cycles->map(function ($cycle) {
        return [
            'id' => $cycle->id,
            'last_period_start' => $cycle->last_period_start,
            'last_period_finish' => $cycle->last_period_finish,
            'is_completed' => (bool) $cycle->is_completed, // Convert to boolean
            'created_at' => $cycle->created_at,
            'updated_at' => $cycle->updated_at,
        ];
    });

    return response()->json(['message' => 'Data retrieved successfully', 'data' => $formattedCycles], 200);
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

            // If the current date is greater than the finish date
            if ($currentDate->greaterThan($lastPeriodFinish)) {
                // Mark the cycle as completed
                $lastCycle->update(['is_completed' => true]);

                return response()->json([
                    'message' => 'Siklus menstruasi telah selesai.',
                    'is_completed' => true, // Return true explicitly
                ], 200);
            } else {
                // If still within the finish date
                return response()->json([
                    'message' => 'Siklus menstruasi masih berlangsung.',
                    'is_completed' => false, // Return false explicitly
                ], 200);
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
        ]);

        return response()->json(['message' => 'Menstrual cycle data updated successfully!', 'data' => $menstrualCycle], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error updating menstrual cycle: ' . $e->getMessage()], 500);
    }
}

}
