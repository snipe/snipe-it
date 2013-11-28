<?php

class ActionLog extends Eloquent {

	protected $table = 'asset_logs';
	public $timestamps = false;


	public function assetlog() {
		return $this->belongsTo('Asset','asset_id')->withTrashed();
	}

	public function licenselog() {
		return $this->belongsTo('License','asset_id');
	}

	public function adminlog() {
		return $this->belongsTo('User','user_id');
	}

	public function userlog() {
		return $this->belongsTo('User','checkedout_to')->withTrashed();
	}


	/**
	* Get the parent category name
	*/
	public function logaction($actiontype)
	{
		$this->action_type = $actiontype;

		if($this->save())
		{
			return true;
		} else {
			return false;
		}
	}




}
