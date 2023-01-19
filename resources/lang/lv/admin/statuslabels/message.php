<?php

return [

    'does_not_exist' => 'Statusa marķējums nepastāv.',
    'assoc_assets'	 => 'Šī statusa marķējums pašlaik ir saistīts ar vismaz vienu īpašumu un to nevar izdzēst. Lūdzu, atjauniniet savus aktīvus, lai vairs nenozīmē šo statusu, un mēģiniet vēlreiz.',

    'create' => [
        'error'   => 'Statusa marķējums netika izveidots, lūdzu, mēģiniet vēlreiz.',
        'success' => 'Statusa marķējums tika veiksmīgi izveidots.',
    ],

    'update' => [
        'error'   => 'Statusa marķējums nav atjaunināts, lūdzu, mēģiniet vēlreiz',
        'success' => 'Statusa marķējums ir veiksmīgi atjaunināts.',
    ],

    'delete' => [
        'confirm'   => 'Vai tiešām vēlaties dzēst šo statusa etiķeti?',
        'error'   => 'Dzēšot statusa marķējumu, radās problēma. Lūdzu mēģiniet vēlreiz.',
        'success' => 'Statusa marķējums tika veiksmīgi dzēsts.',
    ],

    'help' => [
        'undeployable'   => 'Šos līdzekļus nevar nodot nevienam.',
        'deployable'   => 'These assets can be checked out. Once they are assigned, they will assume a meta status of <i class="fas fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Šos līdzekļus nevar pārbaudīt, un tie tiks parādīti tikai arhivētajā skatā. Tas ir noderīgi, lai saglabātu informāciju par aktīviem budžetam / vēsturiskiem mērķiem, bet tos saglabātu ikdienas aktīvu sarakstā.',
        'pending'   => 'Šos aktīvus vēl nevar piešķirt ikvienam, bieži tos izmanto priekšmetos, kas paredzēti remontam, bet tiek sagaidīts, ka tie atgriezīsies apgrozībā.',
    ],

];
