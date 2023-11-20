<?php

namespace App\Console;

use App\Console\Commands\Followup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Followup::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('followup:deadline')
            ->dailyAt('00:00')
            ->timezone('Asia/Jakarta')
            ->runInBackground()
            ->sendOutputTo('output.txt')
            ->emailOutputTo('output@example.com')
            ->emailOutputOnFailure('failure@example.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
