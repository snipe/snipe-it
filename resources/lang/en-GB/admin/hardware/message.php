<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Asset does not exist.',
<<<<<<< HEAD
    'does_not_exist_var'=> 'Asset with tag :asset_tag not found.',
    'no_tag' 	        => 'No asset tag provided.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',
    'warning_audit_date_mismatch' 	=> 'This asset\'s next audit date (:next_audit_date) is before the last audit date (:last_audit_date). Please update the next audit date.',
=======
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',
>>>>>>> 64747d0fb (updates based on review)

    'create' => [
        'error'   		=> 'Asset was not created, please try again. :(',
        'success' 		=> 'Asset created successfully. :)',
<<<<<<< HEAD
        'success_linked' => 'Asset with tag :tag was created successfully. <strong><a href=":link" style="color: white;">Click here to view</a></strong>.',
=======
>>>>>>> 64747d0fb (updates based on review)
    ],

    'update' => [
        'error'   			=> 'Asset was not updated, please try again',
        'success' 			=> 'Asset updated successfully.',
<<<<<<< HEAD
        'encrypted_warning' => 'Asset updated successfully, but encrypted custom fields were not due to permissions',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
        'no_assets_selected'  =>  'Nothing was updated because no assets were selected.',
        'assets_do_not_exist_or_are_invalid' => 'Selected assets cannot be updated.',
=======
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
>>>>>>> 64747d0fb (updates based on review)
    ],

    'restore' => [
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.',
<<<<<<< HEAD
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'Nothing was restored because no assets were selected.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit unsuccessful: :error ',
=======
    ],

    'audit' => [
        'error'   		=> 'Asset audit was unsuccessful. Please try again.',
>>>>>>> 64747d0fb (updates based on review)
        'success' 		=> 'Asset audit successfully logged.',
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
<<<<<<< HEAD
        'import_button'         => 'Process Import',
=======
>>>>>>> 64747d0fb (updates based on review)
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => 'Your file has been imported',
        'file_delete_success'   => 'Your file has been been successfully deleted',
        'file_delete_error'      => 'The file was unable to be deleted',
<<<<<<< HEAD
        'file_missing' => 'The file selected is missing',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
=======
>>>>>>> 64747d0fb (updates based on review)
    ],


    'delete' => [
        'confirm'   	=> 'Are you sure you wish to delete this asset?',
        'error'   		=> 'There was an issue deleting the asset. Please try again.',
        'nothing_updated'   => 'No assets were selected, so nothing was deleted.',
        'success' 		=> 'The asset was deleted successfully.',
    ],

    'checkout' => [
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'not_available' => 'That asset is not available for checkout!',
        'no_assets_selected' => 'You must select at least one asset from the list',
    ],

    'checkin' => [
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'already_checked_in'  => 'That asset is already checked in.',

    ],

    'requests' => [
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
        'canceled'      => 'Checkout request successfully canceled',
    ],

];
