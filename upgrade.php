<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('Access denied.');


echo "Welcome to the Snipe-IT upgrader.\n\n";

echo "If you have any encrypted custom fields, BE SURE TO run the recrypter. See the Snipe-IT documentation for help.\n\n";

echo "--------------------------------------------------------\n";
echo "STEP 1: Backing up database: \n";
echo "--------------------------------------------------------\n\n";
$backup = shell_exec('php artisan snipeit:backup');
echo '- '.$backup."\n\n";


echo "--------------------------------------------------------\n";
echo "STEP 2: Putting application into maintenance mode: \n";
echo "--------------------------------------------------------\n\n";
$down = shell_exec('php artisan down');
echo '- '.$down."\n\n";

echo "--------------------------------------------------------\n";
echo "Step 3: Cleaning up old cached files:\n";
echo "--------------------------------------------------------\n\n";


if (file_exists('bootstrap/cache/compiled.php')) {
    echo "-- Deleting bootstrap/cache/compiled.php. It it no longer used.\n";
    @unlink('bootstrap/cache/compiled.php');
} else {
    echo "-- No bootstrap/cache/compiled.php, so nothing to delete.\n";
}

if (file_exists('bootstrap/cache/services.php')) {
    echo "-- Deleting bootstrap/cache/services.php. It it no longer used.\n";
    @unlink('bootstrap/cache/services.php');
} else {
    echo "-- No bootstrap/cache/services.php, so nothing to delete.\n";
}

if (file_exists('bootstrap/cache/config.php')) {
    echo "-- Deleting bootstrap/cache/config.php. It it no longer used.\n";
    @unlink('bootstrap/cache/config.php');
} else {
    echo "-- No bootstrap/cache/config.php, so nothing to delete.\n";
}

$config_clear = shell_exec('php artisan config:clear');
$cache_clear = shell_exec('php artisan cache:clear');
echo '- '.$config_clear;
echo '- '.$cache_clear;

echo "\n";

echo "--------------------------------------------------------\n";
echo "Step 4: Updating composer dependencies :\n";
echo "--------------------------------------------------------\n\n";


// Composer install
if (file_exists('composer.phar')) {
    echo "- Local composer.phar detected, so we'll use that.\n\n";
    $composer = shell_exec('php composer.phar install --prefer-source');
} else {
    echo "- We couldn't find a local composer.phar - trying globally.\n\n";
    $composer = shell_exec('composer install --prefer-source');
}

echo $composer."\n\n";


echo "--------------------------------------------------------\n";
echo "Step 5: Migrating database:\n";
echo "--------------------------------------------------------\n\n";

$migrations = shell_exec('php artisan migrate --force');
echo '- '.$migrations."\n\n";


echo "--------------------------------------------------------\n";
echo "Step 6: Checking for OAuth keys:\n";
echo "--------------------------------------------------------\n\n";


if ((!file_exists('storage/oauth-public.key')) || (!file_exists('storage/oauth-private.key'))) {
    echo "- No OAuth keys detected. Running passport install now.\n\n";
    $passport = shell_exec('php artisan passport:install');
    echo $passport;
} else {
    echo "- OAuth keys detected. Skipping passport install.\n\n";
}


echo "--------------------------------------------------------\n";
echo "Step 7: Taking application out of maintenance mode:\n";
echo "--------------------------------------------------------\n\n";

$up = shell_exec('php artisan up');
echo '- '.$up."\n\n";





