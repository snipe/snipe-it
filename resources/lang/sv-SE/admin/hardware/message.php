<?php

return [

    'undeployable' 		=> '<strong>Varning: </strong> Den här tillgången har markerats som omöjlig för närvarande. Om denna status har ändrats uppdaterar du tillgångsstatusen.',
    'does_not_exist' 	=> 'Tillgång existerar inte.',
    'does_not_exist_or_not_requestable' => 'Den tillgången finns inte eller är inte önskvärd.',
    'assoc_users'	 	=> 'Denna tillgång kontrolleras för närvarande till en användare och kan inte raderas. Kontrollera tillgången först och försök sedan radera igen.',

    'create' => [
        'error'   		=> 'Tillgången skapades inte, försök igen. :(',
        'success' 		=> 'Asset skapades framgångsrikt. :)',
    ],

    'update' => [
        'error'   			=> 'Tillgången var inte uppdaterad, försök igen',
        'success' 			=> 'Asset uppdaterad framgångsrikt.',
        'nothing_updated'	=>  'Inga fält valdes, så ingenting uppdaterades.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Tillgången återställdes inte, försök igen',
        'success' 		=> 'Tillgången återställs framgångsrikt.',
    ],

    'audit' => [
        'error'   		=> 'Inventeringen av tillgången misslyckades. Var god försök igen.',
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
        'error'                 => 'Vissa objekt importerades inte korrekt.',
        'errorDetail'           => 'Följande objekt importerades inte på grund av fel.',
        'success'               => 'Din fil har importerats',
        'file_delete_success'   => 'Din fil har tagits bort',
        'file_delete_error'      => 'Filen kunde inte raderas',
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
