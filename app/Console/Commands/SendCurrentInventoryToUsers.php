<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\CurrentInventory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;

class SendCurrentInventoryToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:user-inventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send users a report of all of the items currently checked out to them.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNull('deleted_at')->whereNotNull('email')->with('assets', 'accessories', 'licenses')->get();

        $count = 0;
        $failed = 0;
        foreach ($users as $user) {
            if (($user->assets->count() > 0) || ($user->accessories->count() > 0) || ($user->licenses->count() > 0) || ($user->consumables->count() > 0)) {
                try {
                    $user->notify((new CurrentInventory($user)));
                    $count++;
                } catch (TransportException $e) {
                    $failed++;
                    $message = 'Failed to send current-inventory notification to '.$user->email.': '.$e->getMessage();
                    Log::warning($message);
                    $this->error($message);
                }
            }
        }

        $this->info($count.' users notified.');
        if ($failed > 0) {
            $this->warn($failed.' notification(s) failed to send due to mail transport errors. See log for details.');
        }
    }
}
