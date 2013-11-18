<?php

class Category extends Elegant {

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




}
