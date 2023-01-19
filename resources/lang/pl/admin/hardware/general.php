<?php

return [
    'about_assets_title'           => 'O Aktywach',
    'about_assets_text'            => 'Aktywa są to elementy identyfikowane przez numer seryjny lub etykietę.  Są to przedmioty o większej wartości, gdzie liczy się identyfikacji określonego elementu.',
    'archived'  				=> 'Zarchiwizowane',
    'asset'  					=> 'Nabytek',
    'bulk_checkout'             => 'Przypisz aktywa',
    'bulk_checkin'              => 'Checkin Assets',
    'checkin'  					=> 'Potwierdzanie zasobu/aktywa',
    'checkout'  				=> 'Przypisz zasób',
    'clone'  					=> 'Klonuj zasób',
    'deployable'  				=> 'Gotowe do wdrożenia',
    'deleted'  					=> 'Ten zasób został usunięty.',
    'edit'  					=> 'Edytuj zasób',
    'model_deleted'  			=> 'Ten model zasobów został usunięty. Musisz przywrócić model zanim będziesz mógł przywrócić zasób.',
    'requestable'               => 'Żądane',
    'requested'				    => 'Zamówione',
    'not_requestable'           => 'Not Requestable',
    'requestable_status_warning' => 'Do not change  requestable status',
    'restore'  					=> 'Przywróć aktywa',
    'pending'  					=> 'Oczekuje',
    'undeployable'  			=> 'Niemożliwe do wdrożenia',
    'view'  					=> 'Wyświetl nabytki',
    'csv_error' => 'Wystąpił błąd w twoim pliku CSV:',
    'import_text' => '
    <p>
    Upload a CSV that contains asset history. The assets and users MUST already exist in the system, or they will be skipped. Matching assets for history import happens against the asset tag. We will try to find a matching user based on the user\'s name you provide, and the criteria you select below. If you do not select any criteria below, it will simply try to match on the username format you configured in the Admin &gt; General Settings.
    </p>

    <p>Fields included in the CSV must match the headers: <strong>Asset Tag, Name, Checkout Date, Checkin Date</strong>. Any additional fields will be ignored. </p>

    <p>Checkin Date: blank or future checkin dates will checkout items to associated user.  Excluding the Checkin Date column will create a checkin date with todays date.</p>
    ',
    'csv_import_match_f-l' => 'Try to match users by firstname.lastname (jane.smith) format',
    'csv_import_match_initial_last' => 'Try to match users by first initial last name (jsmith) format',
    'csv_import_match_first' => 'Try to match users by first name (jane) format',
    'csv_import_match_email' => 'Spróbuj dopasować użytkowników po adresie e-mail',
    'csv_import_match_username' => 'Spróbuj dopasować użytkowników po nazwie użytkownika',
    'error_messages' => 'Komunikat błędu:',
    'success_messages' => 'Success messages:',
    'alert_details' => 'Więcej szczegółów znajduje się poniżej.',
    'custom_export' => 'Eksport niestandardowy'
];
