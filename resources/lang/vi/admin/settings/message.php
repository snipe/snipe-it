<?php

return [

    'update' => [
        'error'                 => 'Có lỗi xảy ra khi cập nhật. ',
        'success'               => 'Cập nhật cài đặt thành công.',
    ],
    'backup' => [
        'delete_confirm'        => 'Bạn có chắc chắn muốn xóa tệp sao lưu này? Hành động này không thể được hoàn tác.',
        'file_deleted'          => 'Tệp sao lưu đã được xoá thành công.',
        'generated'             => 'Một tập tin sao lưu mới được tạo thành công.',
        'file_not_found'        => 'Tập tin sao lưu không tìm thấy trên máy chủ.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Đã xảy ra lỗi trong khi xóa.',
        'validation_failed'     => 'Xác nhận thanh lọc của bạn không chính xác. Vui lòng nhập từ "DELETE" vào hộp xác nhận.',
        'success'               => 'Đã xoá thành công hồ sơ thành công.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
        'error' => 'Không thể gửi được thư.',
        'additional' => 'No additional error message provided. Check your mail settings and your app log.'
    ],
    'ldap' => [
        'testing' => 'Testing LDAP Connection, Binding & Query ...',
        '500' => '500 Server Error. Please check your server logs for more information.',
        'error' => 'Đã xảy ra lỗi :(',
        'sync_success' => 'A sample of 10 users returned from the LDAP server based on your settings:',
        'testing_authentication' => 'Testing LDAP Authentication...',
        'authentication_success' => 'User authenticated against LDAP successfully!'
    ],
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_misc' => 'Something went wrong. :( ',
    ]
];
