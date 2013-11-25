<?php

class LicenseSeat extends Elegant {
	protected $table = 'license_seats';

	public function license()
	{
		return $this->belongsTo('License');
	}

	public function user()
	{
		return $this->belongsTo('User','assigned_to');
	}

}