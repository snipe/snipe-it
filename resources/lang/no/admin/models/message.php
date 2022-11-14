<?php

return array(

    'does_not_exist' => 'Modell eksisterer ikke.',
    'assoc_users'	 => 'Denne modellen er tilknyttet en eller flere eiendeler og kan ikke slettes. Slett eiendelene, og prøv å slette modellen igjen. ',


    'create' => array(
        'error'   => 'Modellen ble ikke opprettet. Prøv igjen.',
        'success' => 'Opprettelse av modell var vellykket.',
        'duplicate_set' => 'En eiendel med dette navnet, produsenten og modelnummeret eksisterer allerede.',
    ),

    'update' => array(
        'error'   => 'Modell ble ikke oppdatert. Prøv igjen',
        'success' => 'Oppdatering av modell vellykket.'
    ),

    'delete' => array(
        'confirm'   => 'Er du sikker på at du vil slette denne modellen?',
        'error'   => 'Det oppstod et problem under sletting av modellen. Prøv igjen.',
        'success' => 'Sletting av modell vellykket.'
    ),

    'restore' => array(
        'error'   		=> 'Modell ble ikke gjenopprettet. Prøv igjen',
        'success' 		=> 'Vellykket gjenoppretting av modell.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Ingen felt ble endret, så ingenting ble oppdatert.',
        'success' 		=> 'Modeller oppdatert.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'Ingen modeller ble valgt, så ingenting ble slettet.',
        'success' 		    => ': success_count modell(er) slettet!',
        'success_partial' 	=> ':Success_count-modell(ene) ble slettet, men fail_count kunne ikke slettes fordi de fortsatt har eiendeler knyttet til dem.'
    ),

);
