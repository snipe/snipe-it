<?php

class Model extends Elegant {

	// Declare the rules for the form validation
	protected $rules = array(
		'name'   => 'required|min:3',
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
		return $this->belongsTo('Depreciation','id');
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
