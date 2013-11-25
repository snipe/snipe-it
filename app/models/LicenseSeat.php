<?php

class LicenseSeat extends Elegant {
	protected $table = 'license_seats';

	public function assignedusers()
  	{
    	return $this->belongsToMany('LicenseSeat', 'assigned_to');
  	}


}