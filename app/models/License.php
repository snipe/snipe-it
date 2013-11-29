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
			'name'   => 'required|alpha_space|min:3',
			'serial'   => 'required|alpha_dash|min:5',
			'seats'   => 'required|min:1|integer',
			'license_email'   => 'email',
			'note'   => 'alpha_space',
			'notes'   => 'alpha_space',
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
  		return $this->assignedusers->hasOne('Location');
  	}

  	/**
	* Get asset logs for this asset
	*/
	public function assetlog()
	{
		return $this->hasMany('Actionlog','asset_id')
			->where('asset_type', '=', 'software')
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

	public function availcount()
	{
		return DB::table('license_seats')
                    ->where('assigned_to', '=', '0')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at','and')
                    ->count();
	}


	public function assignedcount()
	{
		return DB::table('license_seats')
                    ->where('assigned_to', '>', '0')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at','and')
                    ->count();
	}

	public function totalcount()
	{
		$avail =  $this->availcount();
        $taken =  $this->assignedcount();
        $diff =   ($avail + $taken);
        return $diff;
	}

	public function licenseseats()
	{
		return $this->hasMany('LicenseSeat');
	}

	public function depreciation()
	{
		return $this->belongsTo('Depreciation','id');
	}


}
