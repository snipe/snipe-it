<?php

class InventoryState extends Elegant
{
    protected $table = 'inventory_states';
    protected $softDelete = false;

    protected $rules = array(
        'name'  => 'required|alpha_space|min:2|max:100|unique:inventory_states,name,{id}',
    );

    public function statuslabels()
    {
        return $this->hasMany('Statuslabel', 'inventory_state_id');
    }
    
    protected $required_id = array(1,2,3);
    
    public static function boot()
    {
        parent::boot();

        static::deleting( function($status) {            
            
            if ($status->isRequired())  
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

