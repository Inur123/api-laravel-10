<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserDailyTaskProgress;

class ResetDailyTasks extends Command
{
    // Nama dan signature dari command
    protected $signature = 'tasks:reset-daily';

    // Deskripsi dari command
    protected $description = 'Reset status penyelesaian daily task dan persentase progres setiap hari';

    // Jalankan command
    public function handle()
    {
        // Reset is_completed dan progress_percentage untuk semua data di UserDailyTaskProgress
        UserDailyTaskProgress::query()->update([
            'is_completed' => false,
            'progress_percentage' => 0,
        ]);

        $this->info('Status daily task telah berhasil di-reset.');
    }
}
