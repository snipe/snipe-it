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
        'restore_confirm'       => 'Ma hubtaa inaad rabto inaad ka soo celiso xogtaada: filename?'
    ],
    'purge' => [
        'error'     => 'Khalad ayaa dhacay markii la nadiifinayo ',
        'validation_failed'     => 'Xaqiijinta nadiifintaadu waa khalad. Fadlan ku qor kelmadda "DELETE" sanduuqa xaqiijinta.',
        'success'               => 'Diiwaanada la tirtiray ayaa si guul leh loo nadiifiyay',
    ],
    'mail' => [
        'sending' => 'Diraya Iimayl tijaabo ah...',
        'success' => 'Boostada waa la soo diray!',
        'error' => 'Email lama diri karo.',
        'additional' => 'Ma jiro fariin khalad ah oo dheeri ah oo la bixiyay Hubi dejimahaaga fariimaha iyo logkaaga abka.'
    ],
    'ldap' => [
        'testing' => 'Tijaabinta Xidhiidhka LDAP, Ku xidhka & Weydiinta...',
        '500' => '500 Cilad Server Fadlan hubi diiwaanka server-kaaga wixii macluumaad dheeraad ah.',
        'error' => 'Waxbaa qaldamay :(',
        'sync_success' => 'Muunad 10 isticmaale ah ayaa laga soo celiyay server-ka LDAP iyadoo lagu salaynayo habayntaada:',
        'testing_authentication' => 'Tijaabi aqoonsiga LDAP...',
        'authentication_success' => 'Isticmaaluhu wuxuu ka xaqiijiyay LDAP si guul leh!'
    ],
    'webhook' => [
        'sending' => 'Diraya :app fariinta tijaabada abka...',
        'success' => 'Magacaaga:webhook_name Isdhexgalka wuu shaqeeyaa!',
        'success_pt1' => 'Guul! Hubi ',
        'success_pt2' => ' kanaalka fariinta tijaabada ah, oo hubi inaad gujiso SAVE xagga hoose si aad u kaydiso dejintaada.',
        '500' => '500 Cilad Server.',
        'error' => 'Waxbaa qaldamay. :app waxa uu kaga jawaabay: : error_message',
        'error_redirect' => 'CILAD: 301/302 :endpoint Sababo ammaan dartood, ma raacno dib u jiheynta Fadlan isticmaal barta dhamaadka dhabta ah.',
        'error_misc' => 'Waxbaa qaldamay. :( ',
    ]
];
