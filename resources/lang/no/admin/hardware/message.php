<?php

return array(

    'undeployable' 		=> '<strong>Advarsel:</strong> Denne eiendelen er merket som ikke utleverbar.
                        Oppdater eiendelsstatus hvis situasjonen har endret seg.',
    'does_not_exist' 	=> 'Eiendel eksisterer ikke.',
    'does_not_exist_or_not_requestable' => 'Eiendelen eksisterer ikke eller kan ikke forespørres.',
    'assoc_users'	 	=> 'Denne eiendelen er merket som utsjekket til en bruker og kan ikke slettes. Vennligst sjekk inn eiendelen først, og forsøk sletting på nytt. ',

    'create' => array(
        'error'   		=> 'Eiendelen ble ikke opprettet, prøv igjen :(',
        'success' 		=> 'Eiendelen ble opprettet :)'
    ),

    'update' => array(
        'error'   			=> 'Eiendelen ble ikke oppdatert, prøv igjen',
        'success' 			=> 'Oppdatering av eiendel vellykket.',
        'nothing_updated'	=>  'Ingen felter er valgt, så ingenting ble endret.',
    ),

    'restore' => array(
        'error'   		=> 'Eiendel ble ikke gjenopprettet. Prøv igjen',
        'success' 		=> 'Vellykket gjenoppretting av eiendel.'
    ),

    'audit' => array(
        'error'   		=> 'Asset audit var mislykket. Prøv på nytt.',
        'success' 		=> 'Asset audit ble logget.'
    ),


    'deletefile' => array(
        'error'   => 'Fil ble ikke slettet. Prøv igjen.',
        'success' => 'Vellykket sletting av fil.',
    ),

    'upload' => array(
        'error'   => 'Fil(er) ble ikke lastet opp. Prøv igjen.',
        'success' => 'Vellykket opplasting av fil(er).',
        'nofiles' => 'Ingen fil er valgt til opplasting, eller filen er for stor',
        'invalidfiles' => 'En eller flere av filene dine er for store eller av en ikke tillatt filtype. Tillatte filtyper er png, gif, jpg, doc, docx, pdf og txt.',
    ),

    'import' => array(
        'error'                 => 'Noen elementer ble ikke importert riktig.',
        'errorDetail'           => 'Følgende elementer ble ikke importert på grunn av feil.',
        'success'               => "Filen har blitt importert",
        'file_delete_success'   => "Filen har blitt slettet",
        'file_delete_error'      => "Filen kunne ikke bli slettet",
    ),


    'delete' => array(
        'confirm'   	=> 'Er du sikker på at du vil slette eiendelen?',
        'error'   		=> 'Det oppstod et problem under sletting av eiendel. Vennligst prøv igjen.',
        'nothing_updated'   => 'Ingen assets ble valgt, så ingenting ble slettet.',
        'success' 		=> 'Vellykket sletting av eiendel.'
    ),

    'checkout' => array(
        'error'   		=> 'Eiendel ble ikke sjekket ut. Prøv igjen',
        'success' 		=> 'Vellykket utsjekk av eiendel.',
        'user_does_not_exist' => 'Denne brukeren er ugyldig. Vennligst prøv igjen.',
        'not_available' => 'Den eiendelen er ikke tilgjengelig til å sjekkes ut!',
        'no_assets_selected' => 'Du må velge minst én enhet fra listen'
    ),

    'checkin' => array(
        'error'   		=> 'Eiendel ble ikke sjekket inn. Prøv igjen',
        'success' 		=> 'Vellykket innsjekk av eiendel.',
        'user_does_not_exist' => 'Denne brukeren er ugyldig. Vennligst prøv igjen.',
        'already_checked_in'  => 'Den eiendelen er allerede sjekket inn.',

    ),

    'requests' => array(
        'error'   		=> 'Eiendelen ble ikke forespurt, prøv igjen',
        'success' 		=> 'Eiendel ble forespurt.',
        'canceled'      => 'Utsjekkingsforespørselen ble kansellert'
    )

);
