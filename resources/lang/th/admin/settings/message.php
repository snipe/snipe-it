<?php

return [

    'update' => [
        'error'                 => 'เกิด error ระหว่างการอัพเดตข้อมูล ',
        'success'               => 'อัพเดตการตั้งค่าเรียบร้อยแล้ว',
    ],
    'backup' => [
        'delete_confirm'        => 'คุณแน่ใจที่จะลบข้อมูลสำรองนี้? การดำเนินการนี้จะไม่สามารถกู้คืนได้ ',
        'file_deleted'          => 'ลบข้อมูลสำรองเรียบร้อยแล้ว ',
        'generated'             => 'ไฟล์ข้อมูลสำรองถูกสร้างเรียบร้อยแล้ว',
        'file_not_found'        => 'ไม่พบไฟล์ข้อมูลสำรองบนเซิฟเวอร์',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'เกิดข้อผิดพลาดขณะล้างข้อมูล',
        'validation_failed'     => 'การยืนยันการล้างข้อมูลของคุณไม่ถูกต้อง โปรดพิมพ์คำว่า "DELETE" ในช่องยืนยัน',
        'success'               => 'ล้างระเบียนเรียบร้อยแล้ว',
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
