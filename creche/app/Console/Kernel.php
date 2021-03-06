<?php

namespace App\Console;

use Carbon\Carbon;
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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\LogDemo::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


    /*  $schedule->command('log:demo')->dailyAt('03:00')->when(function(){
            if(Carbon::now()->toDateString() == Carbon::now()->startOfMonth()->toDateString())
            {
                return true;
            }
        });*/
        $schedule->command('log:demo')->everyMinute()->when(function(){
            if(Carbon::now()->toDateString() == Carbon::now()->toDateString())
            {
                return true;
            }
        });
       // $schedule->command('inspire') ->hourly();
    // $schedule->command('log:demo')->everyMinute();

    }
}
