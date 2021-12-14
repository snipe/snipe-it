<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ldap;
use Log;
use App\Models\Group;
use App\Models\User;
use App\Helpers\Helper;

/**
* @copyright: Copyright (c) 2021 Elektrobit Automotive GmbH
*/

class LdapGroupSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:ldap-group-sync {--base_dn=} {--summary} {--json_summary}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command line LDAP User Group sync';

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
        ini_set('memory_limit', env('LDAP_MEM_LIM', '1G'));

        try {
            $ldapconn = Ldap::connectToLdap();
            Ldap::bindAdminToLdap($ldapconn);
        } catch (\Exception $e) {
            if ($this->option('json_summary')) {
                $json_summary = [ "error" => true, "error_message" => $e->getMessage(), "summary" => [] ];
                $this->info(json_encode($json_summary));
            }
            LOG::info($e);
            return [];
        }

        $summary = array();

        try {
            if ($this->option('base_dn') != '') {
                $search_base = $this->option('base_dn');
                LOG::debug('Importing users from specified base DN: \"'.$search_base.'\".');
            } else {
                $search_base = null;
            }
            $results = Ldap::findLdapUsersGroups($search_base);
        } catch (\Exception $e) {
            if ($this->option('json_summary')) {
                $json_summary = [ "error" => true, "error_message" => $e->getMessage(), "summary" => [] ];
                $this->info(json_encode($json_summary));
            }
            LOG::info($e);
            return [];
        }
       
        //Log::debug($results);
        for ($i = 0; $i < $results["count"]; $i++) {
            $item = array();
            $grpName = $results[$i]["name"][0];
            
            $group = Group::where('name', $grpName)->first();
            
            if ($group) {
                // Updating an existing group.

                $permissions = config('permissions');
                $groupPermissions = $group->decodePermissions();
                $selectedPermissions = Helper::selectedPermissionsArray($permissions, $groupPermissions);
                $group->permissions = json_encode($selectedPermissions);
                $item["createorupdate"] = 'updated';

                //$re = Ldap::findLdapUsersGroupsMembers($search_base);
                
                // if(isset($results[$i]["member"])){
                //     $members = $results[$i]["member"][0];
                    
                //     // foreach($members as $member){
                        
                //     //     Log::debug($member);
                //     // }
                //     Log::debug($members);
                //     // $user = User::find('cn=John Doe,dc=local,dc=com');
                //     // if($user){
                //     //    // $user->groups()->sync($da,false);
                //     // }
                //    // $user = User::where('username', $item["username"])->first();
                // }
                
            } else {
                // Creating a new group.
                $group = new Group;

                $permissions = config('permissions');
                $selectedPermissions = Helper::selectedPermissionsArray($permissions, $permissions);
                $group->permissions = json_encode($selectedPermissions);
                
                $item["createorupdate"] = 'created';
            }

            $group->name = $grpName;
           
            if ($group->save()) {
                $item["note"] = $item["createorupdate"];
                $item["status"]='success';
            } else {
                foreach ($group->getErrors()->getMessages() as $key => $err) {
                    $errors .= $err[0];
                }
                $item["note"] = $errors;
                $item["status"]='error';
            }

            array_push($summary, $item);
        }

        if ($this->option('summary')) {
            for ($x = 0; $x < count($summary); $x++) {
                if ($summary[$x]['status']=='error') {
                    $this->error('ERROR: '.$summary[$x]['name'].') was not imported: '.$summary[$x]['note']);
                } else {
                    $this->info('Group '.$summary[$x]['name'].') was '.strtoupper($summary[$x]['createorupdate']).'.');
                }
            }
        } else if ($this->option('json_summary')) {
            $json_summary = [ "error" => false, "error_message" => "", "summary" => $summary ]; // hardcoding the error to false and the error_message to blank seems a bit weird
            $this->info(json_encode($json_summary));
        } else {
            return $summary;
        }
        
    }
}
