<?php

class LicenseSeat extends Elegant {
	protected $table = 'license_seats';
	protected $softDelete = true;

	public function license()
	{
		return $this->belongsTo('License','license_id');
	}

	public function user()
	{
		return $this->belongsTo('User','assigned_to')->withTrashed();
	}

}