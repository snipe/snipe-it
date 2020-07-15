<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class ldap_troubleshooter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldap:troubleshoot 
                            {--force : Skip the interactive yes/no prompt for confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a series of non-destructive LDAP commands to help try and determine correct LDAP settings for your environment.';

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
        if(!$this->option('force')) {
            $confirmation = $this->confirm('WARNING: This command will make several attempts to connect to your LDAP server. Are you sure this is ok? (y/n)');
            if(!$confirmation) {
                $this->error('ABORTING');
                exit(-1);
            }
        }
        $settings = Setting::first();
        //$this->line(print_r($settings,true));
        $this->info("STAGE 1: Checking settings");
        if(!$settings->ldap_enabled) {
            $this->error("Snipe-IT's LDAP setting is not turned on. (That may be OK if you're still trying to figure out settings)");
        }

        $ldap_conn = false;
        try {
            $ldap_conn = ldap_connect($settings->ldap_server);
        } catch (\Exception $e) {
            $this->error("WARNING: Exception caught when executing 'ldap_connect()' - ".$e->getMessage().". We will try to guess.");
        }

        if(!$ldap_conn) {
            $this->error("WARNING: LDAP Server setting of: ".$settings->ldap_server." cannot be parsed. We will try to guess.");
            //exit(-1);
        }

        $parsed = parse_url($settings->ldap_server);

        if(@$parsed['scheme'] != 'ldap' && @$parsed['scheme'] != 'ldaps') {
            $this->error("WARNING: LDAP URL Scheme of '".@$parsed['scheme']."' is probably incorrect; should usually be ldap or ldaps");
        }

        if(!@$parsed['host']) {
            $this->error("ERROR: Cannot determine hostname or IP from ldap URL: ".$settings->ldap_server.". ABORTING.");
            exit(-1);
        } else {
            $this->info("Determined LDAP hostname to be: ".$parsed['host']);
        }

        $this->info("STAGE 2: Checking basic network connectivity");

    }
}
