<?php

return array(

    'does_not_exist' => 'Model ne postoji.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Ovaj je model trenutno povezan s jednom ili više imovine i ne može se izbrisati. Izbrišite imovinu pa pokušajte ponovo ukloniti.',


    'create' => array(
        'error'   => 'Model nije izrađen, pokušajte ponovo.',
        'success' => 'Model je uspješno izrađen.',
        'duplicate_set' => 'Model imovine s tim nazivom, proizvođačem i brojem modela već postoji.',
    ),

    'update' => array(
        'error'   => 'Model nije ažuriran, pokušajte ponovo',
        'success' => 'Model je uspješno ažuriran.',
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
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Nijedan model nije odabran, tako da ništa nije izbrisano.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':success_count model(a) je izbrisano, no :fail_count nije bilo moguće izbrisati jer još uvijek imaju imovinu povezanu s njima.'
    ),

);
