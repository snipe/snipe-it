<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Models\Ldap;
use App\Models\User;
use App\Models\Location;
use Log;

class LdapSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:ldap-sync {--location=} {--location_id=} {--summary}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command line LDAP sync';

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
        ini_set('max_execution_time', 600); //600 seconds = 10 minutes
        ini_set('memory_limit', '500M');

        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;

        $ldap_result_active_flag = Setting::getSettings()->ldap_active_flag_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_email = Setting::getSettings()->ldap_email;

        try {
            $ldapconn = Ldap::connectToLdap();
        } catch (\Exception $e) {
            LOG::error($e);
        }

        try {
            Ldap::bindAdminToLdap($ldapconn);
        } catch (\Exception $e) {
            LOG::error($e);
        }

        $summary = array();

        $results = Ldap::findLdapUsers();

        if ($this->option('location')!='') {
            $location = Location::where('name','=',$this->option('location'))->first();
            LOG::debug('Location name '.$this->option('location').' passed');
            LOG::debug('Importing to '.$location->name.' ('.$location->id.')');
        } elseif ($this->option('location_id')!='') {
            $location = Location::where('id','=',$this->option('location_id'))->first();
            LOG::debug('Location ID '.$this->option('location_id').' passed');
            LOG::debug('Importing to '.$location->name.' ('.$location->id.')');
        } else {
            $location = new Location;
        }

        if (!isset($location)) {
            LOG::debug('That location is invalid, so no location will be assigned.');
        }


        $tmp_pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $pass = bcrypt($tmp_pass);


        for ($i = 0; $i < $results["count"]; $i++) {
            if (empty($ldap_result_active_flag) || $results[$i][$ldap_result_active_flag][0] == "TRUE") {

                $item = array();
                $item["username"] = isset($results[$i][$ldap_result_username][0]) ? $results[$i][$ldap_result_username][0] : "";
                $item["employee_number"] = isset($results[$i][$ldap_result_emp_num][0]) ? $results[$i][$ldap_result_emp_num][0] : "";
                $item["lastname"] = isset($results[$i][$ldap_result_last_name][0]) ? $results[$i][$ldap_result_last_name][0] : "";
                $item["firstname"] = isset($results[$i][$ldap_result_first_name][0]) ? $results[$i][$ldap_result_first_name][0] : "";
                $item["email"] = isset($results[$i][$ldap_result_email][0]) ? $results[$i][$ldap_result_email][0] : "" ;

                // User exists
                $item["createorupdate"] = 'updated';
                if (!$user = User::where('username', $item["username"])->first()) {
                    $user = new User;
                    $user->password = $pass;
                    $item["createorupdate"] = 'created';
                }

                // Create the user if they don't exist.


                $user->first_name = e($item["firstname"]);
                $user->last_name = e($item["lastname"]);
                $user->username = e($item["username"]);
                $user->email = e($item["email"]);
                $user->employee_num = e($item["employee_number"]);
                $user->activated = 1;

                if ($location) {
                    $user->location_id = e($location->id);
                }

                $user->notes = 'Imported from LDAP';
                $user->ldap_import = 1;

                $errors = '';

                if ($user->save()) {
                    $item["note"] = $item["createorupdate"];
                    $item["status"]='success';
                } else {
                    foreach ($user->getErrors()->getMessages() as $key => $err) {
                        $errors .= $err[0];
                    }
                    $item["note"] = $errors;
                    $item["status"]='error';
                }

                array_push($summary, $item);
            }

        }

        if ($this->option('summary')) {
            for ($x = 0; $x < count($summary); $x++) {
                if ($summary[$x]['status']=='error') {
                    $this->error('ERROR: '.$summary[$x]['firstname'].' '.$summary[$x]['lastname'].' (username:  '.$summary[$x]['username'].' was not imported: '.$summary[$x]['note'] );
                } else {
                    $this->info('User '.$summary[$x]['firstname'].' '.$summary[$x]['lastname'].' (username:  '.$summary[$x]['username'].' was '.strtoupper($summary[$x]['createorupdate']).'.');
                }

            }
        } else {
            return $summary;
        }



    }


}
