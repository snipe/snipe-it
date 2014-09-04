<?php

class Statuslabel extends Elegant
{
    protected $table = 'status_labels';
    protected $softDelete = false;

    protected $rules = array(
        'name'  => 'required|alpha_space|min:2|max:100|unique:status_labels,name,{id}',
        'inventory_id' => 'required'
    );

    public function has_assets()
    {
        return $this->hasMany('Asset', 'status_id')->count();
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

    public function inventorystates()
    {
        return $this->belongsTo('InventoryState','inventory_state_id');
    }
    
}
