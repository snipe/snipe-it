<?php

return array(

    'does_not_exist' => 'Lokacija ne postoji.',
    'assoc_users'    => 'Ova lokaciju trenutno nije moguće obrisati zato što je lokacija zapisa barem jedne imovine ili korisnika, ima imovinu dodeljenu njoj, ili je nadlokacija drugoj lokaciji. Molim vas izmenite modele da više ne referenciraju ovu lokaciju i pokušajte ponovo. ',
    'assoc_assets'	 => 'Ta je lokacija trenutno povezana s barem jednim resursom i ne može se izbrisati. Ažurirajte resurs da se više ne referencira na tu lokaciju i pokušajte ponovno. ',
    'assoc_child_loc'	 => 'Ta je lokacija trenutno roditelj najmanje jednoj podredjenoj lokaciji i ne može se izbrisati. Ažurirajte svoje lokacije da se više ne referenciraju na ovu lokaciju i pokušajte ponovo. ',
    'assigned_assets' => 'Dodeljena imovina',
    'current_location' => 'Trenutna lokacija',
    'open_map' => 'Otvori u :map_provider_icon mapama',


    'create' => array(
        'error'   => 'Lokacija nije kreirana, pokušajte ponovo.',
        'success' => 'Lokacija je uspešno kreirana.'
    ),

    'update' => array(
        'error'   => 'Lokacija nije ažurirana, pokušajte ponovo',
        'success' => 'Lokacija je uspešno ažurirana.'
    ),

    'restore' => array(
        'error'   => 'Lokacija nije povraćena, molim vas pokušajte ponovo',
        'success' => 'Lokacija je uspešno povraćena.'
    ),

    'delete' => array(
        'confirm'   	=> 'Jeste li sigurni da želite izbrisati tu lokaciju?',
        'error'   => 'Došlo je do problema s brisanjem lokacije. Molim pokušajte ponovo.',
        'success' => 'Lokacija je uspešno obrisana.'
    )

);
