<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MergeUsersByUsername extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:merge-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command allows you to merge the history of users. It looks for users without an email address as their username and merges them into the version that does have an email username.';

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
        // Get the list of users who have an email address as their username
        $users = User::where('username', 'LIKE', '%@%')->whereNull('deleted_at')->get();
        $this->info($users->count().' total non-deleted users whose usernames contain a @ symbol.');


        foreach ($users as $user) {
            $parts = explode('@', trim($user->username));
            $this->info('Checking against username '.trim($parts[0]).'.');


            $bad_users = User::where('username', '=', trim($parts[0]))
                ->whereNull('deleted_at')
                ->with('assets', 'manager', 'userlog', 'licenses', 'consumables', 'accessories', 'managedLocations','uploads', 'acceptances')
                ->get();



            foreach ($bad_users as $bad_user) {
                $this->info($bad_user->username.' ('.$bad_user->id.')  will be merged into '.$user->username.'  ('.$user->id.') ');
                $user->merge($bad_user); //THAT's IT!

            }
        }
    }
}
