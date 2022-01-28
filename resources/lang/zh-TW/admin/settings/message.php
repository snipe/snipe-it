<?php

return [

    'update' => [
        'error'                 => '更新過程中發生問題。',
        'success'               => '更新設定成功。',
    ],
    'backup' => [
        'delete_confirm'        => '您確定要刪除此備份檔嗎？此動作無法復原。',
        'file_deleted'          => '刪除備份檔成功。',
        'generated'             => '成功新增一個新的備份檔。',
        'file_not_found'        => '在伺服器上找不到備份檔',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => '清除過程中發生錯誤。',
        'validation_failed'     => '你的清除確認不正確，請在文字輸入欄位輸入＂DELETE＂。',
        'success'               => '已成功清除刪除記錄。',
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
