<?php

class Authentication extends Eloquent {

	/**
	 *
	 *
	 * @return
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

}
