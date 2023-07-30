<?php

return [

    'update' => [
        'error'                 => 'En feil oppstod under oppdatering. ',
        'success'               => 'Oppdatering av innstillinger vellykket.',
    ],
    'backup' => [
        'delete_confirm'        => 'Er du sikker på at du vil slette denne sikkerhetskopien? Denne handlingen kan ikke angres. ',
        'file_deleted'          => 'Den Sikkerhetskopierte filen ble slettet. ',
        'generated'             => 'En ny sikkerhetskopi fil ble opprettet.',
        'file_not_found'        => 'Den backup-filen ble ikke funnet på serveren.',
        'restore_warning'       => 'Ja, kjør gjenoppretting. Jeg forstår at dette vil overskive alle eksisterende data som er i databasen. Dette vil også logge ut alle eksisterende brukere (inkludert meg selv).',
        'restore_confirm'       => 'Er du sikker på at du vil gjenopprette databasen fra :filename?'
    ],
    'purge' => [
        'error'     => 'Det oppstod en feil under fjerning. ',
        'validation_failed'     => 'Din fjerningsbekreftelse er feil. Vennligst skriv inn ordet "DELETE" i bekreftelsesboksen.',
        'success'               => 'Slettede rader ble fjernet.',
    ],
    'mail' => [
        'sending' => 'Sender e-post...',
        'success' => 'E-post er sendt!',
        'error' => 'E-post kunne ikke sendes.',
        'additional' => 'Ingen ytterligere feilmelding oppgitt. Sjekk e-postinnstillingene og loggen.'
    ],
    'ldap' => [
        'testing' => 'Tester LDAP-tilkobling, binding og spørring ...',
        '500' => '500 serverfeil. Sjekk tjenerens logger for mer informasjon.',
        'error' => 'Noe gikk galt :(',
        'sync_success' => 'Et utvalg på 10 brukere som returneres fra LDAP-serveren basert på innstillingene:',
        'testing_authentication' => 'Tester LDAP-autentisering...',
        'authentication_success' => 'Brukeren ble autentisert mot LDAP!'
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
