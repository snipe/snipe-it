<?php

return [

    'undeployable' 		 => '<strong>Opozorilo: </strong> To sredstvo je bilo označeno kot trenutno nerazdeljeno. Če se je ta status spremenil, posodobite status sredstva.',
    'does_not_exist' 	 => 'Sredstvo ne obstaja.',
    'does_not_exist_var' => 'Sredstvo z oznako :oznaka_sredstva ni bilo najdeno.',
    'no_tag' 	         => 'Oznaka sredstva ni podana.',
    'does_not_exist_or_not_requestable' => 'To sredstvo ne obstaja ali ga ni mogoče zahtevati.',
    'assoc_users'	 	 => 'To sredstvo je trenutno izdano uporabniku in ga ni mogoče izbrisati. Najprej preverite sredstvo in poskusite znova izbrisati. ',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',
    'labels_generated'   => 'Labels were successfully generated.',
    'error_generating_labels' => 'Error while generating labels.',
    'no_assets_selected' => 'No assets selected.',

    'create' => [
        'error'   		=> 'Sredstvo ni bilo ustvarjeno, poskusite znova. :(',
        'success' 		=> 'Sredstvo je uspešno ustvarjeno. :)',
        'success_linked' => 'Asset with tag :tag was created successfully. <strong><a href=":link" style="color: white;">Click here to view</a></strong>.',
        'multi_success_linked' => 'Asset with tag :links was created successfully.|:count assets were created succesfully. :links.',
        'partial_failure' => 'An asset was unable to be created. Reason: :failures|:count assets were unable to be created. Reasons: :failures',
    ],

    'update' => [
        'error'   			=> 'Sredstvo ni bilo posodobljeno, poskusite znova',
        'success' 			=> 'Sredstvo je uspešno posodobljeno.',
        'encrypted_warning' => 'Asset updated successfully, but encrypted custom fields were not due to permissions',
        'nothing_updated'	=>  'Nobeno polje ni bilo izbrana, zato nebo nič posodobljeno.',
        'no_assets_selected'  =>  'Nobena sredstva niso bila izbrana, zato ni bilo nič izbrisanih.',
        'assets_do_not_exist_or_are_invalid' => 'Izbrana sredstva ni mogoče posodobiti.',
    ],

    'restore' => [
        'error'   		=> 'Sredstvo ni bilo obnovljeno, poskusite znova',
        'success' 		=> 'Sredstvo je bilo uspešno obnovljeno.',
        'bulk_success' 		=> 'Sredstvo je bilo uspešno obnovljeno.',
        'nothing_updated'   => 'Nobeno sredstvo ni bilo izbran, zato nebo nič obnovljeno.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
        'success' 		=> 'Revizija sredstva je uspešno zabeležena.',
    ],


    'deletefile' => [
        'error'   => 'Datoteka ni izbrisana. Prosim poskusite ponovno.',
        'success' => 'Datoteka je uspešno izbrisana.',
    ],

    'upload' => [
        'error'   => 'Datoteka(e) niso naložene. Prosim poskusite ponovno.',
        'success' => 'Datoteka(e) so bile uspešno naložene.',
        'nofiles' => 'Niste izbrali nobenih datotek za nalaganje, ali je datoteka ki jo poskušate naložiti prevelika',
        'invalidfiles' => 'Ena ali več vaših datotek je prevelika ali pa je tip datoteke, ki ni dovoljen. Dovoljeni tipi datotek so png, gif, jpg, doc, docx, pdf in txt.',
    ],

    'import' => [
        'import_button'         => 'Process Import',
        'error'                 => 'Nekateri elementi niso bili pravilno uvoženi.',
        'errorDetail'           => 'Naslednji elementi niso bili uvoženi zaradi napak.',
        'success'               => 'Vaša datoteka je bila uvožena',
        'file_delete_success'   => 'Vaša datoteka je bila uspešno izbrisana',
        'file_delete_error'      => 'Datoteke ni bilo mogoče izbrisati',
        'file_missing' => 'Izbrana datoteka manjka',
        'file_already_deleted' => 'The file selected was already deleted',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
    ],


    'delete' => [
        'confirm'   	=> 'Ali ste prepričani, da želite izbrisati to sredstvo?',
        'error'   		=> 'Prišlo je do težave z izbrisom sredstva. Prosim poskusite ponovno.',
        'assigned_to_error' => '{1}Asset Tag: :asset_tag is currently checked out. Check in this device before deletion.|[2,*]Asset Tags: :asset_tag are currently checked out. Check in these devices before deletion.',
        'nothing_updated'   => 'Nobena sredstva niso bila izbrana, zato ni bilo nič izbrisanih.',
        'success' 		=> 'Sredstvo je bilo uspešno izbrisano.',
    ],

    'checkout' => [
        'error'   		=> 'Sredstvo ni bila izdano, poskusite znova',
        'success' 		=> 'Sredstvo je bilo uspešno izdano.',
        'user_does_not_exist' => 'Ta uporabnik ni veljaven. Prosim poskusite ponovno.',
        'not_available' => 'To sredstvo ni na voljo za izdajo!',
        'no_assets_selected' => 'Na seznamu morate izbrati vsaj eno sredstev',
    ],

    'multi-checkout' => [
        'error'   => 'Asset was not checked out, please try again|Assets were not checked out, please try again',
        'success' => 'Asset checked out successfully.|Assets checked out successfully.',
    ],

    'checkin' => [
        'error'   		=> 'Sredstev ni bilo prevzeto, poskusite znova',
        'success' 		=> 'Sredstev je bilo uspešno prevzeta.',
        'user_does_not_exist' => 'Ta uporabnik je neveljaven. Prosim poskusite ponovno.',
        'already_checked_in'  => 'Ta sredstev je že izdana.',

    ],

    'requests' => [
        'error'   		=> 'Sredstev ni bila zahtevana, poskusite znova',
        'success' 		=> 'Sredstev je uspešno zahtevana.',
        'canceled'      => 'Zahteva za izdajo je bila uspešno preklicana',
    ],

];
