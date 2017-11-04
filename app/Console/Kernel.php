<?php

namespace App\Console;

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
        Commands\PaveIt::class,
        Commands\CreateAdmin::class,
        Commands\SendExpirationAlerts::class,
        Commands\SendInventoryAlerts::class,
        Commands\SendExpectedCheckinAlerts::class,
        Commands\ObjectImportCommand::class,
        Commands\Versioning::class,
        Commands\SystemBackup::class,
        Commands\DisableLDAP::class,
        Commands\Purge::class,
        Commands\LdapSync::class,
        Commands\FixDoubleEscape::class,
        Commands\RecryptFromMcrypt::class,
        Commands\ResetDemoSettings::class,
        Commands\SyncAssetLocations::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('snipeit:inventory-alerts')->daily();
        $schedule->command('snipeit:expiring-alerts')->daily();
        $schedule->command('snipeit:expected-checkin')->daily();
        $schedule->command('snipeit:backup')->weekly();
        $schedule->command('backup:clean')->daily();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
