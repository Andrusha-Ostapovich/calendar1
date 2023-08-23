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

        $schedule->command('reminders:generate')->dailyAt('10:00');
        
    }
    protected $commands = [
        \App\Console\Commands\GenerateReminders::class,
    ];
    
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        

        require base_path('routes/console.php');
    }
}
