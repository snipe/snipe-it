<?php

return array(

    'undeployable' 		=> '<strong>Uwaga: </strong> To aktywo zostało oznaczone jako tymczasowo niemożliwe do wdrożenia.
                        Jeśli jego stan się zmienił, zaktualizuj status aktywa.',
    'does_not_exist' 	=> 'Nabytek/zasób nie istnieje.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Ten nabytek/zasób jest przypisany do użytkownika i nie może być usunięty. Proszę sprawdzić przypisanie nabytków/zasobów a następnie spróbować ponownie.',

    'create' => array(
        'error'   		=> 'Nabytek nie został utworzony, proszę spróbować ponownie. :(',
        'success' 		=> 'Nowy nabytek został utworzony. :)'
    ),

    'update' => array(
        'error'   			=> 'Nie zaktualizowano nabytku/zasobu, proszę spróbować ponownie',
        'success' 			=> 'Aktualizacja poprawna.',
        'nothing_updated'	=>  'Żadne pole nie zostało wybrane, więc nic nie zostało zmienione.',
    ),

    'restore' => array(
        'error'   		=> 'Aktywo nie został przywrócony, spróbuj ponownie.',
        'success' 		=> 'Aktywo zostało przywrócone.'
    ),

    'deletefile' => array(
        'error'   => 'Plik nie zostały usunięte. Spróbuj ponownie.',
        'success' => 'Plik zostały usunięty.',
    ),

    'upload' => array(
        'error'   => 'Plik(i) nie zostały wysłane. Spróbuj ponownie.',
        'success' => 'Plik(i) zostały wysłane.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'Jeden lub więcej z wybranych przez ciebie plików jest jest za duży lub jego typ jest niewłaściwy. Dopuszczalne typy plików: png, gif, jpg, doc, docx, pdf, and txt.',
    ),

    'import' => array(
        'error'         => 'Some Items did not import Correctly.',
        'errorDetail'   => 'The Following Items were not imported because of errors.',
        'success'       => "Your File has been imported",
    ),


    'delete' => array(
        'confirm'   	=> 'Czy na pewno chcesz usunąć?',
        'error'   		=> 'Nie można usunąć. Proszę spróbować ponownie.',
        'success' 		=> 'Nabytek został usunięty.'
    ),

    'checkout' => array(
        'error'   		=> 'Nie mogę wypisać nabytku/zasobu, proszę spróbować ponownie.',
        'success' 		=> 'Przypisano nabytek/zasób.',
        'user_does_not_exist' => 'Nieprawidłowy użytkownik. Proszę spróbować ponownie.'
    ),

    'checkin' => array(
        'error'   		=> 'Nie można przypisać nabytku/zasobu, proszę spróbować ponownie',
        'success' 		=> 'Nabytek/zasób przypisany.',
        'user_does_not_exist' => 'Nieprawidłowy użytkownik. Proszę spróbować ponownie.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
    )

);
