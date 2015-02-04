<?php

class Statuslabel extends Elegant
{
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'status_labels';


    protected $rules = array(
        'name'  => 'required|alpha_space|min:2|max:100|unique:status_labels,name,{id}',
    );

    public function has_assets()
    {
        return $this->hasMany('Asset', 'status_id')->count();
    }
}
