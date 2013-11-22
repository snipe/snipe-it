<?php

class Setting extends Elegant {

	protected $table = 'settings';
	protected $rules = array(
			"option_value['site_name']" 	=> 'required|min:3',
			"option_value['per_page']"   		=> 'required|min:1|numeric',
		);

	public function getsettings()
	{
		$foo = Setting::all();
		print_r($foo);
	}

}
