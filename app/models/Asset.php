<?php

class Asset extends Depreciable
{
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    protected $table = 'assets';
    protected $errors;
    protected $rules = array(
        'name'   			=> 'alpha_space|min:2|max:255',
        'model_id'   		=> 'required',
        'warranty_months'   => 'integer|min:0|max:240',
        'note'   			=> 'alpha_space',
        'notes'   			=> 'alpha_space',
        'pysical' 			=> 'integer',
        'checkout_date' 	=> 'date|max:10|min:10',
        'checkin_date' 		=> 'date|max:10|min:10',
        'supplier_id' 		=> 'integer',
        'asset_tag'   		=> 'required|alpha_space|min:3|max:255|unique:assets,asset_tag,{id}',
        'status' 			=> 'integer'
        );

    public function depreciation()
    {
        return $this->model->belongsTo('Depreciation','depreciation_id');
    }

    public function get_depreciation()
    {
        return $this->model->depreciation;
    }

    /**
    * Get uploads for this asset
    */
    public function uploads()
    {
        return $this->hasMany('Actionlog','asset_id')
            ->where('asset_type', '=', 'hardware')
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }

    public function assigneduser()
    {
        return $this->belongsTo('User', 'assigned_to')->withTrashed();
    }

    /**
    * Get the asset's location based on the assigned user
    **/
    public function assetloc()
    {
        return $this->assigneduser->userloc();
    }


    /**
    * Get the asset's location based on the assigned user
    **/
    public function defaultLoc()
    {
        return $this->hasOne('Location', 'id', 'rtd_location_id');
    }


    /**
    * Get action logs for this asset
    */
    public function assetlog()
    {
        return $this->hasMany('Actionlog','asset_id')->where('asset_type','=','hardware')->orderBy('created_at', 'desc')->withTrashed();
    }

    /**
    * Get action logs for this asset
    */
    public function adminuser()
    {
        return $this->belongsTo('User','user_id');
    }

    /**
    * Get total assets
    */
     public static function assetcount()
    {
        return DB::table('assets')
                    ->where('physical', '=', '1')
                    ->whereNull('deleted_at','and')
                    ->count();
    }

    /**
    * Get total assets not checked out
    */
     public static function availassetcount()
    {
    	return Asset::RTD()->whereNull('deleted_at')->count();

    }


    /**
    * Get requestable assets
    */
     public static function getRequestable()
    {
    	return Asset::Requestable()->whereNull('deleted_at')->count();

    }

    /**
    * Get total assets
    */
     public function assetstatus()
    {
        return $this->belongsTo('Statuslabel','status_id');
    }
	
	/** 
	* Get name for EULA 
	**/
	public function showAssetName()
    {
	    if ($this->name=='') {
		    return $this->model->name;
	    } else {
		    return $this->name;
	    }
    }
    
     public function warrantee_expires()
    {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->warranty_months.' months'));
            return date_format($date, 'Y-m-d');
    }

    public function model()
    {
        return $this->belongsTo('Model','model_id')->withTrashed();
    }

    public static function getExpiringWarrantee($days = 30) {

	    return Asset::where('archived','=','0')
		->whereNotNUll('warranty_months')
		->whereNotNUll('purchase_date')
		->whereRaw(DB::raw('DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) <= DATE(NOW() + INTERVAL '.$days .' DAY) AND DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) > NOW()'))
		->orderBy('purchase_date', 'ASC')
		->get();


    }

	/**
	* Get the license seat information
	**/
    public function licenses()
    {
       	return $this->belongsToMany('License', 'license_seats', 'asset_id', 'license_id');

    }

    public function licenseseats()
    {
    		return $this->hasMany('LicenseSeat', 'asset_id');
    }


    public function supplier()
    {
        return $this->belongsTo('Supplier','supplier_id');
    }
    

    public function months_until_eol()
    {
            $today = date("Y-m-d");
            $d1 = new DateTime($today);
            $d2 = new DateTime($this->eol_date());

            if ($this->eol_date() > $today) {
                $interval = $d2->diff($d1);
            } else {
                $interval = NULL;
            }

            return $interval;
    }

    public function eol_date()
    {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->model->eol.' months'));
            return date_format($date, 'Y-m-d');
    }


    /**
    * Get total assets
    */
    public static function autoincrement_asset()
    {
        $settings = Setting::getSettings();

		if ($settings->auto_increment_assets == '1') {
			$asset_tag = DB::table('assets')
				->where('physical', '=', '1')
				->max('id');
			return $settings->auto_increment_prefix.($asset_tag + 1);
		} else {
			return false;
		}
    }

    public function requireAcceptance() {
	    return $this->model->category->require_acceptance;
    }

    public function getEula() {

	    $Parsedown = new Parsedown();

	    if ($this->model->category->eula_text) {
		    return $Parsedown->text(e($this->model->category->eula_text));
	    } elseif ($this->model->category->use_default_eula == '1') {
		    return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
	    } else {
		    return null;
	    }

    }



	/**
	-----------------------------------------------
	BEGIN QUERY SCOPES
	-----------------------------------------------
	**/


	/**
	* Query builder scope for hardware
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeHardware($query)
	{
		return $query->where('physical','=','1');
	}


	/**
	* Query builder scope for pending assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopePending($query)
	{
		return $query->whereHas('assetstatus',function($query)
		{
			$query->where('deployable','=',0)->where('pending','=',1)->where('archived','=',0);
		});
	}


	/**
	* Query builder scope for RTD assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeRTD($query)
	{
		return $query->whereNULL('assigned_to')->whereHas('assetstatus',function($query)
		{
			$query->where('deployable','=',1)->where('pending','=',0)->where('archived','=',0);
		});
	}




	/**
	* Query builder scope for Undeployable assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeUndeployable($query)
	{
		return $query->whereHas('assetstatus',function($query)
		{
			$query->where('deployable','=',0)->where('pending','=',0)->where('archived','=',0);
		});
	}


	/**
	* Query builder scope for Archived assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeArchived($query)
	{
		return $query->whereHas('assetstatus',function($query)
		{
			$query->where('deployable','=',0)->where('pending','=',0)->where('archived','=',1);
		});
	}



	/**
	* Query builder scope for Deployed assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeDeployed($query)
	{
		return $query->where('assigned_to','>','0');
	}

	/**
	* Query builder scope for Requestable assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeRequestableAssets($query)
	{
		return $query->where('requestable','=',1)->whereHas('assetstatus',function($query)
		{
			$query->where('deployable','=',1)->where('pending','=',0)->where('archived','=',0);
		});
	}


	/**
	* Query builder scope for Deleted assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeDeleted($query)
	{
		return $query->whereNotNull('deleted_at');
	}


}
