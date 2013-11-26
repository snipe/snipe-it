<?php

class Statuslabel extends Elegant {
	protected $table = 'status_labels';
	protected $softDelete = true;

	protected $rules = array(
		'name'  		=> 'required|alpha_space|min:2',
	);

	public function has_assets()
	{
		return $this->hasMany('Asset', 'status_id')->count();
	}

}
