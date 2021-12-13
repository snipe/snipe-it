<?php

return array(

    'accepted'                  => 'Pomyślnie zaakceptowałeś ten składnik aktywów.',
    'declined'                  => 'Pomyślnie odrzuciłeś ten składnik aktywów.',
    'bulk_manager_warn'	        => 'Użytkownicy zostały pomyślnie zaktualizowane, jednak Twój wpis manager nie został zapisany, bo dyrektor wybrano był również na liście użytkowników do edycji i użytkowników nie może być ich Menedżer. Wybierz użytkowników, z wyjątkiem Menedżera.',
    'user_exists'               => 'Użytkownik już istnieje!',
    'user_not_found'            => 'User [:id] nie istnieje.',
    'user_login_required'       => 'Pole login jest wymagane',
    'user_password_required'    => 'Pole hasło jest wymagane.',
    'insufficient_permissions'  => 'Brak uprawnień.',
    'user_deleted_warning'      => 'Ten użytkownik został usunięty. Musisz przywrócić tego użytkownika aby je wyedytować lub przypisać je do nowych aktywów.',
    'ldap_not_configured'        => 'Integracja z LDAP nie została skonfigurowana dla tej instalacji.',
    'password_resets_sent'      => 'Wybrani użytkownicy, którzy są aktywni i mają prawidłowe adresy e-mail, otrzymali link do resetowania hasła.',
    'password_reset_sent'       => 'Link umożliwiający zresetowanie hasła został wysłany na :email!',


    'success' => array(
        'create'    => 'Użytkownik utworzony pomyślnie.',
        'update'    => 'Użytkownik zaktualizowany pomyślnie.',
        'update_bulk'    => 'Użytkownik zaktualizowany pomyślnie!',
        'delete'    => 'Użytkownik został usunięty pomyślnie.',
        'ban'       => 'Użytkownik został zablokowany.',
        'unban'     => 'Użytkownik został odblokowany.',
        'suspend'   => 'Konto użytkownika zostało wyłączone.',
        'unsuspend' => 'Konto użytkownika zostało włączone.',
        'restored'  => 'Użytkownik został przywrócony pomyślnie.',
        'import'    => 'Import użytkowników zakończony sukcesem.',
    ),

    'error' => array(
        'create' => 'Podczas tworzenia użytkownika wystąpił problem. Spróbuj ponownie.',
        'update' => 'Podczas aktualizacji użytkownika wystąpił problem. Spróbuj ponownie.',
        'delete' => 'Wystąpił błąd podczas usuwania użytkownika. Spróbuj ponownie.',
        'delete_has_assets' => 'Ten użytkownik posiada elementy przypisane i nie może być usunięty.',
        'unsuspend' => 'Wystąpił problem podczas odblokowania użytkownika. Spróbuj ponownie.',
        'import'    => 'Podczas importowania użytkowników wystąpił błąd. Spróbuj ponownie.',
        'asset_already_accepted' => 'Aktywo zostało już zaakceptowane.',
        'accept_or_decline' => 'Musisz zaakceptować lub odrzucić to aktywo.',
        'incorrect_user_accepted' => 'Zasób, który próbowano zaakceptować nie został wyewidencjonowany dla użytkownika.',
        'ldap_could_not_connect' => 'Nie udało się połączyć z serwerem LDAP. Sprawdź proszę konfigurację serwera LDAP w pliku konfiguracji. <br>Błąd z serwera LDAP:',
        'ldap_could_not_bind' => 'Nie udało się połączyć z serwerem LDAP. Sprawdź proszę konfigurację serwera LDAP w pliku konfiguracji. <br>Błąd z serwera LDAP: ',
        'ldap_could_not_search' => 'Nie udało się przeszukać serwera LDAP. Sprawdź proszę konfigurację serwera LDAP w pliku konfiguracji. <br>Błąd z serwera LDAP:',
        'ldap_could_not_get_entries' => 'Nie udało się pobrać pozycji z serwera LDAP. Sprawdź proszę konfigurację serwera LDAP w pliku konfiguracji. <br>Błąd z serwera LDAP:',
        'password_ldap' => 'Hasło dla tego konta jest zarządzane przez usługę LDAP, Active Directory. Skontaktuj się z działem IT, aby zmienić swoje hasło. ',
    ),

    'deletefile' => array(
        'error'   => 'Pliki nie zostały usunięte. Spróbuj ponownie.',
        'success' => 'Pliki zostały usunięte.',
    ),

    'upload' => array(
        'error'   => 'Plik(i) nie zostały wysłane. Spróbuj ponownie.',
        'success' => 'Plik(i) zostały wysłane poprawnie.',
        'nofiles' => 'Nie wybrałeś żadnych plików do wysłania',
        'invalidfiles' => 'Jeden lub więcej z wybranych przez ciebie plików jest za duży lub jego typ nie jest dopuszczony. Dopuszczalne typy plików: png, gif, jpg, doc, docx, pdf, and txt.',
    ),

);
