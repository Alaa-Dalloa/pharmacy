<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     * 
     */

    protected $commands = [
    \App\Console\Commands\BarrenTest::class, 
    \App\Console\Commands\TestEexpireAndEnd::class,
  ];

   protected function schedule(Schedule $schedule)
    {
         $schedule->command('TestEexpireAndEnd:update')
         ->everyMinute()
         ->appendOutputTo('schedule.log');
    
         $schedule->command('BarrenTest:update')
         ->monthly()
         ->appendOutputTo('schedule.log');
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
