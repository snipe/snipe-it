<?php

return [

    'update' => [
        'error'                 => 'Der opstod en fejl under opdatering. ',
        'success'               => 'Indstillinger opdateret med succes.',
    ],
    'backup' => [
        'delete_confirm'        => 'Er du sikker på, at du vil slette denne sikkerhedskopieringsfil? Denne handling kan ikke fortrydes.',
        'file_deleted'          => 'Sikkerhedsfilen blev slettet korrekt.',
        'generated'             => 'En ny sikkerhedskopieringsfil blev oprettet.',
        'file_not_found'        => 'Denne backup-fil kunne ikke findes på serveren.',
        'restore_warning'       => 'Ja, gendanne den. Jeg anerkender, at dette vil overskrive alle eksisterende data i databasen. Dette vil også logge ud alle dine eksisterende brugere (inklusive dig).',
        'restore_confirm'       => 'Er du sikker på, at du vil gendanne din database fra :filnavn?'
    ],
    'restore' => [
        'success'               => 'Your system backup has been restored. Please log in again.'
    ],
    'purge' => [
        'error'     => 'Der opstod en fejl under udrensning.',
        'validation_failed'     => 'Din udrensningsbekræftelse er forkert. Indtast ordet "DELETE" i bekræftelsesboksen.',
        'success'               => 'Slettet arkiver, der er renset for succes.',
    ],
    'mail' => [
        'sending' => 'Sender Test Email...',
        'success' => 'Mail sendt!',
        'error' => 'Mail kunne ikke sendes.',
        'additional' => 'Ingen yderligere fejlmeddelelse angivet. Tjek dine mail-indstillinger og din app-log.'
    ],
    'ldap' => [
        'testing' => 'Test LDAP Forbindelse, Binding & Query ...',
        '500' => '500 serverfejl. Tjek venligst dine serverlogs for mere information.',
        'error' => 'Noget gik galt :(',
        'sync_success' => 'En prøve på 10 brugere returnerede fra LDAP-serveren baseret på dine indstillinger:',
        'testing_authentication' => 'Test LDAP Autentificering...',
        'authentication_success' => 'Bruger godkendt mod LDAP!'
    ],
    'webhook' => [
        'sending' => 'Sender :app test besked...',
        'success' => 'Dine :webhook_name Integration virker!',
        'success_pt1' => 'Succes! Tjek ',
        'success_pt2' => ' kanal til din testbesked, og sørg for at klikke på GEM nedenfor for at gemme dine indstillinger.',
        '500' => '500 Serverfejl.',
        'error' => 'Noget gik galt. :app svarede med: :error_message',
        'error_redirect' => 'FEJL: 301/302: endpoint returnerer en omdirigering. Af sikkerhedsmæssige årsager følger vi ikke omdirigeringer. Brug det faktiske slutpunkt.',
        'error_misc' => 'Noget gik galt. :( ',
    ]
];
