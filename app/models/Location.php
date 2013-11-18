<?php

class Location extends Elegant {

	protected $table = 'locations';
	protected $rules = array(
			'name'  		=> 'required|min:3',
			'city'   		=> 'required|min:3',
			'state'   		=> 'required|alpha|min:2|max:2',
			'country'   	=> 'required|alpha|min:2|max:2',
		);

}
