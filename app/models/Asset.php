<?php

class Asset extends Eloquent {

	/**
	 * Deletes an sset
	 *
	 * @return bool
	 */

	protected $table = 'assets';

	public function delete()
	{
		// Delete the category
		return parent::delete();
	}






}
