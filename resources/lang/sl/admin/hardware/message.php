<?php

return array(

    'undeployable' 		=> '<strong>Opozorilo: </strong> To sredstvo je bilo označeno kot trenutno nerazdeljeno. Če se je ta status spremenil, posodobite status sredstva.',
    'does_not_exist' 	=> 'Sredstvo ne obstaja.',
    'does_not_exist_or_not_requestable' => 'Dober poskus. To sredstvo ne obstaja ali ga ni mogoče zahtevati.',
    'assoc_users'	 	=> 'To sredstvo je trenutno izdano uporabniku in ga ni mogoče izbrisati. Najprej preverite sredstvo in poskusite znova izbrisati. ',

    'create' => array(
        'error'   		=> 'Sredstvo ni bilo ustvarjeno, poskusite znova. :(',
        'success' 		=> 'Sredstvo je uspešno ustvarjeno. :)'
    ),

    'update' => array(
        'error'   			=> 'Sredstvo ni bilo posodobljeno, poskusite znova',
        'success' 			=> 'Sredstvo je uspešno posodobljeno.',
        'nothing_updated'	=>  'Nobeno polje ni bilo izbrana, zato nebo nič posodobljeno.',
    ),

    'restore' => array(
        'error'   		=> 'Sredstvo ni bilo obnovljeno, poskusite znova',
        'success' 		=> 'Sredstvo je bilo uspešno obnovljeno.'
    ),

    'audit' => array(
        'error'   		=> 'Revizija sredstva je bila neuspešna. Prosim poskusite ponovno.',
        'success' 		=> 'Revizija sredstva je uspešno zabeležena.'
    ),


    'deletefile' => array(
        'error'   => 'Datoteka ni izbrisana. Prosim poskusite ponovno.',
        'success' => 'Datoteka je uspešno izbrisana.',
    ),

    'upload' => array(
        'error'   => 'Datoteka(e) niso naložene. Prosim poskusite ponovno.',
        'success' => 'Datoteka(e) so bile uspešno naložene.',
        'nofiles' => 'Niste izbrali nobenih datotek za nalaganje, ali je datoteka ki jo poskušate naložiti prevelika',
        'invalidfiles' => 'Ena ali več vaših datotek je prevelika ali pa je tip datoteke, ki ni dovoljen. Dovoljeni tipi datotek so png, gif, jpg, doc, docx, pdf in txt.',
    ),

    'import' => array(
        'error'                 => 'Nekateri elementi niso bili pravilno uvoženi.',
        'errorDetail'           => 'Naslednji elementi niso bili uvoženi zaradi napak.',
        'success'               => "Vaša datoteka je bila uvožena",
        'file_delete_success'   => "Vaša datoteka je bila uspešno izbrisana",
        'file_delete_error'      => "Datoteke ni bilo mogoče izbrisati",
    ),


    'delete' => array(
        'confirm'   	=> 'Ali ste prepričani, da želite izbrisati to sredstvo?',
        'error'   		=> 'Prišlo je do težave z izbrisom sredstva. Prosim poskusite ponovno.',
        'nothing_updated'   => 'Nobena sredstva niso bila izbrana, zato ni bilo nič izbrisanih.',
        'success' 		=> 'Sredstvo je bilo uspešno izbrisano.'
    ),

    'checkout' => array(
        'error'   		=> 'Sredstvo ni bila izdano, poskusite znova',
        'success' 		=> 'Sredstvo je bilo uspešno izdano.',
        'user_does_not_exist' => 'Ta uporabnik ni veljaven. Prosim poskusite ponovno.',
        'not_available' => 'To sredstvo ni na voljo za izdajo!',
        'no_assets_selected' => 'Na seznamu morate izbrati vsaj eno sredstev'
    ),

    'checkin' => array(
        'error'   		=> 'Sredstev ni bilo prevzeto, poskusite znova',
        'success' 		=> 'Sredstev je bilo uspešno prevzeta.',
        'user_does_not_exist' => 'Ta uporabnik je neveljaven. Prosim poskusite ponovno.',
        'already_checked_in'  => 'Ta sredstev je že izdana.',

    ),

    'requests' => array(
        'error'   		=> 'Sredstev ni bila zahtevana, poskusite znova',
        'success' 		=> 'Sredstev je uspešno zahtevana.',
        'canceled'      => 'Zahteva za izdajo je bila uspešno preklicana'
    )

);
