<?php

return [

    'update' => [
        'error'                 => 'Atnaujinant įvyko klaida. ',
        'success'               => 'Nustatymai atnaujinti sėkmingai.',
    ],
    'backup' => [
        'delete_confirm'        => 'Ar tikrai norite ištrinti atsarginę kopiją? Šis veiksmas negrįžtamas. ',
        'file_deleted'          => 'Atsarginė kopija ištrinta sėkmingai. ',
        'generated'             => 'Atsarginė kopija sukurta sėkmingai.',
        'file_not_found'        => 'Šio atsarginės kopijos failo serveryje rasti nepavyko.',
        'restore_warning'       => 'Taip, atkurti. Suprantu, kad tai perrašys visus šiuo metu duomenų bazėje esančius duomenis. Taip pat, kad bus atjungti visi esami naudotojai (įskaitant mane).',
        'restore_confirm'       => 'Ar tikrai norite atkurti savo duomenų bazę iš :filename?'
    ],
    'restore' => [
        'success'               => 'Jūsų sistemos atsarginė kopija buvo atkurta. Prisijunkite iš naujo.'
    ],
    'purge' => [
        'error'     => 'Valymo metu įvyko klaida. ',
        'validation_failed'     => 'Jūsų įvestas išvalymo patvirtinimas yra neteisingas. Patvirtinimo lauke įveskite žodį „DELETE“.',
        'success'               => 'Anksčiau panaikinti įrašai sėkmingai išvalyti.',
    ],
    'mail' => [
        'sending' => 'Siunčiamas bandomasis el. laiškas...',
        'success' => 'El. laiškas išsiųstas!',
        'error' => 'El. laiško išsiųsti nepavyko.',
        'additional' => 'Nėra jokio papildomo klaidos pranešimo. Patikrinkite pašto nustatymus ir programos žurnalą.'
    ],
    'ldap' => [
        'testing' => 'Tikrinamas LDAP ryšys, susiejimas ir užklausos...',
        '500' => '500 serverio klaida. Norėdami gauti daugiau informacijos, patikrinkite savo serverio žurnalus.',
        'error' => 'Kažkas ne taip :(',
        'sync_success' => '10 naudotojų, gautų iš LDAP serverio, pagal jūsų nustatymus:',
        'testing_authentication' => 'Tikrinamas LDAP autentifikavimas...',
        'authentication_success' => 'Naudotojas sėkmingai atpažintas naudojant LDAP!'
    ],
    'labels' => [
        'null_template' => 'Label template not found. Please select a template.',
        ],
    'webhook' => [
        'sending' => ':app siunčiamas bandomasis pranešimas...',
        'success' => 'Jūsų :webhook_name integracija veikia!',
        'success_pt1' => 'Pavyko! Patikrink ',
        'success_pt2' => ' bandomojo pranešimo kanalą ir spustelėkite IŠSAUGOTI, kad išsaugotumėte nustatymus.',
        '500' => '500 serverio klaida.',
        'error' => 'Kažkas ne taip. :app atsakė: :error_message',
        'error_redirect' => 'KLAIDA: 301/302 :endpoint rodo peradresavimą. Saugumo sumetimais peradresavimų nevykdome. Naudokite tikrąjį galinį tašką.',
        'error_misc' => 'Kažkas ne taip. :( ',
        'webhook_fail' => ' „Webhook“ pranešimas nepavyko: patikrinkite ar URL vis dar galioja.',
        'webhook_channel_not_found' => ' „webhook“ kanalas nerastas.'
    ]
];
