<?php namespace App\Console;

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
        'App\Console\Commands\AppCommand',
        'App\Console\Commands\SystemBackup',
        'App\Console\Commands\AssetImportCommand',
        'App\Console\Commands\Versioning',
        'App\Console\Commands\Inspire',
        'App\Console\Commands\LicenseImportCommand',
        'App\Console\Commands\SendExpirationAlerts',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
