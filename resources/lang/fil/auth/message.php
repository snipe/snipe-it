<?php

return [

    'account_already_exists' => 'Ang account na may ganitong email ay umiiral na.',
    'account_not_found'      => 'Ang pangalan ng gumagamit o password ay hindi wasto.',
    'account_not_activated'  => 'Hindi napagana ang account ng user na ito.',
    'account_suspended'      => 'Ang account ng user na ito ay suspendido.',
    'account_banned'         => 'Ang account ng user na ito ay nai-ban.',
    'throttle'               => 'Too many failed login attempts. Please try again in :minutes minutes.',

    'two_factor' => [
        'already_enrolled'      => 'Your device is already enrolled.',
        'success'               => 'You have successfully logged in.',
        'code_required'         => 'Two-factor code is required.',
        'invalid_code'          => 'Two-factor code is invalid.',
    ],

    'signin' => [
        'error'   => 'Maayroong problema habang sunusubukang i-login ka, mangyaring subukang muli.',
        'success' => 'Ikaw ay matagumay na naka-log in.',
    ],

    'logout' => [
        'error'   => 'There was a problem while trying to log you out, please try again.',
        'success' => 'You have successfully logged out.',
    ],

    'signup' => [
        'error'   => 'Mayoong problema habang sinusubukang isagawa ang iyong account, mangyaring subukang muli.',
        'success' => 'Matagumpay na naisagawa ang account.',
    ],

    'forgot-password' => [
        'error'   => 'Mayroong problema habang sinusubukang kunin ang code sa pag-reset ng password, mangyaring subukang muli.',
        'success' => 'If that email address exists in our system, a password recovery email has been sent.',
    ],

    'forgot-password-confirm' => [
        'error'   => 'Mayroong problema habang sunusubukang i-reset ang iyong password, mangyaring subukang muli.',
        'success' => 'Ang iyong password ay nai-reset na.',
    ],

];
