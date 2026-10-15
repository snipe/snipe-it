<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Boost Master Switch
    |--------------------------------------------------------------------------
    |
    | This option may be used to disable all Boost functionality which will
    | prevent Boost's routes from being registered and will also disable
    | Boost's browser logging functionality from reading or operating.
    |
    */

    'enabled' => env('BOOST_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Boost Project Rules
    |--------------------------------------------------------------------------
    |
    | Project rules let agents write decisions, traps and standing constraints
    | as tracked Markdown in /.ai/rules/. Enabling "scoped_guidelines" also
    | moves path-scoped guidelines to .ai/rules/boost/ - it stays opt-in.
    |
    */

    'rules' => [
        'enabled' => true,
        'scoped_guidelines' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Guidelines
    |--------------------------------------------------------------------------
    |
    | Any guidelines listed here will be excluded whenever Boost composes your
    | AI guidelines during boost:install or boost:update. Entries match the
    | names shown within the boost:install summary, e.g. "livewire/core".
    |
    */

    'guidelines' => [
        'exclude' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Skills
    |--------------------------------------------------------------------------
    |
    | Any skills listed here will not be installed or synced to your agents
    | by boost:install and boost:update, e.g. "fluxui-development". Your
    | own skills within the ".ai/skills" directory are never excluded.
    |
    */

    'skills' => [
        'exclude' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Boost Executables Paths
    |--------------------------------------------------------------------------
    |
    | These options allow you to specify custom paths for the executables that
    | Boost uses. While configured, they take precedence over the automatic
    | discovery mechanism. When undefined, your system defaults are used.
    |
    */

    'executable_paths' => [
        'php' => env('BOOST_PHP_EXECUTABLE_PATH'),
        'composer' => env('BOOST_COMPOSER_EXECUTABLE_PATH'),
        'npm' => env('BOOST_NPM_EXECUTABLE_PATH'),
        'vendor_bin' => env('BOOST_VENDOR_BIN_EXECUTABLE_PATH'),
        'current_directory' => env('BOOST_CURRENT_DIRECTORY_EXECUTABLE_PATH'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Boost Browser Logs Watcher
    |--------------------------------------------------------------------------
    |
    | The following option may be used to enable or disable the browser logs
    | watcher feature within Laravel Boost. The log watcher will read any
    | errors within the browser's console to give Boost better context.
    |
    */

    'browser_logs_watcher' => env('BOOST_BROWSER_LOGS_WATCHER', true),

    /*
    |--------------------------------------------------------------------------
    | Browser Log Levels
    |--------------------------------------------------------------------------
    |
    | This option defines which browser console log levels will be captured by
    | Boost's browser logger. You may trim this list down to ['error'] when
    | warnings, info, and debug messages become too noisy to be relevant.
    |
    */

    'browser_log_levels' => explode(',', env('BOOST_BROWSER_LOG_LEVELS', 'error,warning,info,debug')),

];
