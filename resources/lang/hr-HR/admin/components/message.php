<?php

return array(

    'does_not_exist' => 'Komponenta ne postoji.',

    'create' => array(
        'error'   => 'Komponenta nije izrađena, pokušajte ponovo.',
        'success' => 'Komponenta je uspješno izrađena.'
    ),

    'update' => array(
        'error'   => 'Komponenta nije ažurirana, pokušajte ponovo',
        'success' => 'Komponenta je uspješno ažurirana.'
    ),

    'delete' => array(
        'confirm'   => 'Jeste li sigurni da želite izbrisati ovu komponentu?',
        'error'   => 'Došlo je do problema s brisanjem komponente. Molim te pokušaj ponovno.',
        'success' => 'Komponenta je uspješno izbrisana.',
        'error_qty'   => 'Some components of this type are still checked out. Please check them in and try again.',
    ),

     'checkout' => array(
        'error'   		=> 'Komponenta nije provjerena, pokušajte ponovo',
        'success' 		=> 'Komponenta je uspješno provjerena.',
        'user_does_not_exist' => 'Taj je korisnik nevažeći. Molim te pokušaj ponovno.',
        'unavailable'      => 'Not enough components remaining: :remaining remaining, :requested requested ',
    ),

    'checkin' => array(
        'error'   		=> 'Komponenta nije prijavljena, pokušajte ponovo',
        'success' 		=> 'Komponenta je uspješno prijavljena.',
        'user_does_not_exist' => 'Taj je korisnik nevažeći. Molim te pokušaj ponovno.'
    )


);
