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
<<<<<<< HEAD
        'error'         => 'Some items did not import correctly.',
        'errorDetail'   => 'The following Items were not imported because of errors.',
        'success'       => "Your file has been imported",
=======
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Your file has been imported",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "The file was unable to be deleted",
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    ),


    'delete' => array(
        'confirm'   	=> 'Er du sikker på at du vil slette eiendelen?',
        'error'   		=> 'Det oppstod et problem under sletting av eiendel. Vennligst prøv igjen.',
        'success' 		=> 'Vellykket sletting av eiendel.'
    ),

    'checkout' => array(
        'error'   		=> 'Eiendel ble ikke sjekket ut. Prøv igjen',
        'success' 		=> 'Vellykket utsjekk av eiendel.',
        'user_does_not_exist' => 'Denne brukeren er ugyldig. Vennligst prøv igjen.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Eiendel ble ikke sjekket inn. Prøv igjen',
        'success' 		=> 'Vellykket innsjekk av eiendel.',
        'user_does_not_exist' => 'Denne brukeren er ugyldig. Vennligst prøv igjen.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Eiendelen ble ikke forespurt, prøv igjen',
        'success' 		=> 'Eiendel ble forespurt.',
<<<<<<< HEAD
=======
        'canceled'      => 'Checkout request successfully canceled'
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    )

);
