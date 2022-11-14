<?php

return [

    'undeployable' 		=> '<strong>Varúð: </strong> Þessi eign hefur verið merkt sem ónothæf að svo stöddu.
                        Ef ástand hennar hefur breyst skaltu uppfæra stöðu eignarinnar.',
    'does_not_exist' 	=> 'Þessi eign finnst ekki.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Þessari eign hefur þegar verið ráðstafað til notanda og er því ekki hægt að afskrá. Vinsamlegast skilaðu eigninni fyrst og reyndu síðan að afskrá hana. ',

    'create' => [
        'error'   		=> 'Asset was not created, please try again. :(',
        'success' 		=> 'Það tókst að skrá þessa eign :)',
    ],

    'update' => [
        'error'   			=> 'Asset was not updated, please try again',
        'success' 			=> 'Asset updated successfully.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
        'no_assets_selected'  =>  'No assets were selected, so nothing was updated.',
    ],

    'restore' => [
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.',
    ],

    'audit' => [
        'error'   		=> 'Eignaúttekt var ekki skráð. Vinsamlegast reyndu aftur.',
        'success' 		=> 'Eignaúttekt var skráð.',
    ],


    'deletefile' => [
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ],

    'upload' => [
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ],

    'import' => [
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => 'Your file has been imported',
        'file_delete_success'   => 'Your file has been been successfully deleted',
        'file_delete_error'      => 'The file was unable to be deleted',
    ],


    'delete' => [
        'confirm'   	=> 'Ertu viss um að þú viljir afskrá þessa eign?',
        'error'   		=> 'There was an issue deleting the asset. Please try again.',
        'nothing_updated'   => 'No assets were selected, so nothing was deleted.',
        'success' 		=> 'The asset was deleted successfully.',
    ],

    'checkout' => [
        'error'   		=> 'Eigninni var ekki ráðstafað, vinsamlegast reyndu aftur',
        'success' 		=> 'Eigninni var ráðstafað.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'not_available' => 'Þessi eign er ekki laus til ráðstöfunar!',
        'no_assets_selected' => 'Þú verður að velja að lágmarki eina eign úr listanum',
    ],

    'checkin' => [
        'error'   		=> 'Eigninni var ekki skilað, vinsamlegast reyndu aftur',
        'success' 		=> 'Eigninni var skilað.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'already_checked_in'  => 'Þessari eign hefur þegar verið skilað.',

    ],

    'requests' => [
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
        'canceled'      => 'Beiðni um ráðstöfun var afturkölluð',
    ],

];
