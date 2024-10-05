<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('Access denied.');

// We define this because we can't reliably use file_get_contents because some
// machines don't allow URL access via allow_url_fopen being set to off
function url_get_contents ($Url) {
    $results = file_get_contents($Url);
    if ($results) {
        return $results;
    }
    print("file_get_contents() failed, trying curl instead.\n");
    if (!function_exists('curl_init')){
        die("cURL is not installed!\nThis is required for Snipe-IT as well as the upgrade script, so you will need to fix this before continuing.\nAborting upgrade...\n");
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // If we're on windows, make sure we can load intermediate certificates in
    // weird corporate environments.
    // See:  https://github.com/curl/curl/commit/2d6333101a71129a6a802eb93f84a5ac89e34479
    // this will _probably_ only work if your libcurl has been linked to Schannel, the native Windows SSL implementation
    if (PHP_OS == "WINNT" && defined("CURLOPT_SSL_OPTIONS") && defined("CURLSSLOPT_NATIVE_CA")) {
        curl_setopt($ch, CURLOPT_SSL_OPTIONS, CURLSSLOPT_NATIVE_CA);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    if ($output === false) {
        print("Error retrieving PHP requirements!\n");
        print("Error was: " . curl_error($ch) . "\n");
        print("Try enabling allow_url_fopen in php.ini, or fixing your curl/OpenSSL setup, or try rerunning with --skip-php-compatibility-checks");
        return '{}';
    }
    return $output;
}

$app_environment = 'develop';
$skip_php_checks = false;
$branch = 'master';
$branch_override = false;
$no_interactive = false;

// Check for branch or other overrides
if ($argc > 1){
    for ($arg=1; $arg<$argc; $arg++){
        switch ($argv[$arg]) {
            case '--skip-php-compatibility-checks':
                $skip_php_checks = true;
                break;
            case '--branch':
                $arg++;
                $branch = $argv[$arg];
                $branch_override = true;
                break;
            case '--no-interactive':
                $no_interactive = true;
                break;
            default: // for legacy support from before we started using --branch
                $branch = $argv[$arg];
                $branch_override = true;
                break;
        }
    }
}

echo "--------------------------------------------------------\n";
echo "WELCOME TO THE SNIPE-IT UPGRADER! \n";
echo "--------------------------------------------------------\n\n";
echo "This script will attempt to: \n\n";
echo "- validate some very basic .env file settings \n";
echo "- check your PHP version and extension requirements \n";
echo "- check directory permissions \n";
echo "- do a git pull to bring you to the latest version \n";
echo "- run composer install to get your vendors up to date \n";
echo "- run migrations to get your schema up to date \n";
echo "- clear out old cache settings\n\n";


// Fetching most current upgrade requirements from github. Read more here: https://github.com/snipe/snipe-it/pull/14127
$remote_requirements_file = "https://raw.githubusercontent.com/snipe/snipe-it/$branch/.upgrade_requirements.json";
$upgrade_requirements_raw = url_get_contents($remote_requirements_file);
$upgrade_requirements = json_decode($upgrade_requirements_raw, true);
if (! $upgrade_requirements) {
    if(!$skip_php_checks){
        echo "\nERROR: Failed to retrieve remote requirements from $remote_requirements_file\n\n";
        if ($branch_override){
            echo "NOTE: You passed a custom branch: $branch\n";
            echo "   If the above URL doesn't work, that may be why. Please check you branch spelling/existence\n\n";
        }

        if (json_last_error()) {
            print "JSON DECODE ERROR DETECTED:\n";
            print json_last_error_msg() . "\n\n";
            print "Raw curl output:\n";
            print $upgrade_requirements_raw . "\n\n";
        }

        echo "We suggest correcting this, but if you can't,  please verify that your requirements conform to those at that url.\n\n";
        echo " -- DANGER -- DO AT YOUR OWN RISK --\n";
        echo "      IF YOU ARE SURE, re-run this script with --skip-php-compatibility-checks to skip this check.\n";
        echo " -- DANGER -- THIS COULD BREAK YOUR INSTALLATION";
        die("Exiting.\n\n");
    }
    echo "NOTICE: Unable to fetch upgrade requirements, but continuing because you passed --skip-php-compatibility-checks...\n";
}

echo "Launching using branch: $branch\n";

if($upgrade_requirements){
    $php_min_works = $upgrade_requirements['php_min_version'];
    $php_max_wontwork = $upgrade_requirements['php_max_wontwork'];
    echo "Found PHP requirements, will check for PHP > $php_min_works and < $php_max_wontwork\n";
}
// done fetching requirements

if (!$no_interactive) {
    $yesno = readline("\nProceed with upgrade? [y/N]: ");
} else {
    $yesno = "yes";
}

if ($yesno == "yes" || $yesno == "YES" ||$yesno == "y" ||$yesno == "Y"){
    # don't do anything
} else {
    die("Exiting.\n\n");
}

echo "\n";

if ((strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') || (!function_exists('posix_getpwuid'))) {
	echo "Skipping user check as it is not supported on Windows or Posix is not installed on this server. \n";
} else {
	$pwu_data = posix_getpwuid(posix_geteuid());
	$username = $pwu_data['name'];

	if (($username=='root') || ($username=='admin')) {
		die("\nERROR: This script should not be run as root/admin. Exiting.\n\n");
	}
}



echo "--------------------------------------------------------\n";
echo "STEP 1: Checking .env file: \n";
echo "- Your .env is located at ".getcwd()."/.env \n";
echo "--------------------------------------------------------\n\n";


// Check the .env looks ok
$env = file('.env');
if (! $env){
    echo "\n!!!!!!!!!!!!!!!!!!!!!!!!!! .ENV FILE ERROR !!!!!!!!!!!!!!!!!!!!!!!!!!\n";
    echo "Your .env file doesn't seem to exist in this directory or isn't readable! Please look into that.\n";
    exit(1);
}

$env_good = '';
$env_bad = '';

// Loop through each line of the .env
foreach ($env as $line_num => $line) {

    if ((strlen($line) > 1) && (strpos($line, "#") !== 0)) {

        $env_line = explode('=', $line, 2);
        if (count($env_line) != 2) {
            continue;
        }
        list ($env_key, $env_value) = $env_line;

        // The array starts at 0
        $show_line_num = $line_num+1;

        $env_value = trim($env_value);

        // Strip out the quote marks if there are any
        $env_value = str_replace('"', '',$env_value);
        $env_value = str_replace("'", '',$env_value);


        /**
         * We set this $app_environment here to determine which version of composer to use, --no-dev or with dev dependencies.
         * This doesn't actually *change* anything in the .env file, but if the user is running this with
         * APP_ENV set to anything OTHER than production, they'll get an error when they try to dump-autoload
         * because the Dusk service provider only tries to load if the app is not in production mode.
         *
         * It's 100% okay if they're not in production mode, but this will avoid any confusion as they get
         * erroneous errors using this upgrader if they are not in production mode when they run this script.
         *
         * We use this further down in the composer section of this upgrader.
         */

        if ($env_key == "APP_ENV") {
            if ($env_value == 'production') {
                $app_environment = 'production';
            }
        }


        if ($env_key == 'APP_KEY') {
            if (($env_value=='')  || (strlen($env_value) < 20)) {
                $env_bad .= "✘ APP_KEY ERROR in your .env on line #'.{$show_line_num}.': Your APP_KEY should not be blank. Run `php artisan key:generate` to generate one.\n";
            } else {
                $env_good .= "√ Your APP_KEY is not blank. \n";
            }
        }

        if ($env_key == 'APP_URL') {

            if (($env_value!="null") && ($env_value!="")) {
                $env_good .= '√ Your APP_URL is not null or blank. It is set to '.$env_value."\n";

                if (!str_begins(trim($env_value), 'http://') && (!str_begins($env_value, 'https://'))) {
                    $env_bad .= '✘ APP_URL ERROR in your .env on line #'.$show_line_num.': Your APP_URL should start with https:// or http://!! It is currently set to: '.$env_value;
                } else {
                    $env_good .= '√ Your APP_URL is set to '.$env_value.' and starts with the protocol (https:// or http://)'."\n";
                }

                if (str_ends(trim($env_value), "/")) {
                    $env_bad .= '✘ APP_URL ERROR in your .env on line #'.$show_line_num.': Your APP_URL should NOT end with a trailing slash. It is currently set to: '.$env_value;
                } else {
                    $env_good .= '√ Your APP_URL ('.$env_value.') does not have a trailing slash.'."\n";
                }


            } else {
                $env_bad .= "✘ APP_URL ERROR in your .env on line #".$show_line_num.": Your APP_URL CANNOT be set to null or left blank.\n";
            }

        }


    }

}

echo $env_good;

if ($env_bad !='') {

    echo "!!!!!!!!!!!!!!!!!!!!!!!!!! .ENV FILE ERROR !!!!!!!!!!!!!!!!!!!!!!!!!!\n";
    echo "Your .env file is misconfigured. Upgrade cannot continue.\n";
    echo "--------------------------------------------------------\n\n";
    echo $env_bad;
    echo "\n\n--------------------------------------------------------\n";
    echo "!!!!!!!!!!!!!!!!!!!!!!!!! ABORTING THE UPGRADER !!!!!!!!!!!!!!!!!!!!!!\n";
    echo "Please correct the issues above in ".getcwd()."/.env and try again.\n";
    echo "--------------------------------------------------------\n";
    exit(1);
}


if(!$skip_php_checks){
    echo "\n--------------------------------------------------------\n";
    echo "STEP 2: Checking PHP requirements: (Required PHP >=". $php_min_works. " - <".$php_max_wontwork.") \n";
    echo "--------------------------------------------------------\n\n";

    if ((version_compare(phpversion(), $php_min_works, '>=')) && (version_compare(phpversion(), $php_max_wontwork, '<'))) {

        echo "√ Current PHP version: (" . phpversion() . ") is at least " . $php_min_works . " and less than ".$php_max_wontwork."! Continuing... \n";
        echo sprintf("FYI: The php.ini used by this PHP is: %s\n\n", get_cfg_var('cfg_file_path'));

    } else {
        echo "!!!!!!!!!!!!!!!!!!!!!!!!! PHP VERSION ERROR !!!!!!!!!!!!!!!!!!!!!!!!!\n";
        echo "This version of PHP (".phpversion().") is NOT compatible with Snipe-IT.\n";
        echo "Snipe-IT requires PHP versions between ".$php_min_works." and ".$php_max_wontwork.".\n";
        echo "Please install a compatible version of PHP and re-run this script again. \n";
        echo "!!!!!!!!!!!!!!!!!!!!!!!!! ABORTING THE UPGRADER !!!!!!!!!!!!!!!!!!!!!!\n";
        exit(1);
    }
}
echo "Checking Required PHP extensions... \n\n";

// Get the list of installed extensions
$loaded_exts_array = get_loaded_extensions();

// The PHP extensions PHP is *required* to have enabled in order to run
$required_exts_array =
    [
        'bcmath',
        'curl',
        'exif',
        'fileinfo',
        'gd|imagick',
        'json',
        'ldap',
        'mbstring',
        'mysqli|pgsql',
        'openssl',
        'PDO',
        'sodium',
        'tokenizer',
        'xml',
        'zip',
    ];

$recommended_exts_array =
    [
        'sodium', //note that extensions need to be in BOTH the $required_exts_array and this one to be 'optional'
    ];
$ext_missing = '';
$ext_installed = '';

// Loop through the required extensions
foreach ($required_exts_array as $required_ext) {

    // If we don't find the string in the array....
    if (!in_array($required_ext, $loaded_exts_array)) {

        // Let's check for any options with pipes in them - those mean you can have either or
        if (strpos($required_ext, '|')) {

            // Split the either/ors by their pipe and put them into an array
            $require_either = explode("|", $required_ext);

            $has_one_required_ext = false;

            // Now loop through the either/or array and see whether any of the options match
            foreach ($require_either as $require_either_value) {

                if (in_array($require_either_value, $loaded_exts_array)) {
                    $ext_installed .=  '√ '.$require_either_value." is installed!\n";
                    $has_one_required_ext = true;
                    break;
                }
            }

            // If no match, add it to the string for errors
            if (!$has_one_required_ext) {
                $ext_missing .= '✘ MISSING PHP EXTENSION: '.str_replace("|", " OR ", $required_ext)."\n";
                break;
            }

        // If this isn't an either/or option, just add it to the string of errors conventionally
        } elseif (!in_array($required_ext, $recommended_exts_array)){
            $ext_missing .=  '✘ MISSING PHP EXTENSION: '.$required_ext."\n";
        } else {
            $ext_installed .= '- '.$required_ext." is *NOT* installed, but is recommended...\n";
        }

    // The required extension string was found in the array of installed extensions - yay!
    } else {
        $ext_installed .=  '√ '.$required_ext." is installed!\n";
    }
}

// Print out a useful error message and abort the install
if ($ext_missing!='') {
    echo "--------------------------------------------------------\n";
    echo "You have the following extensions installed: \n";
    echo "--------------------------------------------------------\n";

    foreach ($loaded_exts_array as $loaded_ext) {
       echo "- ".$loaded_ext."\n";
    }

    echo "--------------------- !! ERROR !! ----------------------\n";
    echo $ext_missing;
    echo "--------------------------------------------------------\n";
    echo "ABORTING THE INSTALLER  \n";
    echo "Please install the extensions above and re-run this script.\n";
    echo "--------------------------------------------------------\n";
    exit(1);
} else {
    echo $ext_installed."\n";

}



echo "--------------------------------------------------------\n";
echo "STEP 3: Checking directory permissions: \n";
echo "--------------------------------------------------------\n\n";


$writable_dirs_array =
    [
        'bootstrap/cache',
        'storage',
        'storage/logs',
        'storage/logs/laravel.log',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/app',
        'storage/app/backups',
        'storage/app/backup-temp',
        'storage/private_uploads',
        'public/uploads',
    ];

$dirs_writable = '';
$dirs_not_writable = '';

// Loop through the directories that need to be writable
foreach ($writable_dirs_array as $writable_dir) {
    if (is_writable($writable_dir)) {
        $dirs_writable .= '√ '.getcwd().'/'.$writable_dir." is writable \n";
    } else {
        $dirs_not_writable .= '✘ PERMISSIONS ERROR: '.getcwd().'/'.$writable_dir." is NOT writable\n";
    }
}

echo $dirs_writable."\n";

// Print out a useful error message
if ($dirs_not_writable!='') {
    echo "--------------------------------------------------------\n";
    echo "The following directories/files do not seem writable: \n";
    echo "--------------------------------------------------------\n";

    echo $dirs_not_writable;

    echo "--------------------- !! ERROR !! ----------------------\n";
    echo "Please check the permissions on the directories above and re-run this script.\n";
    echo "------------------------- :( ---------------------------\n\n";
    exit(1);
}



echo "--------------------------------------------------------\n";
echo "STEP 4: Backing up database: \n";
echo "--------------------------------------------------------\n\n";
$backup = exec('php artisan snipeit:backup', $backup_results, $return_code);
echo '-- ' . implode("\n", $backup_results) . "\n\n";
if ($return_code > 0) {
    die("Something went wrong with your backup. Aborting!\n\n");
}
unset($return_code);

echo "--------------------------------------------------------\n";
echo "STEP 5: Putting application into maintenance mode: \n";
echo "--------------------------------------------------------\n\n";
exec('php artisan down',  $down_results, $return_code);
echo '-- ' . implode("\n", $down_results) . "\n";
if ($return_code > 0) {
    die("Something went wrong with downing you site. This can't be good. Please investigate the error. Aborting!n\n");
}
unset($return_code);


echo "--------------------------------------------------------\n";
echo "STEP 6: Pulling latest from Git (".$branch." branch): \n";
echo "--------------------------------------------------------\n\n";
$git_version = shell_exec('git --version');

if ((strpos('git version', $git_version)) === false) {
    echo "Git is installed. \n";
    $git_fetch = shell_exec('git fetch');
    $git_checkout = shell_exec('git checkout '.$branch);
    $git_stash = shell_exec('git stash');
    $git_pull = shell_exec('git pull');
    echo $git_fetch;
    echo '-- '.$git_stash;
    echo '-- '.$git_checkout;
    echo '-- '.$git_pull."\n";
} else {
    echo "Git is NOT installed. You can still use this upgrade script to run common \n";
    echo "migration commands, but you will have to manually download the updated files. \n\n";
    echo "Please note that this script will not download the latest Snipe-IT \n";
    echo "files for you unless you have git installed. \n";
    echo "It simply runs the standard composer, artisan, and migration \n";
    echo "commands needed to finalize the upgrade after. \n\n";

}


echo "--------------------------------------------------------\n";
echo "STEP 7: Cleaning up old cached files:\n";
echo "--------------------------------------------------------\n\n";

// Build an array of the files we generally want to delete because they
// can cause issues with funky caching
$unused_files = [
    "bootstrap/cache/compiled.php",
    "bootstrap/cache/services.php",
    "bootstrap/cache/config.php",
    "vendor/symfony/translation/TranslatorInterface.php",
];

foreach ($unused_files as $unused_file) {
    if (file_exists($unused_file)) {
        echo "√ Deleting ".$unused_file.". It is no longer used.\n";
        @unlink($unused_file);
    } else {
        echo "√ No ".$unused_file.", so nothing to delete.\n";
    }
}
echo "\n";

$config_clear = shell_exec('php artisan config:clear');
$cache_clear = shell_exec('php artisan cache:clear');
$route_clear = shell_exec('php artisan route:clear');
$view_clear = shell_exec('php artisan view:clear');
echo '-- '.$config_clear;
echo '-- '.$cache_clear;
echo '-- '.$route_clear;
echo '-- '.$view_clear;
echo "\n";

echo "--------------------------------------------------------\n";
echo "STEP 8: Updating composer dependencies:\n";
echo "(This may take a moment.)\n";
echo "--------------------------------------------------------\n\n";
echo "-- Running the app in ".$app_environment." mode.\n";

// Composer install
if (file_exists('composer.phar')) {
    echo "√ Local composer.phar detected, so we'll use that.\n\n";
    echo "-- Updating local composer.phar\n\n";
    $composer_update = shell_exec('php composer.phar self-update');
    echo $composer_update."\n\n";



    // Use --no-dev only if we are in production mode.
    // This will cause errors otherwise, if the user is in develop or local for their APP_ENV
    if ($app_environment == 'production') {
        $composer = shell_exec('php composer.phar install --no-dev --prefer-source');
    } else {
        $composer = shell_exec('php composer.phar install --prefer-source');
    }
    $composer_dump = shell_exec('php composer.phar dump');



} else {

    echo "-- We couldn't find a local composer.phar. No worries, trying globally.\n";
    echo "Since you are running composer globally, we won't try to update it for you.\n";
    echo "If you run into issues with this step, try running `composer self-update` \n";
    echo "before running this updater again\n\n";

    if ($app_environment == 'production') {
        $composer = shell_exec('composer install --no-dev --prefer-source');
    } else {
        $composer = shell_exec('composer install --prefer-source');
    }

    $composer_dump = shell_exec('composer dump');



}

echo $composer_dump."\n";
echo $composer;


echo "--------------------------------------------------------\n";
echo "STEP 9: Migrating database:\n";
echo "--------------------------------------------------------\n\n";

$migrations = shell_exec('php artisan migrate --force');
echo $migrations."\n";


echo "--------------------------------------------------------\n";
echo "STEP 10: Checking for OAuth keys:\n";
echo "--------------------------------------------------------\n\n";


if ((!file_exists('storage/oauth-public.key')) || (!file_exists('storage/oauth-private.key'))) {
    echo "- No OAuth keys detected. Running passport install now.\n\n";
    $passport = shell_exec('php artisan passport:install');
    echo $passport;
} else {
    echo "√ OAuth keys detected. Skipping passport install.\n\n";
}


echo "--------------------------------------------------------\n";
echo "STEP 11: Taking application out of maintenance mode:\n";
echo "--------------------------------------------------------\n\n";

$up = shell_exec('php artisan up');
echo '-- '.$up."\n";



echo "---------------------- FINISHED! -----------------------\n";
echo "All done! Clear your browser cookies and re-login to use \n";
echo "your upgraded Snipe-IT!\n";
echo "--------------------------------------------------------\n\n";


function str_begins($haystack, $needle) {
    return (substr_compare($haystack, $needle, 0, strlen($needle)) === 0);
}

function str_ends($haystack,  $needle) {
    return (substr_compare($haystack, $needle, -strlen($needle)) === 0);
}



