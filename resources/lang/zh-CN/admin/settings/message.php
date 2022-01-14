<?php

return [

    'update' => [
        'error'                 => '更新过程中出现了问题。',
        'success'               => '设置配置信息更新成功。',
    ],
    'backup' => [
        'delete_confirm'        => '你确定你想要删除该备份文件? 此操作无法撤消。 ',
        'file_deleted'          => '备份文件已成功删除。 ',
        'generated'             => '成功地创建了一个新的备份文件。',
        'file_not_found'        => '在服务器上找不到备份文件。',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => '清除过程中出现了错误。 ',
        'validation_failed'     => '你的清除确认不正确，请在输入框中输入“DELETE”。',
        'success'               => '删除记录已被成功的清除。',
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
