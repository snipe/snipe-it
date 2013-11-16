<?php

class Depreciation extends Eloquent {

	/**
	 * Deletes a depreciation
	 *
	 * @return bool
	 */

	protected $table = 'depreciations';

	public function delete()
	{
		// Delete the depreciation
		return parent::delete();
	}





}
