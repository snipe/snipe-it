<?php

return array(

    'does_not_exist' => 'Licencja nie istnieje.',
    'user_does_not_exist' => 'Użytkownik nie istnieje.',
    'asset_does_not_exist' 	=> 'Aktywa, które chcesz skojarzyć z licencją nie istnieją.',
    'owner_doesnt_match_asset' => 'Aktywa, które chcesz skojarzyć z tą licencją są własnością kogoś innego niż osoba wskazana z rozwijanej listy.',
    'assoc_users'	 => 'Ten nabytek/zasób jest przypisany do użytkownika i nie może być usunięty. Proszę sprawdzić przypisanie nabytków/zasobów a następnie spróbować ponownie. ',


    'create' => array(
        'error'   => 'Licencja nie została utworzona, spróbuj ponownie.',
        'success' => 'Licencja została utworzona pomyślnie.'
    ),

    'deletefile' => array(
        'error'   => 'Plik nie został usunięty. Spróbuj ponownie.',
        'success' => 'Plik został usunięty pomyślnie.',
    ),

    'upload' => array(
        'error'   => 'Plik(i) nie zostały wysłane. Spróbuj ponownie.',
        'success' => 'Plik(i) zostały wysłane poprawnie.',
        'nofiles' => 'Nie wybrałeś żadnych plików do przesłania, albo plik, który próbujesz przekazać jest zbyt duży',
<<<<<<< HEAD
        'invalidfiles' => 'Jeden lub więcej z wybranych przez ciebie plików jest za duży lub jego typ nie jest dopuszczony. Dopuszczalne typy plików: png, gif, jpg, doc, docx, pdf, and txt.',
=======
        'invalidfiles' => 'Jeden lub więcej Twoich plików jest zbyt duży dla tego rodzaju pliku. Dozwolone formaty to png, gif, jpg, doc, docx, pdf, txt, zip, rar i rtf',
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),

    'update' => array(
        'error'   => 'Licencja nie została uaktualniona, spróbuj ponownie',
        'success' => 'Licencja została zaktualizowana pomyślnie.'
    ),

    'delete' => array(
        'confirm'   => 'Czy jesteś pewny, że chcesz usunąć tą licencję?',
        'error'   => 'Wystąpił problem podczas usuwania licencji. Spróbuj ponownie.',
        'success' => 'Licencja została usunięta pomyślnie.'
    ),

    'checkout' => array(
<<<<<<< HEAD
        'error'   => 'There was an issue checking out the license. Please try again.',
        'success' => 'The license was checked out successfully'
    ),

    'checkin' => array(
        'error'   => 'There was an issue checking in the license. Please try again.',
        'success' => 'The license was checked in successfully'
=======
        'error'   => 'Nastąpił problem podczas weryfikacji licencji. Spróbuj ponownie',
        'success' => 'Licencja poprawna'
    ),

    'checkin' => array(
        'error'   => 'Nastąpił problem podczas weryfikacji licencji. Spróbuj ponownie',
        'success' => 'Licencja poprawna'
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),

);
