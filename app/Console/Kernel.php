<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Jadwalkan reset setiap hari pada jam 00:00
        $schedule->command('tasks:reset-daily')->dailyAt('00:00');
        $schedule->command('menstrualcycle:update-status')->everyMinute();
        $schedule->command('menstrualcycle:update-status')->dailyAt('00:00');
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
{
    $this->load(__DIR__.'/Commands');
    require base_path('routes/console.php');

}

}
