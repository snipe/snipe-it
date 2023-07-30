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
        'restore_warning'       => 'Ano, obnovit. Potvrzuji, že toto přepíše existující data v databázi. Tato akce taky odhlásí všechny uživatele (včetně vás).',
        'restore_confirm'       => 'Jste si jisti, že chcete obnovit databázi z :filename?'
    ],
    'purge' => [
        'error'     => 'Během čištění došlo k chybě. ',
        'validation_failed'     => 'Vaše potvrzení o čištění je nesprávné. Zadejte prosím slovo "DELETE" do potvrzovacího rámečku.',
        'success'               => 'Vymazané záznamy byly úspěšně vyčištěny.',
    ],
    'mail' => [
        'sending' => 'Odesílání testovacího e-mailu...',
        'success' => 'E-mail odeslán!',
        'error' => 'E-mail se nepodařilo odeslat.',
        'additional' => 'Porobná zpárva o chybě není dostupná. Zkontrolujte nastavení pošty a log.'
    ],
    'ldap' => [
        'testing' => 'Testování LDAP připojení, vazby a dotazu ...',
        '500' => '500 Server error. Zkontrolujte serverové logy pro více informací.',
        'error' => 'Něco se pokazilo :(',
        'sync_success' => '10 příkladových uživatelů z LDAP serveru podle vašeho nastavení:',
        'testing_authentication' => 'Testování LDAP ověření...',
        'authentication_success' => 'Uživatel byl úspěšně ověřen přes LDAP!'
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
