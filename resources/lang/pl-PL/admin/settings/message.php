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
    'restore' => [
        'success'               => 'Your system backup has been restored. Please log in again.'
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
    'webhook' => [
        'sending' => 'Wysyłanie wiadomości testowej :app...',
        'success' => 'Twoja integracja :webhook_name działa!',
        'success_pt1' => 'Sukces! Sprawdź ',
        'success_pt2' => ' kanał wiadomości testowej i pamiętaj, aby kliknąć ZAPISZ poniżej, aby zapisać ustawienia.',
        '500' => 'Błąd 500 serwera.',
        'error' => 'Coś poszło nie tak. :app odpowiedział: :error_message',
        'error_redirect' => 'BŁĄD: 301/302 :endpoint zwraca przekierowanie. Ze względów bezpieczeństwa nie podążamy za przekierowaniami. Proszę użyć aktualnego punktu końcowego.',
        'error_misc' => 'Coś poszło nie tak. :( ',
    ]
];
