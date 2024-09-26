<?php

return [

    'update' => [
        'error'                 => 'Caw en-waith thuiath an-nadui. ',
        'success'               => 'Settings en-waith athradol iúren.',
    ],
    'backup' => [
        'delete_confirm'        => 'Naith iest lin hen an-nadui i-theled hen cuithol? Nin úbed linnar. ',
        'file_deleted'          => 'I-cuithol naith iúren theled. ',
        'generated'             => 'Cuithol naith cerith athradol iúren.',
        'file_not_found'        => 'I-cuithol hen ú theled i-adar.',
        'restore_warning'       => 'Ma, athradol han. Nin badenathon athradath anad i-gwenned na adanrath. Sen gwanno en-gwend ed-dúath (dho le).',
        'restore_confirm'       => 'An-ron lin estannen lin dathol naith en-dathron iúren: :filename?'
    ],
    'restore' => [
        'success'               => 'System naith athradol iúren. Edainio ed-dúath achenor.'
    ],
    'purge' => [
        'error'     => 'Caw en-waith thuiath an-nadui purgiath. ',
        'validation_failed'     => 'Cened purgiath hen ú-bereth. Tegoladho "DELETE" naith iûr-box.',
        'success'               => 'Nadron en-dathron athradol purgiath iúren.',
    ],
    'mail' => [
        'sending' => 'Estannen naith Test Email...',
        'success' => 'Naith estannen!',
        'error' => 'Naith ú-thuiath estannen.',
        'additional' => 'En-waith nath ú-thuiath iúren. Hedhad lin mail settings a lin app log.'
    ],
    'ldap' => [
        'testing' => 'Estannen i-LDAP Gwaeth, Neth a Hiriad ...',
        '500' => '500 Gwaeth en-Dathron. Edda lin log lin en-dathron an iûr. ',
        'error' => 'Nad gwathuiath :( ',
        'sync_success' => 'Cened na-thuiath 10 edain lin naith en-LDAP server naidh na lin settings:',
        'testing_authentication' => 'Estannen i-LDAP hîrauth...',
        'authentication_success' => 'Eda naith hîradol en-LDAP iúren!'
    ],
    'webhook' => [
        'sending' => 'Estannen :app test naith...',
        'success' => 'Lin :webhook_name Ithronnath athradol iúren!',
        'success_pt1' => 'Estannen! Hedhadho i ',
        'success_pt2' => ' i-fenna lin naith test, a hedhedho "SAVE" an prestad naith lin settings.',
        '500' => '500 Gwaeth en-Dathron.',
        'error' => 'Nad gwathuiath. :app athrathon: :error_message',
        'error_redirect' => 'GWATH: 301/302 :endpoint naith athrada. Naitho en-estel, ú-bruith athradu. Ú-ostath lin endpoint naith.',
        'error_misc' => 'Nad gwathuiath. :( ',
]
];
