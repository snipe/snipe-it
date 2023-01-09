<?php

return array(

    'does_not_exist' => 'Lokasjon eksisterer ikke.',
    'assoc_users'	 => 'Denne lokasjonen er i bruk av minst en bruker, og kan ikke slettes. Fjern brukernes kobling mot lokasjonen og prøv igjen. ',
    'assoc_assets'	 => 'Lokasjonen er tilknyttet minst en eiendel og kan ikke slettes. Oppdater dine eiendeler slik at de ikke refererer til denne lokasjonen, og prøv igjen. ',
    'assoc_child_loc'	 => 'Lokasjonen er overordnet til minst en underlokasjon og kan ikke slettes. Oppdater din lokasjoner til å ikke referere til denne lokasjonen, og prøv igjen. ',
    'assigned_assets' => 'Assigned Assets',
    'current_location' => 'Current Location',


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
