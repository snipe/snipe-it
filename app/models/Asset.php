<?php

class Asset extends Elegant {

	protected $table = 'assets';
	protected $rules = array(
		'name'   => 'required|min:3',
		'asset_tag'   => 'required|min:3|unique:assets',
		'model_id'   => 'required',
		'serial'   => 'required|min:3',
    );


	/**
	* Handle depreciation
	*/
	public function depreciation()
	{
		$depreciation_id = Model::find($this->model_id)->depreciation_id;
		if (isset($depreciation_id)) {
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

  	public function assetloc($locationId)
  	{
  		return Location::find($locationId);

  	}

  	/**
	* Get action logs for this asset
	*/
	public function assetlog()
	{
		return $this->hasMany('Actionlog','asset_id');
	}

}
