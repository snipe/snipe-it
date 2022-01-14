<?php

return [

    'update' => [
        'error'                 => 'புதுப்பித்தல் போது ஒரு பிழை ஏற்பட்டது.',
        'success'               => 'அமைப்புகள் வெற்றிகரமாக புதுப்பிக்கப்பட்டன.',
    ],
    'backup' => [
        'delete_confirm'        => 'இந்த காப்புப் பிரதி கோப்பை நிச்சயமாக நீக்க விரும்புகிறீர்களா? இந்த செயலைச் செயல்தவிர்க்க முடியாது.',
        'file_deleted'          => 'காப்புப்பதிவு வெற்றிகரமாக நீக்கப்பட்டது.',
        'generated'             => 'ஒரு புதிய காப்புப்பதிவு வெற்றிகரமாக உருவாக்கப்பட்டது.',
        'file_not_found'        => 'அந்த காப்புப் பிரதி சர்வரில் கண்டுபிடிக்க முடியவில்லை.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'அகற்றும் போது பிழை ஏற்பட்டது.',
        'validation_failed'     => 'உங்கள் தூய்மைப்படுத்தல் உறுதிப்படுத்தல் தவறானது. உறுதிப்படுத்தல் பெட்டியில் "DELETE" என்ற வார்த்தையை தயவுசெய்து தட்டச்சு செய்யவும்.',
        'success'               => 'நீக்கப்பட்ட பதிவுகள் வெற்றிகரமாக நீக்கப்பட்டன.',
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
