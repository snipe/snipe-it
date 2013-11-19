<?php

class ActionLog extends Eloquent {

	protected $table = 'asset_logs';
	public $timestamps = false;

	/**
	* Get the parent category name
	*/
	public function assetlog()
	{

	}

	/**
	* Get the parent category name
	*/
	public function userlog()
	{

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
