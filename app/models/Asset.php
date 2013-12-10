<?php

class Asset extends Elegant {

	protected $table = 'assets';
	protected $softDelete = true;
	protected $rules = array(
		'name'   => 'alpha_space',
		'asset_tag'   => 'required|alpha_space|min:3|unique:assets',
		'model_id'   => 'required',
		'serial'   => 'alpha_dash|min:3|unique:assets',
		'warranty_months'   => 'integer',
		'note'   => 'alpha_space',
		'notes'   => 'alpha_space',
    );


	/**
	* Handle depreciation
	*/
	public function depreciate()
	{
		$depreciation_id = Model::find($this->model_id)->depreciation_id;
		if ($depreciation_id) {
			$depreciation_term = Depreciation::find($depreciation_id)->months;
			if($depreciation_term>0) {

				$purchase_date = strtotime($this->purchase_date);

				$todaymonthnumber=date("Y")*12+(date("m")-1); //calculate the month number for today as YEAR*12 + (months-1) - number of months since January year 0
				$purchasemonthnumber=date("Y",$purchase_date)*12+(date("m",$purchase_date)-1); //purchase date calculated similarly
				$diff_months=$todaymonthnumber-$purchasemonthnumber;

				// fraction of value left
				$current_value = round((( $depreciation_term - $diff_months) / ($depreciation_term)) * $this->purchase_cost,2);

				if ($current_value < 0) {
					$current_value = 0;
				}
	        	return $current_value;
	        } else {
	        	return $this->purchase_cost;
	        }
        } else {
        	return $this->purchase_cost;
        }

	}


	public function assigneduser()
  	{
    	return $this->belongsTo('User', 'assigned_to');
  	}

	/**
	* Get the asset's location based on the assigned user
	**/
  	public function assetloc()
  	{
  		return $this->assigneduser->userloc();
  	}

  	/**
	* Get action logs for this asset
	*/
	public function assetlog()
	{
		return $this->hasMany('Actionlog','asset_id')->where('asset_type','=','hardware')->orderBy('added_on', 'desc')->withTrashed();
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
		return Asset::orderBy('asset_tag', 'ASC')->where('status_id', '=', 0)->where('assigned_to','=','0')->where('physical', '=', 1)->count();

	}

	/**
	* Get total assets
	*/
	 public function assetstatus()
	{
		return $this->belongsTo('Statuslabel','status_id');
	}


	 public function warrantee_expires()
	{

			$date = date_create($this->purchase_date);
			date_add($date, date_interval_create_from_date_string($this->warranty_months.' months'));
			return date_format($date, 'Y-m-d');

	}

	 public function months_until_depreciated()
	{

			$today = date("Y-m-d");

			// @link http://www.php.net/manual/en/class.datetime.php
			$d1 = new DateTime($today);
			$d2 = new DateTime($this->depreciated_date());

			// @link http://www.php.net/manual/en/class.dateinterval.php
			$interval = $d1->diff($d2);
			return $interval;

	}


	 public function depreciated_date()
	{
			$date = date_create($this->purchase_date);
			date_add($date, date_interval_create_from_date_string($this->depreciation->months.' months'));
			return date_format($date, 'Y-m-d');
	}


	public function depreciation()
	{
		return $this->model->belongsTo('Depreciation','depreciation_id');
	}

	public function model()
	{
		return $this->belongsTo('Model','model_id');
	}

	public function months_until_eol()
	{
			$today = date("Y-m-d");
			$d1 = new DateTime($today);
			$d2 = new DateTime($this->eol_date());

			if ($this->eol_date() > $today)
			{
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


}
