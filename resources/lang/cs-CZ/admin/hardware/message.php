<?php

return [

    'undeployable' 		 => '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	 => 'Majetek nenalezen.',
    'does_not_exist_var' => 'Asset with tag :asset_tag not found.',
    'no_tag' 	         => 'No asset tag provided.',
    'does_not_exist_or_not_requestable' => 'Tento majetek neexistuje nebo jej nelze vyskladnit.',
    'assoc_users'	 	 => 'Majetek je předán svému uživateli a nelze jej odstranit. Před odstraněním jej nejprve převezměte. ',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',
    'labels_generated'   => 'Labels were successfully generated.',
    'error_generating_labels' => 'Error while generating labels.',
    'no_assets_selected' => 'No assets selected.',

    'create' => [
        'error'   		=> 'Majetek se nepodařilo vytvořit, zkuste to prosím znovu.',
        'success' 		=> 'Majetek byl v pořádku vytvořen.',
        'success_linked' => 'Asset with tag :tag was created successfully. <strong><a href=":link" style="color: white;">Click here to view</a></strong>.',
        'multi_success_linked' => 'Asset with tag :links was created successfully.|:count assets were created succesfully. :links.',
        'partial_failure' => 'An asset was unable to be created. Reason: :failures|:count assets were unable to be created. Reasons: :failures',
    ],

    'update' => [
        'error'   			=> 'Majetek se nepodařilo upravit, zkuste to prosím znovu',
        'success' 			=> 'Majetek úspěšně aktualizován.',
        'encrypted_warning' => 'Majetek byl úspěšně aktualizován, ale šifrovaná vlastní pole nebyla způsobena oprávněním',
        'nothing_updated'	=>  'Nebyla zvolena žádná pole, nic se tedy neupravilo.',
        'no_assets_selected'  =>  'Nebyl zvolen žádný majetek, nic se tedy neupravilo.',
        'assets_do_not_exist_or_are_invalid' => 'Vybrané položky nelze aktualizovat.',
    ],

    'restore' => [
        'error'   		=> 'Majetek se nepodařilo obnovit, zkuste to prosím později',
        'success' 		=> 'Majetek byl v pořádku obnoven.',
        'bulk_success' 		=> 'Majetek byl v pořádku obnoven.',
        'nothing_updated'   => 'Nevybrali jste žádné položky, nic tedy nebylo obnoveno.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
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
        'import_button'         => 'Process Import',
        'error'                 => 'Některé položky nebyly správně importovány.',
        'errorDetail'           => 'Následující položky nebyly importovány kvůli chybám.',
        'success'               => 'Váš soubor byl importován',
        'file_delete_success'   => 'Váš soubor byl úspěšně odstraněn',
        'file_delete_error'      => 'Soubor nelze odstranit',
        'file_missing' => 'Vybraný soubor chybí',
        'file_already_deleted' => 'The file selected was already deleted',
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

    'multi-checkout' => [
        'error'   => 'Asset was not checked out, please try again|Assets were not checked out, please try again',
        'success' => 'Asset checked out successfully.|Assets checked out successfully.',
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
