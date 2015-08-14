<?php

return array(

    'does_not_exist' => 'Lokasjon eksisterer ikke.',
    'assoc_users'	 => 'Denne lokasjonen er i bruk av minst en bruker, og kan ikke slettes. Fjern brukernes kobling mot lokasjonen og prøv igjen. ',
    'assoc_assets'	 => 'This location is currently associated with at least one asset and cannot be deleted. Please update your assets to no longer reference this location and try again. ',
    'assoc_child_loc'	 => 'This location is currently the parent of at least one child location and cannot be deleted. Please update your locations to no longer reference this location and try again. ',


    'create' => array(
        'error'   => 'Lokasjon ble ikke opprettet, prøv igjen.',
        'success' => 'Vellykket opprettelse av lokasjon.'
    ),

    'update' => array(
        'error'   => 'Lokasjon ble ikke oppdatert, prøv igjen',
        'success' => 'Vellykket oppdatering av plassering.'
    ),

    'delete' => array(
        'confirm'   	=> 'Er du sikker på at du vil slette denne plasseringen?',
        'error'   => 'Det oppstod et problem under sletting av plassering. Vennligst prøv igjen.',
        'success' => 'Vellykket sletting av plassering.'
    )

);
