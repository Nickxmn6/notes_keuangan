<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Note;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Reset semua checklist yang recurring setiap tanggal 1 jam 00:01
        $schedule->call(function () {
            // Hanya reset notes yang:
            // 1. is_recurring = true
            // 2. completed_at bukan bulan ini
            Note::where('is_recurring', true)
                ->whereNotNull('completed_at')
                ->whereMonth('completed_at', '!=', Carbon::now()->month)
                ->update(['completed_at' => null]);

            \Log::info('Monthly checklist reset completed at ' . now());
        })->monthlyOn(1, '00:01'); // Jalankan setiap tanggal 1 jam 00:01
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
