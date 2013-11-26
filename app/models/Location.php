<?php

class Location extends Elegant {


	protected $softDelete = true;
	protected $table = 'locations';
	protected $rules = array(
			'name'  		=> 'required|min:3',
			'city'   		=> 'required|min:3',
			'state'   		=> 'required|alpha|min:2|max:2',
			'country'   	=> 'required|alpha|min:2|max:2',
			'zip'   => 'alpha_dash|min:5',
		);

	public function has_users()
	{
		return $this->hasMany('User', 'location_id')->count();
	}

}
