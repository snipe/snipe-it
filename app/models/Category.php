<?php

class Category extends Eloquent {

	/**
	 * Deletes a category
	 *
	 * @return bool
	 */

	protected $table = 'categories';

	public function delete()
	{
		// Delete the category
		return parent::delete();
	}


	/**
	* Get the parent category name
	*/
	public function parentname()
	{
		return $this->belongsTo('Category','parent');
	}




}
