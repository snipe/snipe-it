<?php

class License extends Elegant {

 	protected $guarded = 'id';
	protected $table = 'licenses';
	protected $softDelete = true;
	protected $rules = array(
			'name'   => 'required|alpha_space|min:3',
			'serial'   => 'required|alpha_space|min:5',
			'seats'   => 'required|min:1|integer',
			'license_email'   => 'email',
			'note'   => 'alpha_space',
			'notes'   => 'alpha_space',
		);

	/**
	 * Get the assigned user
	 *
	 */
	public function assignedusers()
  	{
    	return $this->belongsToMany('User','license_seats','assigned_to','license_id');

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
		return $this->belongsTo('User','user_id');
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

	/**
	 * Get the number of available seats
	 *
	 */
	public function availcount()
	{
		return DB::table('license_seats')
                    ->where('assigned_to', '=', '0')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at','and')
                    ->count();
	}

	/**
	 * Get the number of assigned seats
	 *
	 */
	public function assignedcount()
	{
		return DB::table('license_seats')
                    ->where('assigned_to', '>', '0')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at','and')
                    ->count();
	}

	/**
	 * Get the total number of seats
	 *
	 */
	public function totalcount()
	{
		$avail =  $this->availcount();
        $taken =  $this->assignedcount();
        $diff =   ($avail + $taken);
        return $diff;
	}

	/**
	 * Get license seat data
	 *
	 */
	public function licenseseats()
	{
		return $this->hasMany('LicenseSeat');
	}

	/**
	 * Get depreciation class
	 *
	 */
	public function depreciation()
	{
		return $this->belongsTo('Depreciation','id');
	}


}
