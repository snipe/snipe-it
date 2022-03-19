<?php

return array(

    'does_not_exist' => 'License does not exist.',
    'user_does_not_exist' => 'User does not exist.',
    'asset_does_not_exist' 	=> 'The asset you are trying to associate with this license does not exist.',
    'owner_doesnt_match_asset' => 'The asset you are trying to associate with this license is owned by somene other than the person selected in the assigned to dropdown.',
    'assoc_users'	 => 'This license is currently checked out to a user and cannot be deleted. Please check the license in first, and then try deleting again. ',
    'select_asset_or_person' => 'You must select an asset or a user, but not both.',
    'not_found' => 'License not found',


    'create' => array(
        'error'   => 'License was not created, please try again.',
        'success' => 'License created successfully.'
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'Súbor bol úspešne odstránený.',
    ),

    'upload' => array(
        'error'   => 'Súbor(y) sa nepodarilo nahrať. Skúste prosím znovu.',
        'success' => 'Súbor(y) boli úspešne nahraté.',
        'nofiles' => 'Nevybrali ste žiadne súbory na nahranie alebo sa pokúšate nahrať príliž veľký súbor',
        'invalidfiles' => 'Jeden alebo viacero súborov je príliš veľkých alebo nie su podporované. Podporované typy súborov sú png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml, and lic.',
    ),

    'update' => array(
        'error'   => 'Licencia nebola aktualizovaná, skúste prosím znovu',
        'success' => 'Licencia bola úspešne aktualizovaná.'
    ),

    'delete' => array(
        'confirm'   => 'Ste si istý, že chcete odstrániť túto licenciu?',
        'error'   => 'Pri odstraňovaní licencie nastala chyba. Skúste prosím znovu.',
        'success' => 'Licencia bola úspešne odstránená.'
    ),

    'checkout' => array(
        'error'   => 'Pri priraďovaní licencie nastala chyba. Skúste prosím znovu.',
        'success' => 'Licencia bola úspešne priradená'
    ),

    'checkin' => array(
        'error'   => 'Pri odoberaní licencie nastala chyba. Skúste prosím znovu.',
        'success' => 'Licencia bola úspešne odobratá'
    ),

);
