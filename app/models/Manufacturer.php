<?php
class Manufacturer extends Elegant
{
    protected $softDelete = true;
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

}
