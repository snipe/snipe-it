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

	/**
	* Get the asset's location based on the assigned user
	**/
  	public function assetloc()
  	{
  		return $this->assigneduser->hasOne('Location');
  	}

  	/**
	* Get action logs for this asset
	*/
	public function assetlog()
	{
		return $this->hasMany('Actionlog','asset_id')->orderBy('added_on', 'desc');
	}

	/**
	* Get action logs for this asset
	*/
	public function adminuser()
	{
		return $this->belongsTo('User','id');
	}


}
