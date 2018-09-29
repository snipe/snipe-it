<?php

$config = [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        // This applies the LOCAL public only, not S3/FTP/etc
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'root'   => 'storage',
        ],

        'rackspace' => [
            'driver'    => 'rackspace',
            'username'  => env('RACKSPACE_USERNAME'),
            'key'       => env('RACKSPACE_KEY'),
            'container' => env('RACKSPACE_CONTAINER'),
            'endpoint'  => 'https://identity.api.rackspacecloud.com/v2.0/',
            'region'    => env('RACKSPACE_REGION'),
            'url_type'  => env('RACKSPACE_URL_TYPE'),
        ],

    ],

];

// When you're dealing with local file storage, the paths will be different than S3
if  (env('FILESYSTEM_DISK')!='local')
{
    $config['disks']['public'] = $config['disks'][env('FILESYSTEM_DISK')];
    $config['disks']['public']['visibility'] = 'public';
}

return $config;
