<?php

return [

    'source' => [

        'files' => [

            /*
             * The list of directories that should be part of the backup. You can
             * specify individual files as well.
             */
            'include' => [
                'public/uploads',
                'config',
                'app/storage/private_uploads',
            ],

            /*
             * These directories will be excluded from the backup.
             * You can specify individual files as well.
             */
            'exclude' => [
                base_path('vendor'),
            ],
        ],

        /*
         * Should the database be part of the back up.
         */
        'backup-db' => true,
    ],

    'destination' => [

        /*
         * The filesystem(s) you on which the backups will be stored. Choose one or more
         * of the filesystems you configured in app/config/filesystems.php
         */
        'filesystem' => ['local'],

        /*
         * The path where the backups will be saved. This path
         * is relative to the root you configured on your chosen
         * filesystem(s).
         *
         * If you're using the local filesystem a .gitignore file will
         * be automatically placed in this directory so you don't
         * accidentally end up committing these backups.
         */
        'path' => 'backups',

        /*
         * By default the backups will be stored as a zipfile with a
         * timestamp as the filename. With these options You can
         * specify a prefix and a suffix for the filename.
         */
        'prefix' => 'backup-',
        'suffix' => '',
    ],

    'clean' => [
        /*
         * The clean command will remove all backups on all configured filesystems
         * that are older then this amount of days.
         */
        'maxAgeInDays' => 90,
    ],

    'mysql' => [
        /*
         * The path to the mysqldump binary. You can leave this empty
         * if the binary is installed in the default location.
         */
        'dump_command_path' => '',

        /*
         * If your server supports it you can turn on extended insert.
         * This will result in a smaller dump file and speeds up the backup process.
         *
         * See: https://dev.mysql.com/doc/refman/5.1/en/mysqldump.html#option_mysqldump_extended-insert
         */
        'useExtendedInsert' => false,

        /*
         * If the dump of the db takes more seconds that the specified value,
         * it will abort the backup.
         */
        'timeoutInSeconds' => 60,
    ],

    'pgsql' => [
        /*
         * The path to the pg_dump binary. You can leave this empty
         * if the binary is installed in the default location.
         */
        'dump_command_path' => '',

        /*
         * Set to true to use pgsql 'COPY' statements instead of 'INSERT's.
         */
        'use_copy' => true,

        /*
         * If the dump of the db takes more seconds that the specified value,
         * it will abort the backup.
         */
        'timeoutInSeconds' => 60,
    ],
];
