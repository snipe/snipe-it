<?php

class License extends Elegant {

	/**
	 * Deletes a category
	 *
	 * @return bool
	 */

 	protected $guarded = 'id';
	protected $table = 'licenses';
	protected $softDelete = true;
	protected $rules = array(
			'name'   => 'required|min:3',
			'serial'   => 'required|min:5',
			'seats'   => 'required|min:1|integer',
			'license_email'   => 'email',
		);

	public function assignedusers()
  	{
    	return $this->belongsToMany('User','license_seats','assigned_to','license_id');

  	}

	/**
	* Get the asset's location based on the assigned user
	**/
  	public function assetloc()
  	{
  		return $this->assigneduser->hasOne('Location');
  	}

  	/**
	* Get asset logs for this asset
	*/
	public function assetlog()
	{
		return $this->hasMany('Actionlog','asset_id')
			->where('assigned_to', '=', '0')
			->orderBy('added_on', 'desc');
	}

	/**
	* Get admin user for this asset
	*/
	public function adminuser()
	{
		return $this->belongsTo('User','id');
	}

	/**
	* Get total licenses
	*/
	 public static function assetcount()
	{
		return DB::table('license_seats')
                    ->whereNull('deleted_at','and')
                    ->count();
	}

	/**
	* Get total licenses not checked out
	*/
	 public static function availassetcount()
	{
		return DB::table('license_seats')
                    ->where('assigned_to', '=', '0')
                    ->whereNull('deleted_at','and')
                    ->count();

	}



}
