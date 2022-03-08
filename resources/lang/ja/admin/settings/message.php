<?php

return [

    'update' => [
        'error'                 => '更新時にエラーが発生しました。 ',
        'success'               => '更新に成功しました。',
    ],
    'backup' => [
        'delete_confirm'        => 'このバックアップファイルを削除してもよろしいですか？この操作は、もとに戻すことは出来ません。 ',
        'file_deleted'          => 'バックアップファイルの削除に成功しました。 ',
        'generated'             => '新しいバックアップファイルが作成されました。',
        'file_not_found'        => 'そのバックアップファイルをサーバー上に見つけることが出来ませんでした。',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'パージ中にエラーが発生しました。 ',
        'validation_failed'     => 'パージの確定方法が正しくありません。入力してください、単語「削除」確認ボックス。',
        'success'               => 'パージによりレコードは削除されました',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Mail could not be sent.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];
