<?php

// Entity object model

class Entity extends Elegant
{
    protected $softDelete = false;
    protected $table = 'entities';
    
    protected $rules = array(
            'name'  		=> 'required|alpha_space|min:3|max:255|unique:entities,name,{id}',
            'common_name'       => 'required|alpha_space|min:3|max:255|unique:entities,common_name,{id}'
        );   
    
    protected $required_id = array(1);
    
    public static function boot()
    {
        parent::boot();

        static::deleting( function($entity) {            
            
            if ($entity->isRequired())  
            {
                return false;
            }
        });

    } 

    public function has_locations()
    {
        return $this->hasMany('Location', 'entity_id')->count();
    }
    
    public function locations()
    {
        return $this->hasMany('Location', 'entity_id');
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
