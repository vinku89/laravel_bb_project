<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\home\CronJobsController;
use App\Http\Controllers\home\CustomerController;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();


		/*$schedule->call(function () {
            CronJobsController::testCron();
        })->dailyAt('10:00');*/

        $schedule->call(function () {
            CronJobsController::packageBeforeSevenDaysAlert();
        })->dailyAt('04:15');

		//free trail expiry
		$schedule->call(function () {
           CronJobsController::checkFreeTrailExpiryTime();
        })->everyFiveMinutes();

        $schedule->call(function () {
            CustomerController::checkPaymentWaitingStatus();
        })->everyThirtyMinutes();

        //run cron for US epglist
        $schedule->call(function () {
            CronJobsController::runUSEPGlist();
        })->dailyAt('00:15')->onSuccess(function () {
            CronJobsController::removeOldUSEPGlist();
            // The task succeeded...
        });

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
