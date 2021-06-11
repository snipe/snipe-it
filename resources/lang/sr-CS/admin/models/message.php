<?php

return [

    'does_not_exist' => 'Model ne postoji.',
    'assoc_users'	 => 'Ovaj je model trenutno povezan s jednom ili više imovina i ne može se izbrisati. Izbrišite imovinu pa pokušajte ponovo. ',

    'create' => [
        'error'   => 'Model nije kreiran, pokušajte ponovo.',
        'success' => 'Model je uspešno kreiran.',
        'duplicate_set' => 'Model imovine s tim nazivom, proizvođačem i brojem modela već postoji.',
    ],

    'update' => [
        'error'   => 'Model nije ažuriran, pokušajte ponovo',
        'success' => 'Model je uspešno ažuriran.',
    ],

    'delete' => [
        'confirm'   => 'Jeste li sigurni da želite izbrisati ovaj model imovine?',
        'error'   => 'Došlo je do problema s brisanjem modela. Molim pokušajte ponovo.',
        'success' => 'Model je uspešno izbrisan.',
    ],

    'restore' => [
        'error'   		=> 'Model nije obnovljen, pokušajte ponovo',
        'success' 		=> 'Model je uspešno obnovljen.',
    ],

    'bulkedit' => [
        'error'   		=> 'Polja nisu menjana, tako da ništa nije ažurirano.',
        'success' 		=> 'Modeli su ažurirani.',
    ],

    'bulkdelete' => [
        'error'   		    => 'Nijedan model nije odabran, tako da ništa nije izbrisano.',
        'success' 		    => ':success_count model(a) izbrisan(o)!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.',
    ],

];
