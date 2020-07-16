<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Exception;

/**
 * Check if a given ip is in a network
 * @param  string $ip    IP to check in IPV4 format eg. 127.0.0.1
 * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
 * @return boolean true if the ip is in this range / false if not.
 */
function ip_in_range( $ip, $range ) {
	if ( strpos( $range, '/' ) == false ) {
		$range .= '/32';
	}
	// $range is in IP/CIDR format eg 127.0.0.1/24
	list( $range, $netmask ) = explode( '/', $range, 2 );
	$range_decimal = ip2long( $range );
	$ip_decimal = ip2long( $ip );
	$wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
	$netmask_decimal = ~ $wildcard_decimal;
	return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
}
// NOTE - this function was shamelessly stolen from this gist: https://gist.github.com/tott/7684443

class LdapTroubleshooter extends Command
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
            $this->error("WARNING: Snipe-IT's LDAP setting is not turned on. (That may be OK if you're still trying to figure out settings)");
        }

        $ldap_conn = false;
        try {
            $ldap_conn = ldap_connect($settings->ldap_server);
        } catch (Exception $e) {
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

        $this->info("Performing DNS lookup of: ".$parsed['host']);
        $ips = dns_get_record($parsed['host']);
        $raw_ips = [];

        //$this->info("Host IP is: ".print_r($ips,true));

        if(!$ips || count($ips) == 0) {
            $this->error("ERROR: DNS lookup of host: ".$parsed['host']." has failed. ABORTING.");
            exit(-1);
        }
        foreach($ips as $ip) {
            $raw_ips[]=$ip['ip'];
            if($ip['ip'] == "127.0.0.1") {
                $this->error("WARNING: Using the localhost IP as the LDAP server. This is usually wrong");
            }
            if(ip_in_range($ip['ip'],'10.0.0.0/8') || ip_in_range($ip['ip'],'192.168.0.0/16') || ip_in_range($ip['ip'], '172.16.0.0/12')) {
                $this->error("WARNING: Using an RFC1918 Private address for LDAP server. This may be correct, but it can be a problem if your Snipe-IT instance is not hosted on your private network");
            }
        }

        $this->info("STAGE 2: Checking basic network connectivity");
        $ports = [389,636];
        if(@$parsed['port'] && !in_array($parsed['port'],$ports)) {
            $ports[] = $parsed['port'];
        }

        $open_ports=[];
        foreach($ports as $port ) {
            $errno = 0;
            $errstr = '';
            $timeout = 30.0;
            $result = '';
            $this->info("Attempting to connect to port: ".$port." - may take up to $timeout seconds");
            try {
                $result = fsockopen($parsed['host'], $port, $errno, $errstr, 30.0);
            } catch(Exception $e) {
                $this->error("Exception: ".$e->getMessage());
            }
            if($result) {
                $this->info("Success!");
                $open_ports[] = $port;
            } else {
                $this->error("WARNING: Cannot connect to port: $port - $errstr ($errno)");
            }
        }

        if(count($open_ports) == 0) {
            $this->error("ERROR - no open ports. ABORTING.");
            exit(-1);
        }
    }
}
