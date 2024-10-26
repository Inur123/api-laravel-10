<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MenstrualCycle;
use App\Models\User;
use Carbon\Carbon;

class UpdateMenstrualCycleStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-menstrual-cycle-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update menstrual cycle status for all users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Retrieve all users
        $users = User::all();

        foreach ($users as $user) {
            // Retrieve menstrual cycles for the current user
            $cycles = MenstrualCycle::where('user_id', $user->id)->get();

            foreach ($cycles as $cycle) {
                $lastPeriodStart = Carbon::parse($cycle->last_period_start);
                $lastPeriodFinish = Carbon::parse($cycle->last_period_finish);
                $updatedAt = Carbon::parse($cycle->updated_at); // Get the updated_at date

                // Total days of the period
                $totalDays = $lastPeriodFinish->diffInDays($lastPeriodStart) + 1; // Total days including the finish day

                // Determine if the cycle is completed based on the last_period_finish and updated_at
                $isCompleted = $currentDate->greaterThan($lastPeriodFinish) && $currentDate->greaterThan($updatedAt);

                // Calculate progress
                $progress = 0;
                if (!$isCompleted) {
                    $daysPassed = $updatedAt->diffInDays($lastPeriodStart) + 1; // Days passed including the start day
                    $progress = $totalDays > 0 ? min(100, round(($daysPassed / $totalDays) * 100)) : 0;
                } else {
                    $progress = 100; // Set progress to 100 if completed
                }

                // Update the cycle's status and progress in the database
                $cycle->is_completed = $isCompleted;
                $cycle->progress = $progress;
                $cycle->save(); // Save the changes to the database

                // Log the formatted cycles for the current user
                $this->info("User ID: {$user->id}, Cycle ID: {$cycle->id}, Progress: {$cycle->progress}%, Completed: " . ($cycle->is_completed ? 'Yes' : 'No'));
            }
        }

        $this->info('Menstrual cycle statuses updated successfully for all users.');
    }
}
