<?php

return [

    'undeployable' 		=> '<strong>Uwaga: </strong> To aktywo zostało oznaczone jako tymczasowo niemożliwe do wdrożenia.
                        Jeśli jego stan się zmienił, zaktualizuj status aktywa.',
    'does_not_exist' 	=> 'Nabytek/zasób nie istnieje.',
    'does_not_exist_or_not_requestable' => 'Aktywo nie istnieje albo nie można go zażądać.',
    'assoc_users'	 	=> 'Ten nabytek/zasób jest przypisany do użytkownika i nie może być usunięty. Proszę sprawdzić przypisanie nabytków/zasobów a następnie spróbować ponownie.',

    'create' => [
        'error'   		=> 'Nabytek nie został utworzony, proszę spróbować ponownie. :(',
        'success' 		=> 'Nowy nabytek został utworzony. :)',
    ],

    'update' => [
        'error'   			=> 'Nie zaktualizowano nabytku/zasobu, proszę spróbować ponownie',
        'success' 			=> 'Aktualizacja poprawna.',
        'nothing_updated'	=>  'Żadne pole nie zostało wybrane, więc nic nie zostało zmienione.',
        'no_assets_selected'  =>  'Żadne aktywa nie zostały wybrane, więc nic nie zostało zmienione.',
    ],

    'restore' => [
        'error'   		=> 'Aktywo nie został przywrócony, spróbuj ponownie.',
        'success' 		=> 'Aktywo zostało przywrócone.',
    ],

    'audit' => [
        'error'   		=> 'Audyt aktywów nie powiódł się. Proszę spróbować ponownie.',
        'success' 		=> 'Audyt aktywów pomyślnie zarejestrowany.',
    ],


    'deletefile' => [
        'error'   => 'Plik nie zostały usunięte. Spróbuj ponownie.',
        'success' => 'Plik zostały usunięty.',
    ],

    'upload' => [
        'error'   => 'Plik(i) nie zostały wysłane. Spróbuj ponownie.',
        'success' => 'Plik(i) zostały wysłane.',
        'nofiles' => 'Nie wybrałeś żadnych plików do przesłania, albo plik, który próbujesz przekazać jest zbyt duży',
        'invalidfiles' => 'Jeden lub więcej z wybranych przez ciebie plików jest jest za duży lub jego typ jest niewłaściwy. Dopuszczalne typy plików: png, gif, jpg, doc, docx, pdf, and txt.',
    ],

    'import' => [
        'error'                 => 'Niektóre elementy nie zostały poprawnie zaimportowane.',
        'errorDetail'           => 'Następujące elementy nie zostały zaimportowane z powodu błędów.',
        'success'               => 'Twój plik został zaimportowany',
        'file_delete_success'   => 'Twój plik został poprawnie usunięty',
        'file_delete_error'      => 'Plik nie może zostać usunięty',
    ],


    'delete' => [
        'confirm'   	=> 'Czy na pewno chcesz usunąć?',
        'error'   		=> 'Nie można usunąć. Proszę spróbować ponownie.',
        'nothing_updated'   => 'Aktywa nie zostały wybrane, więc nic nie zostało usunięte.',
        'success' 		=> 'Nabytek został usunięty.',
    ],

    'checkout' => [
        'error'   		=> 'Nie mogę wypisać nabytku/zasobu, proszę spróbować ponownie.',
        'success' 		=> 'Przypisano nabytek/zasób.',
        'user_does_not_exist' => 'Nieprawidłowy użytkownik. Proszę spróbować ponownie.',
        'not_available' => 'Ten składnik aktywów nie jest dostępny do zamówienia!',
        'no_assets_selected' => 'Musisz wybrać co najmniej jeden zasób z listy',
    ],

    'checkin' => [
        'error'   		=> 'Nie można przypisać nabytku/zasobu, proszę spróbować ponownie',
        'success' 		=> 'Nabytek/zasób przypisany.',
        'user_does_not_exist' => 'Nieprawidłowy użytkownik. Proszę spróbować ponownie.',
        'already_checked_in'  => 'Aktywo jest już zaewidencjonowane.',

    ],

    'requests' => [
        'error'   		=> 'Aktywo nie zostało zawnioskowane, spróbuj ponownie',
        'success' 		=> 'Aktywo zawnioskowe pomyślnie.',
        'canceled'      => 'Żądanie przypisania zostało anulowane',
    ],

];
