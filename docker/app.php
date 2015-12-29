<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => false,
    
    'timezone' => isset($_ENV['SNIPEIT_TIMEZONE']) ? $_ENV['SNIPEIT_TIMEZONE'] : 'UTC',
    'locale' => isset($_ENV['SNIPEIT_LOCALE']) ? $_ENV['SNIPEIT_LOCALE'] : 'en',


    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => isset($_ENV['SERVER_URL']) ? $_ENV['SERVER_URL'] : 'https://production.yourserver.com',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    | Run a php artisan key:generate --env=staging to create a random one
    */

    'key' => 'Change_this_key_or_snipe_will_get_ya',

);
