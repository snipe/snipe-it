<?php

class Location extends Elegant
{
    protected $softDelete = true;
    protected $table = 'locations';
    protected $rules = array(
            'name'  		=> 'required|alpha_space|min:3|max:255|unique:locations,name,{id}',
            'city'   		=> 'required|alpha_space|min:3|max:255',
            'state'   		=> 'required|alpha|min:2|max:32',
            'country'   	=> 'required|alpha|min:2|max:2',
            'address'		=> 'required|alpha_space|min:5|max:80',
            'address2'		=> 'alpha_space|min:5|max:80',
            'zip'   		=> 'alpha_dash|min:3|max:10',
        );
    
    protected $required_id = array(1);
    
    //get defaults
    public function __construct($attributes = array())  {
        parent::__construct($attributes); // Eloquent
        $this->entity_id = DB::table('defaults')->where('name', 'entity')->pluck('value');
        
        $country_id = DB::table('defaults')->where('name', 'country')->pluck('value');
        $this->country = DB::table('countries')->where('id', $country_id)->pluck('code'); 
    }


    public function has_users()
    {
        return $this->hasMany('User', 'location_id')->count();
    }
    
    public function users()
    {
        return $this->hasMany('User', 'location_id');
    }
    
    
    public function entity()
    {
        return $this->belongsTo('Entity','entity_id')->withTrashed();
    }
    
     
    
    public static function boot()
    {
        parent::boot();

        static::deleting( function($object) {            
            
            if ($object->isRequired())  
            {
                return false;
            }
        });

    } 
    
    public function requiredIds()
    {
        return $this->required_id;
    }
    
    public function isRequired()
    {
        if (in_array($this->id, $this->requiredIds() ))  
        {
            return true;
        } 

        return false;
    }

}
