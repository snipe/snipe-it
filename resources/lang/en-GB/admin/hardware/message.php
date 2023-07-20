<?php

return [

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Asset does not exist.',
    'does_not_exist_or_not_requestable' => 'That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',

    'create' => [
        'error'   		=> 'Asset was not created, please try again. :(',
        'success' 		=> 'Asset created successfully. :)',
    ],

    'update' => [
        'error'   			=> 'Asset was not updated, please try again',
        'success' 			=> 'Asset updated successfully.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
        'no_assets_selected'  =>  'Nothing was updated because no assets were selected.',
    ],

    'restore' => [
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.',
        'bulk_success' 		=> 'Asset restored successfully.',
        'nothing_updated'   => 'Nothing was restored because no assets were selected.', 
    ],

    'audit' => [
        'error'   		=> 'Asset audit was unsuccessful. Please try again.',
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
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => 'Your file has been imported',
        'file_delete_success'   => 'Your file has been been successfully deleted',
        'file_delete_error'      => 'The file was unable to be deleted',
        'header_row_has_malformed_characters' => 'One or more attributes in the header row contain malformed UTF-8 characters',
        'content_row_has_malformed_characters' => 'One or more attributes in the first row of content contain malformed UTF-8 characters',
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
