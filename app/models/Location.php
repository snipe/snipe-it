<?php

class Location extends Elegant {


	protected $softDelete = true;
	protected $table = 'locations';
	protected $rules = array(
			'name'  		=> 'required|alpha_space|min:3',
			'address'		=> 'required|alpha_space|min:5',
			'address2'		=> 'alpha_space|min:5',
			'city'   		=> 'required|alpha_space|min:3',
			'state'   		=> 'required|alpha|min:2',
			'country'   	=> 'required|alpha|min:2|max:2',
			'zip'   		=> 'alpha_dash|min:3',
		);

	public function has_users()
	{
		return $this->hasMany('User', 'location_id')->count();
	}

}
