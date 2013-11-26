<?php

class Category extends Elegant {

	protected $softDelete = true;

	/**
	* Category validation rules
	*/
	protected $rules = array(
		'name'   => 'required|alpha_space|min:2',
    );


	public function has_models()
	{
		return $this->hasMany('Model', 'category_id')->count();
	}

	public function models()
	{
		return $this->hasMany('Model', 'category_id');

	}



}
