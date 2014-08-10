<?php

class Location extends Elegant
{
    protected $softDelete = true;
    protected $table = 'locations';
    protected $rules = array(
            'name'  		=> 'required|alpha_space|min:3|max:255|unique:locations,name,{id}',
            'city'   		=> 'required|alpha_space|min:3|max:255',
            'state'   		=> 'required|alpha|min:2|max:32',
            'country'   	=> 'required|alpha|min:2|max:2|max:2',
            'address'		=> 'required|alpha_space|min:5|max:80',
            'address2'		=> 'alpha_space|min:5|max:80',
            'zip'   		=> 'alpha_dash|min:3|max:10',
        );

    public function has_users()
    {
        return $this->hasMany('User', 'location_id')->count();
    }

}
