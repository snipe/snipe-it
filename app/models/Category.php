<?php

class Category extends Elegant {

	protected $softDelete = true;

	/**
	* Category validation rules
	*/
	protected $rules = array(
		'name'   => 'required|min:2',
    );



	/**
	* Get the parent category name
	*/
	public function parentname()
	{
		return $this->belongsTo('Category','parent');
	}

	public function has_models()
	{
		return $this->hasMany('Model', 'category_id')->count();
	}



}
