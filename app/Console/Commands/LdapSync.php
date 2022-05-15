<?php

namespace App\Console\Commands;

use App\Models\Department;
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
    protected $signature = 'snipeit:ldap-sync {--location=} {--location_id=} {--base_dn=} {--summary} {--json_summary}';

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
        ini_set('max_execution_time', env('LDAP_TIME_LIM', 600)); //600 seconds = 10 minutes
        ini_set('memory_limit', env('LDAP_MEM_LIM', '500M'));
        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;

        $ldap_result_active_flag = Setting::getSettings()->ldap_active_flag_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_email = Setting::getSettings()->ldap_email;
        $ldap_result_phone = Setting::getSettings()->ldap_phone_field;
        $ldap_result_jobtitle = Setting::getSettings()->ldap_jobtitle;
        $ldap_result_country = Setting::getSettings()->ldap_country;
        $ldap_result_dept = Setting::getSettings()->ldap_dept;
        $ldap_result_manager = Setting::getSettings()->ldap_manager;

        try {
            $ldapconn = Ldap::connectToLdap();
            Ldap::bindAdminToLdap($ldapconn);
        } catch (\Exception $e) {
            if ($this->option('json_summary')) {
                $json_summary = ['error' => true, 'error_message' => $e->getMessage(), 'summary' => []];
                $this->info(json_encode($json_summary));
            }
            LOG::info($e);

            return [];
        }

        $summary = [];

        try {
            if ($this->option('base_dn') != '') {
                $search_base = $this->option('base_dn');
                LOG::debug('Importing users from specified base DN: \"'.$search_base.'\".');
            } else {
                $search_base = null;
            }
            $results = Ldap::findLdapUsers($search_base);
        } catch (\Exception $e) {
            if ($this->option('json_summary')) {
                $json_summary = ['error' => true, 'error_message' => $e->getMessage(), 'summary' => []];
                $this->info(json_encode($json_summary));
            }
            LOG::info($e);

            return [];
        }

        /* Determine which location to assign users to by default. */
        $location = null; // TODO - this would be better called "$default_location", which is more explicit about its purpose

        if ($this->option('location') != '') {
            $location = Location::where('name', '=', $this->option('location'))->first();
            LOG::debug('Location name '.$this->option('location').' passed');
            LOG::debug('Importing to '.$location->name.' ('.$location->id.')');
        } elseif ($this->option('location_id') != '') {
            $location = Location::where('id', '=', $this->option('location_id'))->first();
            LOG::debug('Location ID '.$this->option('location_id').' passed');
            LOG::debug('Importing to '.$location->name.' ('.$location->id.')');
        }

        if (! isset($location)) {
            LOG::debug('That location is invalid or a location was not provided, so no location will be assigned by default.');
        }

        /* Process locations with explicitly defined OUs, if doing a full import. */
        if ($this->option('base_dn') == '') {
            // Retrieve locations with a mapped OU, and sort them from the shallowest to deepest OU (see #3993)
            $ldap_ou_locations = Location::where('ldap_ou', '!=', '')->get()->toArray();
            $ldap_ou_lengths = [];

            foreach ($ldap_ou_locations as $ou_loc) {
                $ldap_ou_lengths[] = strlen($ou_loc['ldap_ou']);
            }

            array_multisort($ldap_ou_lengths, SORT_ASC, $ldap_ou_locations);

            if (count($ldap_ou_locations) > 0) {
                LOG::debug('Some locations have special OUs set. Locations will be automatically set for users in those OUs.');
            }

            // Inject location information fields
            for ($i = 0; $i < $results['count']; $i++) {
                $results[$i]['ldap_location_override'] = false;
                $results[$i]['location_id'] = 0;
            }

            // Grab subsets based on location-specific DNs, and overwrite location for these users.
            foreach ($ldap_ou_locations as $ldap_loc) {
                try {
                    $location_users = Ldap::findLdapUsers($ldap_loc['ldap_ou']);
                } catch (\Exception $e) { // TODO: this is stolen from line 77 or so above
                    if ($this->option('json_summary')) {
                        $json_summary = ['error' => true, 'error_message' => trans('admin/users/message.error.ldap_could_not_search').' Location: '.$ldap_loc['name'].' (ID: '.$ldap_loc['id'].') cannot connect to "'.$ldap_loc['ldap_ou'].'" - '.$e->getMessage(), 'summary' => []];
                        $this->info(json_encode($json_summary));
                    }
                    LOG::info($e);

                    return [];
                }
                $usernames = [];
                for ($i = 0; $i < $location_users['count']; $i++) {
                    if (array_key_exists($ldap_result_username, $location_users[$i])) {
                        $location_users[$i]['ldap_location_override'] = true;
                        $location_users[$i]['location_id'] = $ldap_loc['id'];
                        $usernames[] = $location_users[$i][$ldap_result_username][0];
                    }
                }

                // Delete located users from the general group.
                foreach ($results as $key => $generic_entry) {
                    if ((is_array($generic_entry)) && (array_key_exists($ldap_result_username, $generic_entry))) {
                        if (in_array($generic_entry[$ldap_result_username][0], $usernames)) {
                            unset($results[$key]);
                        }
                    }
                }

                $global_count = $results['count'];
                $results = array_merge($location_users, $results);
                $results['count'] = $global_count;
            }
        }

        /* Create user account entries in Snipe-IT */
        $tmp_pass = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
        $pass = bcrypt($tmp_pass);

        for ($i = 0; $i < $results['count']; $i++) {
            if (empty($ldap_result_active_flag) || $results[$i][$ldap_result_active_flag][0] == 'TRUE') {
                $item = [];
                $item['username'] = isset($results[$i][$ldap_result_username][0]) ? $results[$i][$ldap_result_username][0] : '';
                $item['employee_number'] = isset($results[$i][$ldap_result_emp_num][0]) ? $results[$i][$ldap_result_emp_num][0] : '';
                $item['lastname'] = isset($results[$i][$ldap_result_last_name][0]) ? $results[$i][$ldap_result_last_name][0] : '';
                $item['firstname'] = isset($results[$i][$ldap_result_first_name][0]) ? $results[$i][$ldap_result_first_name][0] : '';
                $item['email'] = isset($results[$i][$ldap_result_email][0]) ? $results[$i][$ldap_result_email][0] : '';
                $item['ldap_location_override'] = isset($results[$i]['ldap_location_override']) ? $results[$i]['ldap_location_override'] : '';
                $item['location_id'] = isset($results[$i]['location_id']) ? $results[$i]['location_id'] : '';
                $item['telephone'] = isset($results[$i][$ldap_result_phone][0]) ? $results[$i][$ldap_result_phone][0] : '';
                $item['jobtitle'] = isset($results[$i][$ldap_result_jobtitle][0]) ? $results[$i][$ldap_result_jobtitle][0] : '';
                $item['country'] = isset($results[$i][$ldap_result_country][0]) ? $results[$i][$ldap_result_country][0] : '';
                $item['department'] = isset($results[$i][$ldap_result_dept][0]) ? $results[$i][$ldap_result_dept][0] : '';
                $item['manager'] = isset($results[$i][$ldap_result_manager][0]) ? $results[$i][$ldap_result_manager][0] : '';

                $department = Department::firstOrCreate([
                    'name' => $item['department'],
                ]);

                $user = User::where('username', $item['username'])->first();
                if ($user) {
                    // Updating an existing user.
                    $item['createorupdate'] = 'updated';
                } else {
                    // Creating a new user.
                    $user = new User;
                    $user->password = $pass;
                    $user->activated = 0;
                    $item['createorupdate'] = 'created';
                }

                $user->first_name = $item['firstname'];
                $user->last_name = $item['lastname'];
                $user->username = $item['username'];
                $user->email = $item['email'];
                $user->employee_num = e($item['employee_number']);
                $user->phone = $item['telephone'];
                $user->jobtitle = $item['jobtitle'];
                $user->country = $item['country'];
                $user->department_id = $department->id;

                if($item['manager'] != null) {
                    //Captures only the Canonical Name
                    $item['manager'] = ltrim($item['manager'], "CN=");
                    $item['manager'] = substr($item['manager'],0, strpos($item['manager'], ','));
                    $ldap_manager = User::where('username', $item['manager'])->first();
                    if ( $ldap_manager && isset($ldap_manager->id) ) {
                        $user->manager_id = $ldap_manager->id;
                    }
                }


                // Sync activated state for Active Directory.
                if (array_key_exists('useraccountcontrol', $results[$i])) {
                    /* The following is _probably_ the correct logic, but we can't use it because
                       some users may have been dependent upon the previous behavior, and this
                       could cause additional access to be available to users they don't want
                       to allow to log in.

                    $useraccountcontrol = $results[$i]['useraccountcontrol'][0];
                    if(
                        // based on MS docs at: https://support.microsoft.com/en-us/help/305144/how-to-use-useraccountcontrol-to-manipulate-user-account-properties
                        ($useraccountcontrol & 0x200) && // is a NORMAL_ACCOUNT
                        !($useraccountcontrol & 0x02) && // *and* _not_ ACCOUNTDISABLE
                        !($useraccountcontrol & 0x10)    // *and* _not_ LOCKOUT
                    ) {
                        $user->activated = 1;
                    } else {
                        $user->activated = 0;
                    } */
                    $enabled_accounts = [
                    '512',    // 0x200    NORMAL_ACCOUNT
                    '544',    // 0x220    NORMAL_ACCOUNT, PASSWD_NOTREQD
                    '66048',  // 0x10200  NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD
                    '66080',  // 0x10220  NORMAL_ACCOUNT, PASSWD_NOTREQD, DONT_EXPIRE_PASSWORD
                    '262656', // 0x40200  NORMAL_ACCOUNT, SMARTCARD_REQUIRED
                    '262688', // 0x40220  NORMAL_ACCOUNT, PASSWD_NOTREQD, SMARTCARD_REQUIRED
                    '328192', // 0x50200  NORMAL_ACCOUNT, SMARTCARD_REQUIRED, DONT_EXPIRE_PASSWORD
                    '328224', // 0x50220  NORMAL_ACCOUNT, PASSWD_NOT_REQD, SMARTCARD_REQUIRED, DONT_EXPIRE_PASSWORD
                    '4194816',// 0x400200 NORMAL_ACCOUNT, DONT_REQ_PREAUTH
                    '4260352', // 0x410200 NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD, DONT_REQ_PREAUTH
                    '1049088', // 0x100200 NORMAL_ACCOUNT, NOT_DELEGATED
                  ];
                    $user->activated = (in_array($results[$i]['useraccountcontrol'][0], $enabled_accounts)) ? 1 : 0;
                }

                // If we're not using AD, and there isn't an activated flag set, activate all users
                elseif (empty($ldap_result_active_flag)) {
                    $user->activated = 1;
                }

                if ($item['ldap_location_override'] == true) {
                    $user->location_id = $item['location_id'];
                } elseif ((isset($location)) && (! empty($location))) {
                    if ((is_array($location)) && (array_key_exists('id', $location))) {
                        $user->location_id = $location['id'];
                    } elseif (is_object($location)) {
                        $user->location_id = $location->id;
                    }
                }

                $user->ldap_import = 1;

                $errors = '';

                if ($user->save()) {
                    $item['note'] = $item['createorupdate'];
                    $item['status'] = 'success';
                } else {
                    foreach ($user->getErrors()->getMessages() as $key => $err) {
                        $errors .= $err[0];
                    }
                    $item['note'] = $errors;
                    $item['status'] = 'error';
                }

                array_push($summary, $item);
            }
        }

        if ($this->option('summary')) {
            for ($x = 0; $x < count($summary); $x++) {
                if ($summary[$x]['status'] == 'error') {
                    $this->error('ERROR: '.$summary[$x]['firstname'].' '.$summary[$x]['lastname'].' (username:  '.$summary[$x]['username'].') was not imported: '.$summary[$x]['note']);
                } else {
                    $this->info('User '.$summary[$x]['firstname'].' '.$summary[$x]['lastname'].' (username:  '.$summary[$x]['username'].') was '.strtoupper($summary[$x]['createorupdate']).'.');
                }
            }
        } elseif ($this->option('json_summary')) {
            $json_summary = ['error' => false, 'error_message' => '', 'summary' => $summary]; // hardcoding the error to false and the error_message to blank seems a bit weird
            $this->info(json_encode($json_summary));
        } else {
            return $summary;
        }
    }
}
