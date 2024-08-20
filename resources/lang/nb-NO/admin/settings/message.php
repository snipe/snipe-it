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
    'restore' => [
        'success'               => 'Your system backup has been restored. Please log in again.'
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
        'sending' => 'Sender :app test melding...',
        'success' => 'Ditt :webhook_name integrasjon fungerer!',
        'success_pt1' => 'Suksess! Sjekk ',
        'success_pt2' => ' kanalen din for testmelding, og sørg for å klikke på SAVE nedenfor for å lagre innstillingene.',
        '500' => '500 Tjenerfeil.',
        'error' => 'Noe gikk galt. :app svarte med: :error_message',
        'error_redirect' => 'FEIL: 301/302 :endpoint returnerer en omaddressering. Av sikkerhetsgrunner følger vi ikke omadressering. Vennligst bruk det faktiske endepunktet.',
        'error_misc' => 'Noe gikk galt. :( ',
    ]
];
