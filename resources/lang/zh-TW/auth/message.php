<?php

return [

    'account_already_exists' => '此信箱已被註冊',
    'account_not_found'      => '使用者或密碼錯誤',
    'account_not_activated'  => '使用者尚未啟用',
    'account_suspended'      => '使用者已被停用',
    'account_banned'         => '使用者已被禁用',
    'throttle'               => 'Too many failed login attempts. Please try again in :minutes minutes.',

    'two_factor' => [
        'already_enrolled'      => 'Your device is already enrolled.',
        'success'               => '您已成功登入',
        'code_required'         => 'Two-factor code is required.',
        'invalid_code'          => '兩階段驗證碼無效',
    ],

    'signin' => [
        'error'   => '登入過程中發生問題，請重試',
        'success' => '登入成功',
    ],

    'logout' => [
        'error'   => '登出時發生問題，請稍後再試',
        'success' => '您已成功登出',
    ],

    'signup' => [
        'error'   => '在新增帳戶時發生問題，請重試',
        'success' => '新增帳戶成功。',
    ],

    'forgot-password' => [
        'error'   => '在重設密碼時發生問題，請重試',
        'success' => 'If that email address exists in our system, a password recovery email has been sent.',
    ],

    'forgot-password-confirm' => [
        'error'   => '在重設密碼時發生問題，請重試',
        'success' => '密碼重設成功。',
    ],

];
