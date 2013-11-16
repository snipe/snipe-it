<?php

class Location extends Eloquent {

	/**
	 * Deletes a location
	 *
	 * @return bool
	 */

	protected $table = 'locations';

	public function delete()
	{
		// Delete the depreciation
		return parent::delete();
	}

}
