<?php

return array(

    'undeployable' 		=> '<strong>Achtung:</strong>Dieses Asset wurde kürzlich als nicht verteilbar markiert.
                        Falls sich dieser Status verändert hat, aktualisieren Sie bitte den Asset Status.',
    'does_not_exist' 	=> 'Asset existiert nicht.',
    'assoc_users'	 	=> 'Dieses Asset ist im Moment an einen Benutzer herausgegeben und kann nicht entfernt werden. Bitte buchen sie das Asset wieder ein und versuchen Sie dann erneut es zu entfernen. ',

    'create' => array(
        'error'   		=> 'Asset wurde nicht erstellt. Bitte versuchen Sie es erneut. :(',
        'success' 		=> 'Asset wurde erfolgreich erstellt. :)'
    ),

    'update' => array(
        'error'   			=> 'Asset wurde nicht aktualisiert. Bitte versuchen Sie es erneut',
        'success' 			=> 'Asset wurde erfolgreich aktualisiert.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset wurde nicht wiederhergestellt, bitte versuchen Sie es noch einmal',
        'success' 		=> 'Asset erfolgreich wiederhergestellt.'
    ),
    
    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),


    'delete' => array(
        'confirm'   	=> 'Sind Sie sicher, dass Sie dieses Asset entfernen möchten?',
        'error'   		=> 'Beim Entfernen dieses Assets ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.',
        'success' 		=> 'Dieses Asset wurde erfolgreich entfernt.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset konnte nicht herausgegeben werden. Bitte versuchen Sie es erneut',
        'success' 		=> 'Asset wurde erfolgreich herausgegeben.',
        'user_does_not_exist' => 'Dieser Benutzer existiert nicht. Bitte versuchen Sie es erneut.'
    ),

    'checkin' => array(
        'error'   		=> 'Asset konnte nicht eingebucht werden. Bitte versuchen Sie es erneut',
        'success' 		=> 'Asset wurde erfolgreich eingebucht.',
        'user_does_not_exist' => 'Dieser Benutzer existiert nicht. Bitte versuchen Sie es erneut.'
    )

);
