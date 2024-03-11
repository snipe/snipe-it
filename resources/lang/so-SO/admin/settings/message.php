<?php

return [

    'update' => [
        'error'                 => 'Khalad ayaa dhacay markii la cusboonaysiiyay ',
        'success'               => 'Dejinta si guul leh ayaa loo cusboonaysiiyay',
    ],
    'backup' => [
        'delete_confirm'        => 'Ma hubtaa inaad jeclaan lahayd inaad tirtirto faylka kaydka ah? Tallaabadan lama noqon karo. ',
        'file_deleted'          => 'Faylka kaabta ayaa si guul leh loo tirtiray ',
        'generated'             => 'Fayl cusub oo gurmad ah ayaa si guul leh loo abuuray',
        'file_not_found'        => 'Faylkaas kaydka ah ayaa laga waayay seerfarka.',
        'restore_warning'       => 'Haa, soo celi Waxaan qirayaa in tani ay dib u qori doonto xog kasta oo hadda ku jirta kaydka xogta. Tani waxay sidoo kale ka saari doontaa dhammaan isticmaalayaashaada jira (oo ay ku jirto adiga).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Khalad ayaa dhacay markii la nadiifinayo ',
        'validation_failed'     => 'Xaqiijinta nadiifintaadu waa khalad. Fadlan ku qor kelmadda "DELETE" sanduuqa xaqiijinta.',
        'success'               => 'Diiwaanada la tirtiray ayaa si guul leh loo nadiifiyay',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Boostada waa la soo diray!',
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
    'webhook' => [
        'sending' => 'Sending :app test message...',
        'success' => 'Your :webhook_name Integration works!',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong. :app responded with: :error_message',
        'error_redirect' => 'ERROR: 301/302 :endpoint returns a redirect. For security reasons, we don’t follow redirects. Please use the actual endpoint.',
        'error_misc' => 'Something went wrong. :( ',
    ]
];
