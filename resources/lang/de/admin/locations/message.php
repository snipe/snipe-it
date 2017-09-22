<?php

return array(

    'does_not_exist' => 'Der Standort ist nicht vorhanden.',
    'assoc_users'	 => 'Dieser Standort ist mit mindestens einem Benutzer verknüpft und kann nicht gelöscht werden. Bitte Benutzer updaten, so dass dieser Standort nicht mehr verknüpft ist und erneut versuchen. ',
    'assoc_assets'	 => 'Dieser Ort ist mit mindestens einem Asset verknüpft und kann nicht gelöscht werden. Bitte Asset updaten, so dass dieser Standort nicht mehr verknüpft ist und erneut versuchen. ',
    'assoc_child_loc'	 => 'Dieser Ort ist mit mindestens einem anderen Ort übergeordnet und kann nicht gelöscht werden. Bitte Orte aktualisieren, so dass dieser Standort nicht mehr verknüpft ist und erneut versuchen. ',


    'create' => array(
        'error'   => 'Standort wurde nicht erstellt, bitte versuchen Sie es erneut.',
        'success' => 'Standort erfolgreich erstellt.'
    ),

    'update' => array(
        'error'   => 'Standort wurde nicht aktualisiert, bitte erneut versuchen',
        'success' => 'Standort erfolgreich aktualisiert.'
    ),

    'delete' => array(
        'confirm'   	=> 'Möchten Sie diesen Standort wirklich entfernen?',
        'error'   => 'Es gab einen Fehler beim Löschen des Standorts. Bitte erneut versuchen.',
        'success' => 'Der Standort wurde erfolgreich gelöscht.'
    )

);
