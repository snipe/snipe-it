<?php

return [

    'undeployable' 		=> '<strong>Varování:</strong> Toto zařízení bylo označeno jako momentálně nepřiřaditelné.
                        Pokud se na jeho stavu něco změnilo, upravte jej.',
    'does_not_exist' 	=> 'Majetek nenalezen.',
    'does_not_exist_or_not_requestable' => 'Tento majetek neexistuje nebo jej nelze vyskladnit.',
    'assoc_users'	 	=> 'Majetek je předán svému uživateli a nelze jej odstranit. Před odstraněním jej nejprve převezměte. ',

    'create' => [
        'error'   		=> 'Majetek se nepodařilo vytvořit, zkuste to prosím znovu.',
        'success' 		=> 'Majetek byl v pořádku vytvořen.',
    ],

    'update' => [
        'error'   			=> 'Majetek se nepodařilo upravit, zkuste to prosím znovu',
        'success' 			=> 'Majetek úspěšně aktualizován.',
        'nothing_updated'	=>  'Nebyla zvolena žádná pole, nic se tedy neupravilo.',
        'no_assets_selected'  =>  'Nebyl zvolen žádný majetek, nic se tedy neupravilo.',
    ],

    'restore' => [
        'error'   		=> 'Majetek se nepodařilo obnovit, zkuste to prosím později',
        'success' 		=> 'Majetek byl v pořádku obnoven.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'No assets were selected, so nothing was restored.', 
    ],

    'audit' => [
        'error'   		=> 'Audit majetku byl neúspěšný. Prosím zkuste to znovu.',
        'success' 		=> 'Audit aktiv byl úspěšně zaznamenáván.',
    ],


    'deletefile' => [
        'error'   => 'Soubor se nesmazal, prosím zkuste to znovu.',
        'success' => 'Soubor byl úspěšně smazán.',
    ],

    'upload' => [
        'error'   => 'Soubor(y) se nepodařilo nahrát, zkuste to prosím znovu.',
        'success' => 'Soubor(y) byly v pořádku nahrány.',
        'nofiles' => 'K nahrání jste nevybrali žádný, nebo příliš velký soubor',
        'invalidfiles' => 'Jeden nebo více označených souborů je příliš velkých nebo nejsou podporované. Povolenými příponami jsou png, gif, pdf a txt.',
    ],

    'import' => [
        'error'                 => 'Některé položky nebyly správně importovány.',
        'errorDetail'           => 'Následující položky nebyly importovány kvůli chybám.',
        'success'               => 'Váš soubor byl importován',
        'file_delete_success'   => 'Váš soubor byl úspěšně odstraněn',
        'file_delete_error'      => 'Soubor nelze odstranit',
        'header_row_has_malformed_characters' => 'Jeden nebo více sloupců obsahuje v záhlaví poškozené UTF-8 znaky',
        'content_row_has_malformed_characters' => 'Jedna nebo více hodnot v prvním řádku obsahu obsahuje poškozené UTF-8 znaky',
    ],


    'delete' => [
        'confirm'   	=> 'Opravdu si přejete tento majetek odstranit?',
        'error'   		=> 'Nepodařilo se nám tento majetek odstranit. Zkuste to prosím znovu.',
        'nothing_updated'   => 'Žádný majetek nebyl vybrán, takže nic nebylo odstraněno.',
        'success' 		=> 'Majetek byl úspěšně smazán.',
    ],

    'checkout' => [
        'error'   		=> 'Majetek nebyl předán, zkuste to prosím znovu',
        'success' 		=> 'Majetek byl v pořádku předán.',
        'user_does_not_exist' => 'Tento uživatel je neplatný. Zkuste to prosím znovu.',
        'not_available' => 'Tento majetek není k dispozici pro výdej!',
        'no_assets_selected' => 'Je třeba vybrat ze seznamu alespoň jeden majetek',
    ],

    'checkin' => [
        'error'   		=> 'Majetek nebyl převzat. Zkuste to prosím znovu',
        'success' 		=> 'Majetek byl v pořádku převzat.',
        'user_does_not_exist' => 'Tento uživatel je neplatný. Zkuste to prosím znovu.',
        'already_checked_in'  => 'Tento majetek je již předaný.',

    ],

    'requests' => [
        'error'   		=> 'Majetek nebyl vyžádán, zkuste to prosím znovu',
        'success' 		=> 'Vyžádání majetku proběhlo v pořádku.',
        'canceled'      => 'Požadavek na výdej byl úspěšně zrušen',
    ],

];
