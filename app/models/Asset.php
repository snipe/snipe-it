<?php

class Asset extends Eloquent {

	/**
	 * Deletes an asset
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
