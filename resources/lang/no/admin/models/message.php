<?php

return array(

    'does_not_exist' => 'Modell eksisterer ikke.',
    'no_association' => 'NO MODEL ASSOCIATED.',
    'no_association_fix' => 'This will break things in weird and horrible ways. Edit this asset now to assign it a model.',
    'assoc_users'	 => 'Denne modellen er tilknyttet en eller flere eiendeler og kan ikke slettes. Slett eiendelene, og prøv å slette modellen igjen. ',


    'create' => array(
        'error'   => 'Modellen ble ikke opprettet. Prøv igjen.',
        'success' => 'Opprettelse av modell var vellykket.',
        'duplicate_set' => 'En eiendel med dette navnet, produsenten og modelnummeret eksisterer allerede.',
    ),

    'update' => array(
        'error'   => 'Modell ble ikke oppdatert. Prøv igjen',
        'success' => 'Oppdatering av modell vellykket.',
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
        'success' 		=> 'Model successfully updated. |:model_count models successfully updated.',
        'warn'          => 'You are about to update the properies of the following model: |You are about to edit the properties of the following :model_count models:',

    ),

    'bulkdelete' => array(
        'error'   		    => 'Ingen modeller ble valgt, så ingenting ble slettet.',
        'success' 		    => 'Model deleted!|:success_count models deleted!',
        'success_partial' 	=> ':Success_count-modell(ene) ble slettet, men fail_count kunne ikke slettes fordi de fortsatt har eiendeler knyttet til dem.'
    ),

);
