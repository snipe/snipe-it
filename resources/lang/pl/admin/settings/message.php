<?php

return [

    'update' => [
        'error'                 => 'Wystąpił błąd podczas aktualizacji. ',
        'success'               => 'Ustawienia zaktualizowane pomyślnie.',
    ],
    'backup' => [
        'delete_confirm'        => 'Czy na pewno chcesz usunąć kopie zapasową? Nie można cofnąć tej akcji. ',
        'file_deleted'          => 'Kopia zapasowa usunięta pomyślnie. ',
        'generated'             => 'Nowa kopia zapasowa utworzona pomyślnie.',
        'file_not_found'        => 'Nie odnaleziono kopii zapasowej na serwerze.',
        'restore_warning'       => 'Tak, przywróć. Mam świadomość, że spowoduje to nadpisanie istniejących danych w bazie danych. Spowoduje to również wylogowanie wszystkich istniejących użytkowników (w tym Ciebie).',
        'restore_confirm'       => 'Czy na pewno chcesz przywrócić bazę danych z :filename?'
    ],
    'purge' => [
        'error'     => 'Wystąpił błąd podczas czyszczenia. ',
        'validation_failed'     => 'Potwierdzenie czyszczenia jest niepoprawne. Wpisz słowo "DELETE" w polu potwierdzenia.',
        'success'               => 'Pomyślnie wyczyszczono rekordy usunięte.',
    ],
    'mail' => [
        'sending' => 'Wysyłanie testowej wiadomości e-mail...',
        'success' => 'Wiadomość wysłana!',
        'error' => 'Wiadomość nie może zostać wysłana.',
        'additional' => 'Nie podano dodatkowego komunikatu o błędzie. Sprawdź ustawienia poczty i logu aplikacji.'
    ],
    'ldap' => [
        'testing' => 'Testowanie połączenia LDAP, powiązania i zapytania ...',
        '500' => 'Błąd serwera 500. Sprawdź logi serwera, aby uzyskać więcej informacji.',
        'error' => 'Coś poszło nie tak :(',
        'sync_success' => 'Przykładowe 10 użytkowników zwrócona z serwera LDAP na podstawie Twoich ustawień:',
        'testing_authentication' => 'Testowanie uwierzytelniania LDAP...',
        'authentication_success' => 'Użytkownik uwierzytelniony z LDAP pomyślnie!'
    ],
    'slack' => [
        'sending' => 'Wysyłanie wiadomości testowej Slack...',
        'success_pt1' => 'Success! Check the ',
        'success_pt2' => ' channel for your test message, and be sure to click SAVE below to store your settings.',
        '500' => 'Błąd 500 serwera.',
        'error' => 'Coś poszło nie tak.',
    ]
];
