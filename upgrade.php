<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('Access denied.');

$required_php_min = '7.4.0';

if ((strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') || (!function_exists('posix_getpwuid'))) {
	echo "Skipping user check as it is not supported on Windows or Posix is not installed on this server. \n";
} else {
	$pwu_data = posix_getpwuid(posix_geteuid());
	$username = $pwu_data['name'];

	if (($username=='root') || ($username=='admin')) {
		die("\nERROR: This script should not be run as root/admin. Exiting.\n\n");
	}
}


$app_environment = 'develop';

// Check if a branch or tag was passed in the command line,
// otherwise just use master
(array_key_exists('1', $argv)) ? $branch = $argv[1] : $branch = 'master';

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



echo "--------------------------------------------------------\n";
echo "STEP 1: Checking .env file: \n";
echo "- Your .env is located at ".getcwd()."/.env \n";
echo "--------------------------------------------------------\n\n";


// Check the .env looks ok
$env = file('.env');
$env_error_count = 0;
$env_good = '';
$env_bad = '';

// Loop through each line of the .env
foreach ($env as $line_num => $line) {

    if ((strlen($line) > 1) && (strpos($line, "#") !== 0)) {

        list ($env_key, $env_value) = $env_line = explode('=', $line);

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
                $env_bad .= "✘ APP_KEY ERROR in your .env on line #'.$show_line_num.': Your APP_KEY should not be blank. Run `php artisan key:generate` to generate one.\n";
            } else {
                $env_good .= "√ Your APP_KEY is not blank. \n";
            }
        }

        if ($env_key == 'APP_URL') {

            $app_url_length = strlen($env_value);

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

    echo "\n--------------------- !! ERROR !! ----------------------\n";
    echo "Your .env file is misconfigured. Upgrade cannot continue.\n";
    echo "--------------------------------------------------------\n\n";
    echo $env_bad;
    echo "\n\n--------------------------------------------------------\n";
    echo "ABORTING THE INSTALLER  \n";
    echo "Please correct the issues above in ".getcwd()."/.env and try again.\n";
    echo "--------------------------------------------------------\n";
    exit;
}


echo "\n--------------------------------------------------------\n";
echo "STEP 2: Checking PHP requirements: \n";
echo "--------------------------------------------------------\n\n";

if (version_compare(PHP_VERSION, $required_php_min, '<')) {
    echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ERROR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n";
    echo "This version of PHP (".PHP_VERSION.") is not compatible with Snipe-IT.\n";
    echo "Snipe-IT requires PHP version ".$required_php_min." or greater. Please upgrade \n";
    echo "your version of PHP (web/php-fcgi and cli) and try running this script again.\n\n\n";
    exit;

} else {
    echo "Current PHP version: (" . PHP_VERSION . ") is at least ".$required_php_min." - continuing... \n";
    echo sprintf("FYI: The php.ini used by this PHP is: %s\n\n", get_cfg_var('cfg_file_path'));
}


echo "Checking Required PHP extensions... \n\n";

// Get the list of installed extensions
$loaded_exts_array = get_loaded_extensions();

// The PHP extensions PHP is *required* to have enabled in order to run
$required_exts_array =
    [
        'bcmath',
        'curl',
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

            // Now loop through the either/or array and see whether any of the options match
            foreach ($require_either as $require_either_value) {

                if (in_array($require_either_value, $loaded_exts_array)) {
                    $ext_installed .=  '√ '.$require_either_value." is installed!\n";
                    break;
                // If no match, add it to the string for errors
                } else {
                    $ext_missing .=  '✘ MISSING PHP EXTENSION: '.str_replace("|", " OR ", $required_ext)."\n";
                    break;
                }
            }

        // If this isn't an either/or option, just add it to the string of errors conventionally
        } else {
            $ext_missing .=  '✘ MISSING PHP EXTENSION: '.$required_ext."\n";
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
    exit;
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
}



echo "--------------------------------------------------------\n";
echo "STEP 4: Backing up database: \n";
echo "--------------------------------------------------------\n\n";
$backup = shell_exec('php artisan snipeit:backup');
echo '-- '.$backup."\n\n";

echo "--------------------------------------------------------\n";
echo "STEP 5: Putting application into maintenance mode: \n";
echo "--------------------------------------------------------\n\n";
$down = shell_exec('php artisan down');
echo '-- '.$down."\n";


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
    return 0 === substr_compare($haystack, $needle, 0, strlen($needle));
}

function str_ends($haystack,  $needle) {
    return 0 === substr_compare($haystack, $needle, -strlen($needle));
}



