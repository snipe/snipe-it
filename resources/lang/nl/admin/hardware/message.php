<?php

return array(

    'undeployable' 		=> '<strong>Waarschuwing: </strong>Het gereedschap is gemarkeerd als niet uitrolbaar. Als de status is veranderd, verander dan de status van het gereedschap.',
    'does_not_exist' 	=> 'Dit gereedschap bestaat niet.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Dit gereedschap is op dit moment toegewezen aan een gebruiker en kan niet verwijderd worden. Verwijder het gereedschap eerst, en probeer op nieuw.',

    'create' => array(
        'error'   		=> 'Aanmaken van gereedschap is mislukt. Probeer opnieuw :(',
        'success' 		=> 'Gereedschap is succesvol aangemaakt :)'
    ),

    'update' => array(
        'error'   			=> 'Gereedschap is niet aangepast. Probeer opnieuw',
        'success' 			=> 'Gereedschap is succesvol aangepast.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Gereedschap is niet hersteld. Probeer opnieuw',
        'success' 		=> 'Gereedschap is succesvol hersteld.'
    ),

    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),


    'delete' => array(
        'confirm'   	=> 'Are you sure you wish to delete this asset?',
        'error'   		=> 'There was an issue deleting the asset. Please try again.',
        'success' 		=> 'The asset was deleted successfully.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.'
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'That user is invalid.. Please try again.'
    ),

    'requests' => array(
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
    )

);
