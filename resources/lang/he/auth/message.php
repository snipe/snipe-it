<?php

return [

    'account_already_exists' => 'כבר קיים חשבון עם האימייל הזה.',
    'account_not_found'      => 'שם המשתמש או הסיסמה שגויים.',
    'account_not_activated'  => 'חשבון משתמש זה אינו מופעל.',
    'account_suspended'      => 'חשבון המשתמש הזה מושעה.',
    'account_banned'         => 'חשבון משתמש זה מוחרם.',
    'throttle'               => 'Too many failed login attempts. Please try again in :minutes minutes.',

    'two_factor' => [
        'already_enrolled'      => 'Your device is already enrolled.',
        'success'               => 'You have successfully logged in.',
        'code_required'         => 'Two-factor code is required.',
        'invalid_code'          => 'Two-factor code is invalid.',
    ],

    'signin' => [
        'error'   => 'אירעה בעיה בעת ניסיון להתחבר אליך, נסה שוב.',
        'success' => 'התחברת בהצלחה.',
    ],

    'logout' => [
        'error'   => 'There was a problem while trying to log you out, please try again.',
        'success' => 'You have successfully logged out.',
    ],

    'signup' => [
        'error'   => 'אירעה בעיה בעת ניסיון ליצור את חשבונך, נסה שוב.',
        'success' => 'החשבון נוצר בהצלחה.',
    ],

    'forgot-password' => [
        'error'   => 'אירעה בעיה בעת ניסיון לקבל קוד סיסמה לאיפוס, נסה שוב.',
        'success' => 'If that email address exists in our system, a password recovery email has been sent.',
    ],

    'forgot-password-confirm' => [
        'error'   => 'אירעה בעיה בעת ניסיון לאפס את הסיסמה שלך, נסה שוב.',
        'success' => 'הסיסמה שלך אופסה בהצלחה.',
    ],

];
