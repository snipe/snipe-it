<?php

class License extends Eloquent {

	/**
	 * Deletes a category
	 *
	 * @return bool
	 */

	protected $table = 'licenses';

	public function delete()
	{
		// Delete the license
		return parent::delete();
	}





}
