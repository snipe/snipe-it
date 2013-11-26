<?php

class Depreciation extends Elegant {

		// Declare the rules for the form validation
		protected $rules = array(
			'name'   => 'required|alpha_space|min:3',
			'months'   => 'required|min:1|integer',
		);

	public function has_models()
	{
		return $this->hasMany('Model', 'depreciation_id')->count();
	}

}
