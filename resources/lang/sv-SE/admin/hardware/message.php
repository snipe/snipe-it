<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable. If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Tillgång existerar inte.',
    'does_not_exist_var'=> 'Asset with tag :asset_tag not found.',
    'no_tag' 	        => 'No asset tag provided.',
    'does_not_exist_or_not_requestable' => 'Den tillgången finns inte eller är inte önskvärd.',
    'assoc_users'	 	=> 'Denna tillgång kontrolleras för närvarande till en användare och kan inte raderas. Kontrollera tillgången först och försök sedan radera igen.',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',

    'create' => [
        'error'   		=> 'Tillgången skapades inte, försök igen. :(',
        'success' 		=> 'Asset skapades framgångsrikt. :)',
        'success_linked' => 'Tillgången med taggen :tag har skapats. <strong><a href=":link" style="color: white;">Klicka här för att se</a></strong>.',
    ],

    'update' => [
        'error'   			=> 'Tillgången var inte uppdaterad, försök igen',
        'success' 			=> 'Asset uppdaterad framgångsrikt.',
        'encrypted_warning' => 'Tillgången uppdaterades framgångsrikt, men krypterade anpassade fält berodde inte på behörigheter',
        'nothing_updated'	=>  'Inga fält valdes, så ingenting uppdaterades.',
        'no_assets_selected'  =>  'Inga tillgångar valdes, så ingenting uppdaterades.',
        'assets_do_not_exist_or_are_invalid' => 'Valda tillgångar kan inte uppdateras.',
    ],

    'restore' => [
        'error'   		=> 'Tillgången återställdes inte, försök igen',
        'success' 		=> 'Tillgången återställs framgångsrikt.',
        'bulk_success' 		=> 'Återställning av tillgång lyckades.',
        'nothing_updated'   => 'Inga tillgångar valdes, så ingenting återställdes.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
        'success' 		=> 'Inventeringen av tillgången har loggats.',
    ],


    'deletefile' => [
        'error'   => 'Filen har inte tagits bort. Var god försök igen.',
        'success' => 'Filen har tagits bort.',
    ],

    'upload' => [
        'error'   => 'Fil (er) inte uppladdade. Var god försök igen.',
        'success' => 'Filer som har laddats upp.',
        'nofiles' => 'Du valde inte några filer för uppladdning, eller filen du försöker ladda upp är för stor',
        'invalidfiles' => 'En eller flera av dina filer är för stora eller är en filtyp som inte är tillåten. Tillåtna filtyper är png, gif, jpg, doc, docx, pdf och txt.',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Vissa objekt importerades inte korrekt.',
        'errorDetail'           => 'Följande objekt importerades inte på grund av fel.',
        'success'               => 'Din fil har importerats',
        'file_delete_success'   => 'Din fil har tagits bort',
        'file_delete_error'      => 'Filen kunde inte raderas',
        'file_missing' => 'Den valda filen saknas',
        'file_already_deleted' => 'The file selected was already deleted',
        'header_row_has_malformed_characters' => 'Ett eller flera attribut i rubrikraden innehåller felaktigt formatterade UTF-8-tecken',
        'content_row_has_malformed_characters' => 'Ett eller flera attribut i den första raden av innehållet innehåller felaktigt formatterade UTF-8-tecken',
    ],


    'delete' => [
        'confirm'   	=> 'Är du säker på att du vill radera den här tillgången?',
        'error'   		=> 'Det gick inte att ta bort tillgången. Var god försök igen.',
        'nothing_updated'   => 'Inga tillgångar valdes, så ingenting togs bort.',
        'success' 		=> 'Tillgången raderades framgångsrikt.',
    ],

    'checkout' => [
        'error'   		=> 'Tillgången utcheckades inte, försök igen',
        'success' 		=> 'Tillgången checkas ut framgångsrikt.',
        'user_does_not_exist' => 'Den användaren är ogiltig. Var god försök igen.',
        'not_available' => 'Den tillgången är inte tillgänglig för kassan!',
        'no_assets_selected' => 'Du måste välja minst en tillgång från listan',
    ],

    'checkin' => [
        'error'   		=> 'Tillgången kontrollerades inte, försök igen',
        'success' 		=> 'Asset kontrolleras framgångsrikt.',
        'user_does_not_exist' => 'Den användaren är ogiltig. Var god försök igen.',
        'already_checked_in'  => 'Den tillgången är redan incheckad.',

    ],

    'requests' => [
        'error'   		=> 'Tillgången begärdes inte, försök igen',
        'success' 		=> 'Tillgången begärdes framgångsrikt.',
        'canceled'      => 'Checkout förfrågan har avbrutits',
    ],

];
