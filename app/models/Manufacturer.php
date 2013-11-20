<?php
class Manufacturer extends Elegant {

	// Declare the rules for the form validation
	protected $rules = array(
		'name'   => 'required|min:2',
	);

	public function has_models()
	{
		return $this->hasMany('Model', 'manufacturer_id')->count();
	}

}
