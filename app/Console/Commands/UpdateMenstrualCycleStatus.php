<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MenstrualCycle;
use Illuminate\Console\Command;
use App\Notifications\MenstrualCycleUpdated;

class UpdateMenstrualCycleStatus extends Command
{
    protected $signature = 'app:update-menstrual-cycle-status';
    protected $description = 'Update menstrual cycle status for all users.';

    public function handle()
    {
        $currentDate = Carbon::now();
        $users = User::all();

        foreach ($users as $user) {
            $cycles = MenstrualCycle::where('user_id', $user->id)->get();

            foreach ($cycles as $cycle) {
                try {
                    $lastPeriodStart = $cycle->last_period_start ? Carbon::parse($cycle->last_period_start) : null;
                    $lastPeriodFinish = $cycle->last_period_finish ? Carbon::parse($cycle->last_period_finish) : null;
                    $updatedAt = Carbon::parse($cycle->updated_at);

                    if (!$lastPeriodStart || !$lastPeriodFinish) {
                        $this->error("Cycle ID: {$cycle->id} has invalid period dates.");
                        continue; // Skip this cycle if dates are invalid
                    }

                    $totalDays = $lastPeriodFinish->diffInDays($lastPeriodStart) + 1;
                    $isCompleted = $currentDate->greaterThan($lastPeriodFinish) && $currentDate->greaterThan($updatedAt);

                    $progress = $isCompleted ? 100 : ($totalDays > 0 ? min(100, round(($updatedAt->diffInDays($lastPeriodStart) + 1) / $totalDays * 100)) : 0);

                    // Update the cycle's status and progress in the database
                    $cycle->is_completed = $isCompleted;
                    $cycle->progress = $progress;
                    $cycle->save();

                    // Send the notification
                    $user->notify(new MenstrualCycleUpdated($cycle));

                    // Log details
                    $this->info("User ID: {$user->id}");
                    $this->info("Cycle ID: {$cycle->id}");
                    $this->info("Progress: {$cycle->progress}%");
                    $this->info("Status: " . ($cycle->is_completed ? 'Completed' : 'In Progress'));
                    $this->info("-----------------------------------");

                } catch (\Exception $e) {
                    $this->error("Error processing user ID: {$user->id}, Cycle ID: {$cycle->id} - " . $e->getMessage());
                }
            }
        }

        $this->info('Menstrual cycle statuses updated successfully for all users.');
    }


}
