<?php

class Model extends Elegant {

	// Declare the rules for the form validation
	protected $rules = array(
		'name'   		=> 'required|alpha_space|min:3',
		'modelno'   		=> 'alpha_space|min:1',
		'category_id'   	=> 'required|integer',
		'manufacturer_id'   => 'required|integer',
		'eol'   => 'integer',
	);

	public function assets()
	{
		return $this->hasMany('Asset', 'model_id');
	}

	public function category()
	{
		return $this->belongsTo('Category', 'category_id');
	}

	public function depreciation()
	{
		return $this->belongsTo('Depreciation','depreciation_id');
	}

	public function adminuser()
	{
		return $this->belongsTo('User','user_id');
	}

	public function manufacturer()
	{
		return $this->belongsTo('Manufacturer','manufacturer_id');
	}

}
