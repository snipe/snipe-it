<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Asset existiert nicht.',
    'assoc_users'	 	=> 'Dieses Asset ist im Moment an einen Benutzer herausgegeben und kann nicht entfernt werden. Bitte buchen sie das Asset wieder ein und versuchen Sie dann erneut es zu entfernen. ',

    'create' => array(
        'error'   		=> 'Asset wurde nicht erstellt. Bitte versuchen Sie es erneut. :(',
        'success' 		=> 'Asset wurde erfolgreich erstellt. :)'
    ),

    'update' => array(
        'error'   		=> 'Asset wurde nicht aktualisiert. Bitte versuchen Sie es erneut',
        'success' 		=> 'Asset wurde erfolgreich aktualisiert.'
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
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
