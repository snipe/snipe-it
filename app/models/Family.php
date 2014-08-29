<?php

// Family object model

class Family extends Elegant
{
    protected $softDelete = false;
    protected $table = 'families';
    
    protected $rules = array(
            'name'  		=> 'required|alpha_space|min:3|max:255|unique:families,name,{id}',
            'common_name'       => 'required|alpha_space|min:3|max:255|unique:families,common_name,{id}'
        );

    public function has_licenses()
    {
        return $this->hasMany('License', 'family_id')->count();
    }
    
    public function licenses()
    {
        return $this->hasMany('License', 'family_id');
    }
}
