<?php

namespace App\Console;

use App\Console\Commands\ActivityCounter;
use App\Console\Commands\DailyAlert;
use App\Console\Commands\RemovePreviews;
use App\Console\Commands\WeeklyAlert;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RemovePreviews::class,
        DailyAlert::class,
        WeeklyAlert::class,
        ActivityCounter::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('remove_previews')->hourly();
         $schedule->command('daily_alert')->daily();
         $schedule->command('weekly_alert')->weekly();
         $schedule->command('activity_counter')->daily();
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
