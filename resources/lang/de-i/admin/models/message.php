<?php

return array(

    'does_not_exist' => 'Modell existiert nicht.',
    'assoc_users'	 => 'Dieses Modell ist zur Zeit mit einem oder mehreren Assets verknüpft und kann nicht gelöscht werden. Bitte lösche die Assets und versuche dann erneut, das Modell zu löschen. ',


    'create' => array(
        'error'   => 'Modell wurde nicht erstellt. Bitte versuche es noch einmal.',
        'success' => 'Modell wurde erfolgreich erstellt.',
        'duplicate_set' => 'Ein Asset-Modell mit diesem Namen, Hersteller und Modell Nummer existiert bereits.',
    ),

    'update' => array(
        'error'   => 'Modell wurde nicht aktualisiert. Bitte versuch es noch einmal',
        'success' => 'Modell wurde erfolgreich aktualisiert.'
    ),

    'delete' => array(
        'confirm'   => 'Bist Du sicher, dass Du dieses Asset-Modell entfernen möchtest?',
        'error'   => 'Beim Löschen des Modell ist ein Fehler aufgetreten. Bitte versuche es noch einmal.',
        'success' => 'Das Modell wurde erfolgreich gelöscht.'
    ),

    'restore' => array(
        'error'   		=> 'Modell wurde nicht wiederhergestellt, bitte versuche es noch einmal',
        'success' 		=> 'Modell wurde erfolgreich wiederhergestellt.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Es wurden keine Felder geändert, somit wurde auch nichts aktualisiert.',
        'success' 		=> 'Modelle aktualisiert.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Es wurden keine Modelle ausgewählt. Somit wurde auch nichts gelöscht.',
        'success' 		    => ':success_count Modell(e) gelöscht!',
        'success_partial' 	=> ':success_count Modell(e) wurden gelöscht. Jedoch konnten :fail_count nicht gelöscht werden, da ihnen noch Assets zugeordnet sind.'
    ),

);
