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
                            {--ldap-search : Output an ldapsearch command-line for testing your LDAP config}
                            {--force : Skip the interactive yes/no prompt for confirmation}
                            {--debug : Include debuggin output (verbose)}';

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
     * Output something *only* if debug is enabled
     * 
     * @return void
     */
    public function debugout($string)
    {
        if($this->option('debug')) {
            $this->line($string);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings = Setting::getSettings();
        if($this->option('ldap-search')) {
            if(!$this->option('force')) {
                $confirmation = $this->confirm('WARNING: This command will display your LDAP password on your terminal. Are you sure this is ok?');
                if(!$confirmation) {
                    $this->error('ABORTING');
                    exit(-1);
                }
            }
            $output = [];
            if($settings->ldap_server_cert_ignore) {
                $this->line("# Ignoring server certificate validity");
                $output[] = "LDAPTLS_REQCERT=never";
            }
            $output[] = "ldapsearch";
            $output[] = $settings->ldap_server;
            $output[] = "-x";
            $output[] = "-b ".escapeshellarg($settings->ldap_basedn);
            $output[] = "-D ".escapeshellarg($settings->ldap_uname);
            $output[] = "-w ".escapeshellarg(\Crypt::Decrypt($settings->ldap_pword));
            if(substr($settings->ldap_filter,0,1) == "(" ) {
                $output[] = escapeshellarg($settings->ldap_filter);
            } else {
                $output[] = escapeshellarg("(".$settings->ldap_filter.")");
            }
            if($settings->ldap_tls) {
                $this->line("# adding STARTTLS option");
                $output[] = "-Z";
            }
            $output[] = "-v";
            $this->line("\n");
            $this->line(implode(" \\\n",$output));
            exit(0);
        }
        if(!$this->option('force')) {
            $confirmation = $this->confirm('WARNING: This command will make several attempts to connect to your LDAP server. Are you sure this is ok?');
            if(!$confirmation) {
                $this->error('ABORTING');
                exit(-1);
            }
        }
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
        $this->debugout("IP's? ".print_r($ips,true));
        foreach($ips as $ip) {
            if(!isset($ip['ip'])) {
                continue;
            }
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

        $this->info("STAGE 3: Determine encryption algorithm, if any");

        $ldap_urls = [];
        $pretty_ldap_urls = [];
        foreach($open_ports as $port) {
            $this->line("Trying TLS first for port $port");
            $ldap_url = "ldaps://".$parsed['host'].":$port";
            if($this->test_anonymous_bind($ldap_url)) {
                $this->info("Anonymous bind succesful to $ldap_url!");
                $ldap_urls[] = [ $ldap_url, true, false ];
                $pretty_ldap_urls[] = [ $ldap_url, "YES", "no" ];
                continue; // TODO - lots of copypasta in these if(test_anonymous_bind()) routines...
            } else {
                $this->error("WARNING: Failed to bind to $ldap_url - trying without certificate checks.");
            }

            if($this->test_anonymous_bind($ldap_url, false)) {
                $this->info("Anonymous bind succesful to $ldap_url with certifcate-checks disabled");
                $ldap_urls[] = [ $ldap_url, false, false ]; 
                $pretty_ldap_urls[] = [ $ldap_url, "no", "no" ]; 
                continue;
            } else {
                $this->error("WARNING: Failed to bind to $ldap_url with certificate checks disabled. Trying unencrypted with STARTTLS");
            }

            $ldap_url = "ldap://".$parsed['host'].":$port";
            if($this->test_anonymous_bind($ldap_url, true, true)) {
                $this->info("Plain connection to $ldap_url with STARTTLS succesful!");
                $ldap_urls[] = [ $ldap_url, true, false ];
                $pretty_ldap_urls[] = [ $ldap_url, "YES", "no" ];
                continue;
            } else {
                $this->error("WARNING: Failed to bind to $ldap_url with STARTTLS enabled. Trying without STARTTLS");
            }

            if($this->test_anonymous_bind($ldap_url)) {
                $this->info("Plain connection to $ldap_url succesful!");
                $ldap_urls[] = [ $ldap_url, true, false ];
                $pretty_ldap_urls[] = [ $ldap_url, "YES", "no" ];
                continue;
            } else {
                $this->error("WARNING: Failed to bind to $ldap_url. Giving up on port $port");
            }
        }

        $this->debugout(print_r($ldap_urls,true));

        if(count($ldap_urls) > 0 ) {
            $this->info("Found working LDAP URL's: ");
            foreach($ldap_urls as $ldap_url) { // TODO maybe do this as a $this->table() instead?
                $this->info("LDAP URL: ".$ldap_url[0]);
                $this->info($ldap_url[0]. ($ldap_url[1] ? " certificate checks enabled" : " certificate checks disabled"). ($ldap_url[2] ? " STARTTLS Enabled ": " STARTTLS Disabled"));
            }
            $this->table(["URL", "Cert Checks Enabled?", "STARTTLS Enabled?"],$pretty_ldap_urls);
        } else {
            $this->error("ERROR - no valid LDAP URL's available - ABORTING");
        }

        $this->info("STAGE 4: Test Administrative Bind for LDAP Sync");
        foreach($ldap_urls AS $ldap_url) {
            $this->test_authed_bind($ldap_url[0], $ldap_url[1], $ldap_url[2], $settings->ldap_uname, \Crypt::decrypt($settings->ldap_pword));
        }

        $this->info("STAGE 5: Test BaseDN");
        foreach($ldap_urls AS $ldap_url) {
            $conn = $this->test_authed_bind($ldap_url[0], $ldap_url[1], $ldap_url[2], $settings->ldap_uname, \Crypt::decrypt($settings->ldap_pword));
            if($conn) {
            $result = ldap_read($conn, '', '(objectClass=*)'/* , ['supportedControl']*/);
                $results = ldap_get_entries($conn, $result);
                $cleaner = function ($array) {
                    /* 
                    */
                    $all_defined_constants = get_defined_constants();
                    $ldap_constants = [];
                    foreach($all_defined_constants AS $key => $val) {
                        if(starts_with($key,"LDAP_") && is_string($val)) {
                            $ldap_constants[$val] = $key; // INVERT the meaning here!
                        }
                    }
                    $this->info("LDAP constants are: ".print_r($ldap_constants,true));

                    $cleaned = [];
                    for($i = 0; $i < $array['count']; $i++) {
                        $row = $array[$i];
                        $clean_row = [];
                        foreach($row AS $key => $val ) {
                            print("Key is: ".$key);
                            if($key == "count" || is_int($key) || $key == "dn") {
                                print(" and we're gonna skip it\n");
                                continue;
                            }
                            print(" And that seems fine.\n");
                            if(array_key_exists('count',$val)) {
                                if($val['count'] == 1) {
                                    $clean_row[$key] = $val[0];
                                } else {
                                    unset($val['count']); //these counts are annoying
                                    $elements = [];
                                    foreach($val as $entry) {
                                        if(isset($ldap_constants[$entry])) {
                                            $elements[] = $ldap_constants[$entry];
                                        } else {
                                            $elements[] = $entry;
                                        }
                                    }
                                    $clean_row[$key] = $elements;
                                }
                            } else {
                                $clean_row[$key] = $val;
                            }
                        }
                        $cleaned[$i] = $clean_row;
                    }
                    return $cleaned;
                };
                print_r($cleaner($results));
                exit(99);

                $search_results = ldap_search($conn,$settings->base_dn,$settings->filter);
            }
        }

        $this->info("STAGE 6: Test LDAP Login to Snipe-IT");
        foreach($ldap_urls AS $ldap_url) {
            $this->info("Starting auth to ".$ldap_url[0]);
            while(true) {
                if(!$this->confirm('Do you wish to try to authenticate to the directory?')) {
                    break;
                }
                $username = $this->ask("Username");
                $password = $this->secret("Password");
                $this->test_authed_bind($ldap_url[0], $ldap_url[1], $ldap_url[2], $username, $password); // FIXME - should do some other stuff here, maybe with the concatenating or something?
            }
        }

        $this->info("LDAP TROUBLESHOOTING COMPLETE!");
    }

    public function connect_to_ldap($ldap_url, $check_cert, $start_tls) 
    {
        $lconn = ldap_connect($ldap_url);
        ldap_set_option($lconn,LDAP_OPT_PROTOCOL_VERSION,3); // should we 'test' different protocol versions here? Does anyone even use anything other than LDAPv3?
                                                             // no - it's formally deprecated: https://tools.ietf.org/html/rfc3494
        if(!$check_cert) {
            putenv('LDAPTLS_REQCERT=never'); // This is horrible; is this *really* the only way to do it?
        } else {
            putenv('LDAPTLS_REQCERT'); // have to very explicitly and manually *UN* set the env var here to ensure it works
        }
        if($start_tls) {
            if(!ldap_start_tls($lconn)) {
                $this->error("WARNING: Unable to start TLS");
                return false;
            }
        }
        if(!$lconn) {
            $this->error("WARNING: Failed to generate connection string - using: ".$ldap_url);
            return false;
        }
        return $lconn;
    }

    public function test_anonymous_bind($ldap_url, $check_cert = true, $start_tls = false)
    {
        try {
            $lconn = $this->connect_to_ldap($ldap_url,$check_cert,$start_tls);
            return ldap_bind($lconn);
        } catch (Exception $e) {
            $this->error("WARNING: Exception caught during bind - ".$e->getMessage());
            return false;
        }
    }

    public function test_authed_bind($ldap_url, $check_cert, $start_tls, $username, $password) 
    {
        try {
            $lconn = $this->connect_to_ldap($ldap_url,$check_cert,$start_tls);
            $bind_results = ldap_bind($lconn,$username,$password);
            if(!$bind_results) {
                $this->error("WARNING: Failed to bind to $ldap_url as $username");
                return false;
            } else {
                $this->info("SUCCESS - Able to bind to $ldap_url as $username");
                return $lconn;
            }
        } catch (Exception $e) {
            $this->error("WARNING: Exception caught during Admin bind - ".$e->getMessage());
            return false;
        }
    }
}
