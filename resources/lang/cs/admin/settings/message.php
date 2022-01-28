<?php

return [

    'update' => [
        'error'                 => 'Vyskytla se chyba při aktualizaci. ',
        'success'               => 'Nastavení úspěšně uloženo.',
    ],
    'backup' => [
        'delete_confirm'        => 'Opravdu chcete vymazat tento záložní soubor? Tuto akci nelze vrátit zpět. ',
        'file_deleted'          => 'Záložní soubor byl úspěšně smazán. ',
        'generated'             => 'Byla úspěšně vytvořena nová záloha.',
        'file_not_found'        => 'Tento záložní soubor nebyl na serveru nalezen.',
        'restore_warning'       => 'Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This will also log out all of your existing users (including you).',
        'restore_confirm'       => 'Are you sure you wish to restore your database from :filename?'
    ],
    'purge' => [
        'error'     => 'Během čištění došlo k chybě. ',
        'validation_failed'     => 'Vaše potvrzení o čištění je nesprávné. Zadejte prosím slovo "DELETE" do potvrzovacího rámečku.',
        'success'               => 'Vymazané záznamy byly úspěšně vyčištěny.',
    ],
    'mail' => [
        'sending' => 'Sending Test Email...',
        'success' => 'Mail sent!',
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
    'slack' => [
        'sending' => 'Sending Slack test message...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => '500 Server Error.',
        'error' => 'Something went wrong.',
    ]
];
