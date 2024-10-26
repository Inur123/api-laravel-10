<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class ShowCurrentDate extends Command
{
    protected $signature = 'date:show'; // Define the command name
    protected $description = 'Show the current date and time';

    public function handle()
    {
        $currentDate = Carbon::now(); // Get the current date and time
        $this->info("Current date and time: " . $currentDate); // Output the result
    }
}
