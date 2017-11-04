<?php

return array(

    'undeployable' 		=> '<strong>Varování:</strong> Toto zařízení bylo označeno jako momentálně nepřiřaditelné.
                        Pokud se na jeho stavu něco změnilo, upravte jej.',
    'does_not_exist' 	=> 'Majetek nenalezen.',
    'does_not_exist_or_not_requestable' => 'Hezký pokus, ale majetek buď neexistuje, nebo není možné jej převzít.',
    'assoc_users'	 	=> 'Majetek je předán svému uživateli a nelze jej odstranit. Před odstraněním jej nejprve převezměte. ',

    'create' => array(
        'error'   		=> 'Majetek se nepodařilo vytvořit, zkuste to prosím znovu.',
        'success' 		=> 'Majetek byl v pořádku vytvořen.'
    ),

    'update' => array(
        'error'   			=> 'Majetek se nepodařilo upravit, zkuste to prosím znovu',
        'success' 			=> 'Majetek úspěšně aktualizován.',
        'nothing_updated'	=>  'Nebyla zvolena žádná pole, nic se tedy neupravilo.',
    ),

    'restore' => array(
        'error'   		=> 'Majetek se nepodařilo obnovit, zkuste to prosím později',
        'success' 		=> 'Majetek byl v pořádku obnoven.'
    ),

    'audit' => array(
        'error'   		=> 'Audit majetku byl neúspěšný. Prosím zkuste to znovu.',
        'success' 		=> 'Audit aktiv byl úspěšně zaznamenáván.'
    ),


    'deletefile' => array(
        'error'   => 'Soubor se nesmazal, prosím zkuste to znovu.',
        'success' => 'Soubor byl úspěšně smazán.',
    ),

    'upload' => array(
        'error'   => 'Soubor(y) se nepodařilo nahrát, zkuste to prosím znovu.',
        'success' => 'Soubor(y) byly v pořádku nahrány.',
        'nofiles' => 'K nahrání jste nevybrali žádný, nebo příliš velký soubor',
        'invalidfiles' => 'Jeden nebo více označených souborů je příliš velkých nebo nejsou podporované. Povolenými příponami jsou png, gif, pdf a txt.',
    ),

    'import' => array(
        'error'                 => 'Některé položky nebyly správně importovány.',
        'errorDetail'           => 'Následující položky nebyly importovány kvůli chybám.',
        'success'               => "Váš soubor byl importován",
        'file_delete_success'   => "Váš soubor byl úspěšně odstraněn",
        'file_delete_error'      => "Soubor nelze odstranit",
    ),


    'delete' => array(
        'confirm'   	=> 'Opravdu si přejete tento majetek odstranit?',
        'error'   		=> 'Nepodařilo se nám tento majetek odstranit. Zkuste to prosím znovu.',
        'nothing_updated'   => 'Žádný majetek nebyl vybrán, takže nic nebylo odstraněno.',
        'success' 		=> 'Majetek byl úspěšně smazán.'
    ),

    'checkout' => array(
        'error'   		=> 'Majetek nebyl předán, zkuste to prosím znovu',
        'success' 		=> 'Majetek byl v pořádku předán.',
        'user_does_not_exist' => 'Tento uživatel je neplatný. Zkuste to prosím znovu.',
        'not_available' => 'Tento majetek není k dispozici pro výdej!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> 'Majetek nebyl převzat. Zkuste to prosím znovu',
        'success' 		=> 'Majetek byl v pořádku převzat.',
        'user_does_not_exist' => 'Tento uživatel je neplatný. Zkuste to prosím znovu.',
        'already_checked_in'  => 'Tento majetek je již předaný.',

    ),

    'requests' => array(
        'error'   		=> 'Majetek nebyl vyžádán, zkuste to prosím znovu',
        'success' 		=> 'Vyžádání majetku proběhlo v pořádku.',
        'canceled'      => 'Požadavek na výdej byl úspěšně zrušen'
    )

);
