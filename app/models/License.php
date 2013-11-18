<?php

class License extends Elegant {

	/**
	 * Deletes a category
	 *
	 * @return bool
	 */

	protected $table = 'assets';

	protected $rules = array(
			'name'   => 'required|min:3',
			'serial'   => 'required|min:5',
			'license_email'   => 'email',
		);

	public function assigneduser()
  	{
    	return $this->belongsTo('User', 'assigned_to');
  	}



}
