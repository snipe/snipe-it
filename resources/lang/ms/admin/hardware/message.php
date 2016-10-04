<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Harta tidak wujud.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'Harta ini sekarang telah diagihkan kepada pengguna dan tidak boleh dihapuskan. Sila semak status harta ini dahulu, dan kemudian cuba semula. ',

    'create' => array(
        'error'   		=> 'Harta gagal dicipta, sila cuba semula. :(',
        'success' 		=> 'Harta berjaya dicipta. :)'
    ),

    'update' => array(
        'error'   			=> 'Harta gagal dikemaskini, sila cuba semula',
        'success' 			=> 'Harta berjaya dikemaskini.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
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

    'import' => array(
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Your file has been imported",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "The file was unable to be deleted",
    ),


    'delete' => array(
        'confirm'   	=> 'Anda pasti anda ingin hapuskan harta ini?',
        'error'   		=> 'Ada isu semasa menghapuskan harta. Sila cuba lagi.',
        'success' 		=> 'Harta berjaya dihapuskan.'
    ),

    'checkout' => array(
        'error'   		=> 'Harta gagal diagihkan, sila cuba semula',
        'success' 		=> 'Harta berjaya diagihkan.',
        'user_does_not_exist' => 'Pengguna tak sah. Sila cuba lagi.',
        'not_available' => 'That asset is not available for checkout!'
    ),

    'checkin' => array(
        'error'   		=> 'Harta tidak diterima, sila cuba lagi',
        'success' 		=> 'Harta berjaya diterima.',
        'user_does_not_exist' => 'Pengguna tidah sah. Sila cuba lagi.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
        'canceled'      => 'Checkout request successfully canceled'
    )

);
