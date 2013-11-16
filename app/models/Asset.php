<?php

class Asset extends Eloquent {

	/**
	 * Deletes an asset
	 *
	 * @return bool
	 */

	protected $table = 'assets';

	public function delete()
	{
		// Delete the asset
		return parent::delete();
	}

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

}
