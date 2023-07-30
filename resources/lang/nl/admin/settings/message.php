<?php

return [

    'update' => [
        'error'                 => 'Er is een fout opgetreden tijdens het updaten. ',
        'success'               => 'Instellingen zijn met succes gewijzigd.',
    ],
    'backup' => [
        'delete_confirm'        => 'Weet je het zeker dat je deze Back-up bestand wilt verwijderen? Dit kan niet meer terug gedraaid worden. ',
        'file_deleted'          => 'De Back-up bestand is met succes verwijderd. ',
        'generated'             => 'Een nieuw Back-up bestand is met succes aangemaakt.',
        'file_not_found'        => 'Die Back-up bestand kon niet gevonden worden op de server.',
        'restore_warning'       => 'Ja, herstellen. Ik bevestig dat dit alle bestaande gegevens die momenteel in de database aanwezig zijn, overschreven worden. Dit zal ook alle bestaande gebruikers uitloggen (inclusief jijzelf).',
        'restore_confirm'       => 'Weet je zeker dat je je database wilt herstellen met :filename?'
    ],
    'purge' => [
        'error'     => 'Er is iets fout gegaan tijdens het opschonen.',
        'validation_failed'     => 'De opschoon bevestiging is niet correct. Typ het woord "DELETE" in het bevestigingsveld.',
        'success'               => 'Verwijderde items succesvol opgeschoond',
    ],
    'mail' => [
        'sending' => 'Test e-mail wordt verzonden...',
        'success' => 'E-mail verzonden!',
        'error' => 'E-mail kon niet verzonden worden.',
        'additional' => 'Geen extra foutmelding beschikbaar. Controleer je e-mailinstellingen en je app log.'
    ],
    'ldap' => [
        'testing' => 'LDAP-verbinding testen, Binding & Query ...',
        '500' => '500 serverfout. Controleer de logbestanden van uw server voor meer informatie.',
        'error' => 'Er ging iets mis :(',
        'sync_success' => 'Een voorbeeld van 10 gebruikers is teruggekomen van de LDAP-server op basis van jouw instellingen:',
        'testing_authentication' => 'LDAP-authenticatie testen...',
        'authentication_success' => 'Gebruiker met succes geverifieerd met LDAP!'
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
