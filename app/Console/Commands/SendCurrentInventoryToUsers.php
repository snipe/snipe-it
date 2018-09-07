<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\User;
use App\Notifications\CurrentInventory;

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

        $users = User::whereNull('deleted_at')->whereNotNull('email')->with('assets', 'accessories', 'consumables', 'licenses')->get();

        foreach ($users as $user) {
            $this->info($user->email);
            $user->notify((new CurrentInventory($user)));
        }


    }
}
