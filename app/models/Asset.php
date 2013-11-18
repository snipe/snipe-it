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

		$purchase_date = strtotime($this->purchase_date);
		$today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
		$diff_days = ($today - $purchase_date) / 86400;

		// fraction of value left
		// FIX ME - THIS SHIT IS BROKE AS HELL. Math is hard. :(
		$current_value = round(((30 * $depreciation_term - $diff_days) / (30 * $depreciation_term)) * $this->purchase_cost,2);

		if ($current_value < 0) {
			$current_value = 0;
		}
        	return $current_value;
        } else {
        	return $this->purchase_cost;
        }

	}


	public function user()
  	{
    	return $this->belongsTo('User');
  	}

}
