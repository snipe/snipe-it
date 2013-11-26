<?php
class Manufacturer extends Elegant {

	protected $softDelete = true;
	// Declare the rules for the form validation
	protected $rules = array(
		'name'   => 'required|alpha_space|min:2',
	);

	public function has_models()
	{
		return $this->hasMany('Model', 'manufacturer_id')->count();
	}

}
