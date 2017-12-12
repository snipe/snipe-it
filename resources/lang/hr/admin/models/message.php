<?php

return array(

    'does_not_exist' => 'Model ne postoji.',
    'assoc_users'	 => 'Ovaj je model trenutno povezan s jednom ili više imovine i ne može se izbrisati. Izbrišite imovinu pa pokušajte ponovo ukloniti.',


    'create' => array(
        'error'   => 'Model nije izrađen, pokušajte ponovo.',
        'success' => 'Model je uspješno izrađen.',
        'duplicate_set' => 'Model imovine s tim nazivom, proizvođačem i brojem modela već postoji.',
    ),

    'update' => array(
        'error'   => 'Model nije ažuriran, pokušajte ponovo',
        'success' => 'Model je uspješno ažuriran.'
    ),

    'delete' => array(
        'confirm'   => 'Jeste li sigurni da želite izbrisati ovaj model sredstva?',
        'error'   => 'Došlo je do problema s brisanjem modela. Molim te pokušaj ponovno.',
        'success' => 'Model je uspješno izbrisan.'
    ),

    'restore' => array(
        'error'   		=> 'Model nije obnovljen, pokušajte ponovo',
        'success' 		=> 'Model je uspješno obnovljen.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Nijedna polja nisu promijenjena, tako da ništa nije ažurirano.',
        'success' 		=> 'Modeli su ažurirani.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
