<?php

class License extends Eloquent {

	/**
	 * Deletes a category
	 *
	 * @return bool
	 */

	protected $table = 'assets';

	public function delete()
	{
		// Delete the license
		return parent::delete();
	}





}
