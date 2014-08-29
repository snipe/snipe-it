<?php
class Manufacturer extends Elegant
{
    protected $softDelete = false;
    protected $table = 'manufacturers';
    
    // Declare the rules for the form validation
    protected $rules = array(
        'name'   => 'required|alpha_space|min:2|max:255|unique:manufacturers,name,{id}',
        'user_id' => 'integer',
    );

    public function has_models()
    {
        return $this->hasMany('Model', 'manufacturer_id')->count();
    }
    
    public function models()
    {
        return $this->hasMany('Model', 'manufacturer_id');
    }
    
    public function licenses()
    {
        return $this->hasMany('License', 'manufacturer_id');
    }

    public function has_licenses()
    {
        return $this->hasMany('License', 'manufacturer_id')->count();
    }

}
