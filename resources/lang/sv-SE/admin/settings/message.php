<?php

return [

    'update' => [
        'error'                 => 'Ett fel har uppstått vid uppdatering. ',
        'success'               => 'Inställningarna uppdaterades.',
    ],
    'backup' => [
        'delete_confirm'        => 'Är du säker på att du vill ta bort den här säkerhetskopian? Den här åtgärden kan inte ångras. ',
        'file_deleted'          => 'Säkerhetskopian har tagits bort. ',
        'generated'             => 'En ny säkerhetskopia skapades.',
        'file_not_found'        => 'Säkerhetskopian kunde inte hittas på servern.',
        'restore_warning'       => 'Ja, återställ den. Jag är medveten att detta kommer att skriva över befintlig data som redan finns i databasen. Detta kommer också att logga ut alla befintliga användare (inklusive dig själv).',
        'restore_confirm'       => 'Är du säker på att du vill återställa din databas från :filename?'
    ],
    'restore' => [
        'success'               => 'Din säkerhetskopia har återställts. Vänligen logga in igen.'
    ],
    'purge' => [
        'error'     => 'Ett fel har uppstått vid radering. ',
        'validation_failed'     => 'Raderingsbekräftelsekoden är felaktig. Vänligen skriv ordet "DELETE" i bekräftelserutan.',
        'success'               => 'Tidigare raderade poster har raderats för gott.',
    ],
    'mail' => [
        'sending' => 'Skickar testmeddelande...',
        'success' => 'E-post skickat!',
        'error' => 'E-postmeddelandet kunde inte skickas.',
        'additional' => 'Inga ytterligare felmeddelanden. Kontrollera dina e-postinställningar och din app-logg.'
    ],
    'ldap' => [
        'testing' => 'Testar LDAP-anslutning, Bindning och Query...',
        '500' => '500 Server Error. Kontrollera dina serverloggar för mer information.',
        'error' => 'Något gick snett :(',
        'sync_success' => 'Ett urval av 10 användare som returneras från LDAP-servern baserat på dina inställningar:',
        'testing_authentication' => 'Testar LDAP-autentisering...',
        'authentication_success' => 'Användaren har autentiserats via LDAP!'
    ],
    'webhook' => [
        'sending' => 'Skickar :app testmeddelande...',
        'success' => 'Din :webhook_name-integration fungerar!',
        'success_pt1' => 'Klart! Kontrollera ',
        'success_pt2' => ' kanal för ditt testmeddelande, och se till att klicka på SPARA nedan för att lagra dina inställningar.',
        '500' => '500 Server Error.',
        'error' => 'Något gick snett! :app svarade med: :error_message',
        'error_redirect' => 'FEL: 301/302 :endpoint returnerar en redirect. Av säkerhetsskäl följer vi inte redirects. Använd den faktiska endpointen.',
        'error_misc' => 'Någonting gick snett :( ',
    ]
];
