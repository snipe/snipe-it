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
        'restore_warning'       => '是的，還原它。我了解這將覆蓋資料庫中目前的任何現有數據。這也會登出所有目前使用者(包括您)。',
        'restore_confirm'       => '請您確認是否要從 :filename 還原資料庫？'
    ],
    'purge' => [
        'error'     => '清除過程中發生錯誤。',
        'validation_failed'     => '你的清除確認不正確，請在文字輸入欄位輸入＂DELETE＂。',
        'success'               => '已成功清除刪除記錄。',
    ],
    'mail' => [
        'sending' => '正在發送測試郵件...',
        'success' => '郵件已傳送!',
        'error' => '郵件無法發送',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Something went wrong :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'LDAP 授權測試中...',
        'authentication_success' => '用戶成功透過 LDAP 驗證'
    ],
    'slack' => [
        'sending' => 'Slack 測試訊息送出中...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 伺服器錯誤',
        'error' => '出了點問題。',
    ]
];
