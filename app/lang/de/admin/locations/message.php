<?php

return array(

    'does_not_exist' => 'Standort nicht verfügbar.',
    'assoc_users'	 => 'Dieser Standort ist mit mindestens einem Benutzer verknüpft und kann nicht gelöscht werden. Bitte Benutzer updaten, so dass dieser Standort nicht mehr verknüpft ist und erneut versuchen. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


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
