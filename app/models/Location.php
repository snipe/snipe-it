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
    
    //get defaults
    public function __construct($attributes = array())  {
        parent::__construct($attributes); // Eloquent
        $this->entity_id = DB::table('defaults')->where('name', 'location_entity')->pluck('value');
    }


    public function has_users()
    {
        return $this->hasMany('User', 'location_id')->count();
    }
    
    public function entity()
    {
        return $this->belongsTo('Entity','entity_id')->withTrashed();
    }

}
