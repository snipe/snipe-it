<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\Group;
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
    protected $signature = 'snipeit:ldap-sync {--location=} {--location_id=} {--base_dn=} {--filter=} {--summary} {--json_summary}';

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

        // If LDAP enabled isn't set to 1 (ldap_enabled!=1) then we should cut this short immediately without going any further
        if (Setting::getSettings()->ldap_enabled!='1') {
            $this->error('LDAP is not enabled. Aborting. See Settings > LDAP to enable it.');
            exit();
        }

        ini_set('max_execution_time', env('LDAP_TIME_LIM', 600)); //600 seconds = 10 minutes
        ini_set('memory_limit', env('LDAP_MEM_LIM', '500M'));
        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;
        $ldap_result_active_flag = Setting::getSettings()->ldap_active_flag;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_email = Setting::getSettings()->ldap_email;
        $ldap_result_phone = Setting::getSettings()->ldap_phone_field;
        $ldap_result_jobtitle = Setting::getSettings()->ldap_jobtitle;
        $ldap_result_country = Setting::getSettings()->ldap_country;
        $ldap_result_location = Setting::getSettings()->ldap_location;
        $ldap_result_dept = Setting::getSettings()->ldap_dept;
        $ldap_result_manager = Setting::getSettings()->ldap_manager;
        $ldap_default_group = Setting::getSettings()->ldap_default_group;

        try {
            $ldapconn = Ldap::connectToLdap();
            Ldap::bindAdminToLdap($ldapconn);
        } catch (\Exception $e) {
            if ($this->option('json_summary')) {
                $json_summary = ['error' => true, 'error_message' => $e->getMessage(), 'summary' => []];
                $this->info(json_encode($json_summary));
            }
            Log::info($e);

            return [];
        }

        $summary = [];

        try {
            if ($this->option('base_dn') != '') {
                $search_base = $this->option('base_dn');
                Log::debug('Importing users from specified base DN: \"'.$search_base.'\".');
            } else {
                $search_base = null;
            }
            if ($this->option('filter') != '') {
                $results = Ldap::findLdapUsers($search_base, -1, $this->option('filter'));
            } else {
                $results = Ldap::findLdapUsers($search_base);
            }
        } catch (\Exception $e) {
            if ($this->option('json_summary')) {
                $json_summary = ['error' => true, 'error_message' => $e->getMessage(), 'summary' => []];
                $this->info(json_encode($json_summary));
            }
            Log::info($e);

            return [];
        }

        /* Determine which location to assign users to by default. */
        $location = null; // TODO - this would be better called "$default_location", which is more explicit about its purpose

        if ($this->option('location') != '') {
            $location = Location::where('name', '=', $this->option('location'))->first();
            Log::debug('Location name '.$this->option('location').' passed');
            Log::debug('Importing to '.$location->name.' ('.$location->id.')');
        } elseif ($this->option('location_id') != '') {
            $location = Location::where('id', '=', $this->option('location_id'))->first();
            Log::debug('Location ID '.$this->option('location_id').' passed');
            Log::debug('Importing to '.$location->name.' ('.$location->id.')');
        }

        if (! isset($location)) {
            Log::debug('That location is invalid or a location was not provided, so no location will be assigned by default.');
        }

        /* Process locations with explicitly defined OUs, if doing a full import. */
        if ($this->option('base_dn') == '' && $this->option('filter') == '') {
            // Retrieve locations with a mapped OU, and sort them from the shallowest to deepest OU (see #3993)
            $ldap_ou_locations = Location::where('ldap_ou', '!=', '')->get()->toArray();
            $ldap_ou_lengths = [];

            foreach ($ldap_ou_locations as $ou_loc) {
                $ldap_ou_lengths[] = strlen($ou_loc['ldap_ou']);
            }

            array_multisort($ldap_ou_lengths, SORT_ASC, $ldap_ou_locations);

            if (count($ldap_ou_locations) > 0) {
                Log::debug('Some locations have special OUs set. Locations will be automatically set for users in those OUs.');
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
                    Log::info($e);

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

        $manager_cache = [];

        if($ldap_default_group != null) {

            $default = Group::find($ldap_default_group);
            if (!$default) {
                $ldap_default_group = null; // un-set the default group if that group doesn't exist
            }

        }


        for ($i = 0; $i < $results['count']; $i++) {
                $item = [];
                $item['username'] = $results[$i][$ldap_result_username][0] ?? '';
                $item['employee_number'] = $results[$i][$ldap_result_emp_num][0] ?? '';
                $item['lastname'] = $results[$i][$ldap_result_last_name][0] ?? '';
                $item['firstname'] = $results[$i][$ldap_result_first_name][0] ?? '';
                $item['email'] = $results[$i][$ldap_result_email][0] ?? '';
                $item['ldap_location_override'] = $results[$i]['ldap_location_override'] ?? '';
                $item['location_id'] = $results[$i]['location_id'] ?? '';
                $item['telephone'] = $results[$i][$ldap_result_phone][0] ?? '';
                $item['jobtitle'] = $results[$i][$ldap_result_jobtitle][0] ?? '';
                $item['country'] = $results[$i][$ldap_result_country][0] ?? '';
                $item['department'] = $results[$i][$ldap_result_dept][0] ?? '';
                $item['manager'] = $results[$i][$ldap_result_manager][0] ?? '';
                $item['location'] = $results[$i][$ldap_result_location][0] ?? '';

                // ONLY if you are using the "ldap_location" option *AND* you have an actual result
                if ($ldap_result_location && $item['location']) {
                        $location = Location::firstOrCreate([
                                'name' => $item['location'],
                        ]);
                }
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
                    $user->activated = 1; // newly created users can log in by default, unless AD's UAC is in use, or an active flag is set (below)
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
                $user->location_id = $location->id;

                if($item['manager'] != null) {
                    // Check Cache first
                    if (isset($manager_cache[$item['manager']])) {
                        // found in cache; use that and avoid extra lookups
                        $user->manager_id = $manager_cache[$item['manager']];
                    } else {
                        // Get the LDAP Manager
                        try {
                            $ldap_manager = Ldap::findLdapUsers($item['manager'], -1, $this->option('filter'));
                        } catch (\Exception $e) {
                            \Log::warning("Manager lookup caused an exception: " . $e->getMessage() . ". Falling back to direct username lookup");
                            // Hail-mary for Okta manager 'shortnames' - will only work if
                            // Okta configuration is using full email-address-style usernames
                            $ldap_manager = [
                                "count" => 1,
                                0 => [
                                    $ldap_result_username => [$item['manager']]
                                ]
                            ];
                        }

                        if ($ldap_manager["count"] > 0) {

                            // Get the Manager's username
                            // PHP LDAP returns every LDAP attribute as an array, and 90% of the time it's an array of just one item. But, hey, it's an array.
                            $ldapManagerUsername = $ldap_manager[0][$ldap_result_username][0];

                            // Get User from Manager username.
                            $ldap_manager = User::where('username', $ldapManagerUsername)->first();

                            if ($ldap_manager && isset($ldap_manager->id)) {
                                // Link user to manager id.
                                $user->manager_id = $ldap_manager->id;
                            }
                        }
                        $manager_cache[$item['manager']] = $ldap_manager && isset($ldap_manager->id)  ? $ldap_manager->id : null; // Store results in cache, even if 'failed'

                    }
                }

                // Sync activated state for Active Directory.
                if ( !empty($ldap_result_active_flag)) { // IF we have an 'active' flag set....
                    // ....then *most* things that are truthy will activate the user. Anything falsey will deactivate them.
                    // (Specifically, we don't handle a value of '0.0' correctly)
                    $raw_value = @$results[$i][$ldap_result_active_flag][0];
                    $filter_var = filter_var($raw_value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    $boolean_cast = (bool)$raw_value;

                    $user->activated = $filter_var ?? $boolean_cast; // if filter_var() was true or false, use that. If it's null, use the $boolean_cast

                } elseif (array_key_exists('useraccountcontrol', $results[$i]) ) {
                    // ....otherwise, (ie if no 'active' LDAP flag is defined), IF the UAC setting exists,
                    // ....then use the UAC setting on the account to determine can-log-in vs. cannot-log-in


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
                    '512',    //     0x200 NORMAL_ACCOUNT
                    '544',    //     0x220 NORMAL_ACCOUNT, PASSWD_NOTREQD
                    '66048',  //   0x10200 NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD
                    '66080',  //   0x10220 NORMAL_ACCOUNT, PASSWD_NOTREQD, DONT_EXPIRE_PASSWORD
                    '262656', //   0x40200 NORMAL_ACCOUNT, SMARTCARD_REQUIRED
                    '262688', //   0x40220 NORMAL_ACCOUNT, PASSWD_NOTREQD, SMARTCARD_REQUIRED
                    '328192', //   0x50200 NORMAL_ACCOUNT, SMARTCARD_REQUIRED, DONT_EXPIRE_PASSWORD
                    '328224', //   0x50220 NORMAL_ACCOUNT, PASSWD_NOT_REQD, SMARTCARD_REQUIRED, DONT_EXPIRE_PASSWORD
                    '4194816',//  0x400200 NORMAL_ACCOUNT, DONT_REQ_PREAUTH
                    '4260352', // 0x410200 NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD, DONT_REQ_PREAUTH
                    '1049088', // 0x100200 NORMAL_ACCOUNT, NOT_DELEGATED
                    '1114624', // 0x110200 NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD, NOT_DELEGATED,
                  ];
                    $user->activated = (in_array($results[$i]['useraccountcontrol'][0], $enabled_accounts)) ? 1 : 0;

                // If we're not using AD, and there isn't an activated flag set, activate all users
                } /* implied 'else' here - leave the $user->activated flag alone. Newly-created accounts will be active.
                already-existing accounts will be however the administrator has set them */


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
                    if ( $item['createorupdate'] === 'created' && $ldap_default_group) {
                         $user->groups()->attach($ldap_default_group);
                    }

                } else {
                    foreach ($user->getErrors()->getMessages() as $key => $err) {
                        $errors .= $err[0];
                    }
                    $item['note'] = $errors;
                    $item['status'] = 'error';
                }

                array_push($summary, $item);
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
