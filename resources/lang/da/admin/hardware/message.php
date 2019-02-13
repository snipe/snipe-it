<?php

return array(

    'undeployable' 		=> '<strong>Advarsel: </strong> Dette aktiv er blevet markeret som uudnytteligt. Hvis denne status er ændret, skal du opdatere aktivstatus.',
    'does_not_exist' 	=> 'Asset eksisterer ikke.',
    'does_not_exist_or_not_requestable' => 'Godt forsøgt. Det pågældende aktiv eksisterer ikke eller kan ikke anmodes om.',
    'assoc_users'	 	=> 'Dette aktiv er i øjeblikket tjekket ud til en bruger og kan ikke slettes. Kontroller aktivet først, og prøv derefter at slette igen.',

    'create' => array(
        'error'   		=> 'Akten blev ikke oprettet, prøv igen. :(',
        'success' 		=> 'Aktivet blev oprettet med succes. :)'
    ),

    'update' => array(
        'error'   			=> 'Akten blev ikke opdateret, prøv igen',
        'success' 			=> 'Asset opdateret med succes.',
        'nothing_updated'	=>  'Ingen felter blev valgt, så intet blev opdateret.',
    ),

    'restore' => array(
        'error'   		=> 'Akten blev ikke gendannet, prøv igen',
        'success' 		=> 'Asset restaureret med succes.'
    ),

    'audit' => array(
        'error'   		=> 'Assetrevision mislykkedes. Prøv igen.',
        'success' 		=> 'Asset audit succesfuldt logget.'
    ),


    'deletefile' => array(
        'error'   => 'Filen er ikke slettet. Prøv igen.',
        'success' => 'Filen er slettet korrekt.',
    ),

    'upload' => array(
        'error'   => 'Fil (er) ikke uploadet. Prøv igen.',
        'success' => 'Fil (er), der blev uploadet korrekt.',
        'nofiles' => 'Du valgte ikke nogen filer til upload, eller filen du forsøger at uploade er for stor',
        'invalidfiles' => 'En eller flere af dine filer er for store eller er en filtype, der ikke er tilladt. Tilladte filtyper er png, gif, jpg, doc, docx, pdf og txt.',
    ),

    'import' => array(
        'error'                 => 'Nogle elementer importerede ikke korrekt.',
        'errorDetail'           => 'Følgende elementer blev ikke importeret på grund af fejl.',
        'success'               => "Din fil er blevet importeret",
        'file_delete_success'   => "Din fil er blevet slettet korrekt",
        'file_delete_error'      => "Filen kunne ikke slettes",
    ),


    'delete' => array(
        'confirm'   	=> 'Er du sikker på, at du vil slette dette aktiv?',
        'error'   		=> 'Der opstod et problem ved at slette aktivet. Prøv igen.',
        'nothing_updated'   => 'Ingen aktiver blev valgt, så intet blev slettet.',
        'success' 		=> 'Aktivet blev slettet med succes.'
    ),

    'checkout' => array(
        'error'   		=> 'Akten blev ikke tjekket ud, prøv igen',
        'success' 		=> 'Asset tjekket ud med succes.',
        'user_does_not_exist' => 'Denne bruger er ugyldig. Prøv igen.',
        'not_available' => 'Det aktiv er ikke tilgængeligt for kassen!',
        'no_assets_selected' => 'Du skal vælge mindst ét aktiv fra listen'
    ),

    'checkin' => array(
        'error'   		=> 'Akten blev ikke tjekket ind, prøv igen',
        'success' 		=> 'Asset tjekket ind med succes.',
        'user_does_not_exist' => 'Denne bruger er ugyldig. Prøv igen.',
        'already_checked_in'  => 'Det aktiv er allerede kontrolleret.',

    ),

    'requests' => array(
        'error'   		=> 'Akten blev ikke anmodet om, prøv igen',
        'success' 		=> 'Akten blev bedt om succes.',
        'canceled'      => 'Afbestillingsanmodningen er aflyst'
    )

);
