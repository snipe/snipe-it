<?php

return array(

	'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
						If this status has changed, please update the asset status.',
	'does_not_exist' 	=> 'Asset does not exist.',
	'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',

	'create' => array(
		'error'   		=> 'Asset was not created, please try again. :(',
		'success' 		=> 'Asset created successfully. :)'
	),

	'update' => array(
		'error'   		=> 'Asset was not updated, please try again',
		'success' 		=> 'Asset updated successfully.'
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
		'user_does_not_exist' => 'That user is invalid. Please try again.'
	)

);
