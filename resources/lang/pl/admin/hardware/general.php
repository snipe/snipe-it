<?php

return [
    'about_assets_title'           => 'O Aktywach',
    'about_assets_text'            => 'Aktywa są to elementy identyfikowane przez numer seryjny lub etykietę.  Są to przedmioty o większej wartości, gdzie liczy się identyfikacji określonego elementu.',
    'archived'  				=> 'Zarchiwizowane',
    'asset'  					=> 'Nabytek',
    'bulk_checkout'             => 'Przypisz aktywa',
    'bulk_checkin'              => 'Przyjmij aktywa',
    'checkin'  					=> 'Potwierdzanie zasobu/aktywa',
    'checkout'  				=> 'Przypisz zasób',
    'clone'  					=> 'Klonuj zasób',
    'deployable'  				=> 'Gotowe do wdrożenia',
    'deleted'  					=> 'Ten zasób został usunięty.',
    'edit'  					=> 'Edytuj zasób',
    'model_deleted'  			=> 'Ten model zasobów został usunięty. Musisz przywrócić model zanim będziesz mógł przywrócić zasób.',
    'model_invalid'             => 'Model tego zasobu jest nieprawidłowy.',
    'model_invalid_fix'         => 'Zasób powinien być edytowany w celu poprawienia tego przed próbą przyjęcia go lub wydania.',
    'requestable'               => 'Żądane',
    'requested'				    => 'Zamówione',
    'not_requestable'           => 'Brak możliwości zarządzania',
    'requestable_status_warning' => 'Nie zmieniaj statusu możliwości zarządzania',
    'restore'  					=> 'Przywróć aktywa',
    'pending'  					=> 'Oczekuje',
    'undeployable'  			=> 'Niemożliwe do wdrożenia',
    'undeployable_tooltip'  	=> 'This asset has a status label that is undeployable and cannot be checked out at this time.',
    'view'  					=> 'Wyświetl nabytki',
    'csv_error' => 'Wystąpił błąd w twoim pliku CSV:',
    'import_text' => '
<p>
     Prześlij plik CSV zawierający historię zasobów. Zasoby i użytkownicy MUSZĄ już istnieć w systemie, w przeciwnym razie zostaną pominięci. Dopasowanie zasobów do importu historii odbywa się na podstawie tagu zasobu. Spróbujemy znaleźć pasującego użytkownika na podstawie podanej przez Ciebie nazwy użytkownika i kryteriów wybranych poniżej. Jeśli nie wybierzesz żadnych kryteriów poniżej, po prostu spróbuje dopasować format nazwy użytkownika skonfigurowany na stronie Administrator &gt; Ustawienia główne.
     </p>

     <p>Pola zawarte w pliku CSV muszą być zgodne z nagłówkami: <strong>Etykieta zasobu, Nazwa, Data wymeldowania, Data zameldowania</strong>. Wszelkie dodatkowe pola będą ignorowane. </p>

     <p>Data zaewidencjonowania: puste lub przyszłe daty zaewidencjonowania spowodują wyewidencjonowanie przedmiotów dla powiązanego użytkownika. Wykluczenie kolumny Data zameldowania spowoduje utworzenie daty zameldowania z dzisiejszą datą.</p>    ',
    'csv_import_match_f-l' => 'Spróbuj dopasować użytkowników przez imię.nazwisko (jan.kowalski)',
    'csv_import_match_initial_last' => 'Spróbuj dopasować użytkowników przez pierwszą literę imienia i nazwisko (jkowalski)',
    'csv_import_match_first' => 'Spróbuj dopasować użytkowników według formatu imienia (jane)',
    'csv_import_match_email' => 'Spróbuj dopasować użytkowników po adresie e-mail',
    'csv_import_match_username' => 'Spróbuj dopasować użytkowników po nazwie użytkownika',
    'error_messages' => 'Komunikat błędu:',
    'success_messages' => 'Wiadomości o powodzeniu:',
    'alert_details' => 'Więcej szczegółów znajduje się poniżej.',
    'custom_export' => 'Eksport niestandardowy',
    'mfg_warranty_lookup' => ':Producent Wyszukiwarka Statusu Gwarancji',
];
