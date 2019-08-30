<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:create-admin {--first_name=} {--last_name=}  {--email=}  {--username=}  {--password=}   {show_in_list?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user via command line.';

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

        $first_name = $this->option('first_name');
        $last_name = $this->option('last_name');
        $username = $this->option('username');
        $email = $this->option('email');
        $password = $this->option('password');
        $show_in_list = $this->argument('show_in_list');

        if (($first_name=='') || ($last_name=='') || ($username=='') || ($email=='') || ($password=='')) {
            $this->info('ERROR: All fields are required.');
        } else {
            $user = new \App\Models\User;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->username = $username;
            $user->email = $email;
            $user->permissions = '{"admin":1,"user":1,"superuser":1,"reports.view":1, "licenses.keys":1}';
            $user->password = bcrypt($password);
            $user->activated = 1;

            if ($show_in_list == 'false') {
                $user->show_in_list = 0;
            }
            if ($user->save()) {
                $this->info('New user created');
                $user->groups()->attach(1);
            } else {
                $this->info('Admin user was not created');
                $errors = $user->getErrors();

                foreach ($errors->all() as $error) {
                    $this->info('ERROR:'. $error);
                }

            }
        }

    }

  //   protected function getArguments()
  // 	{
  // 		return array(
  // 			array('username', InputArgument::REQUIRED, 'Username'),
  // 		);
    // }
}
