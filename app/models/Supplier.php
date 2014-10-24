<?php
class Supplier extends Elegant
{
    protected $softDelete = true;
    // Declare the rules for the form validation
    protected $rules = array(
        'name'   			=> 'required|alpha_space|min:3|max:255|unique:suppliers,name,{id}',
        'address'   		=> 'alpha_space|min:3|max:50',
        'address2'   		=> 'alpha_space|min:2|max:50',
        'city'   			=> 'alpha_space|min:3|max:255',
        'state'                         => 'alpha_space|min:0|max:32',
        'country'                       => 'alpha_space|min:0|max:2',
        'fax'   			=> 'alpha_space|min:7|max:20',
        'phone'   			=> 'alpha_space|min:7|max:20',
        'contact'                       => 'alpha_space|min:0|max:100',
        'notes'                       => 'alpha_space|min:0|max:255',
        'email'   			=> 'email|min:5|max:150',
        'zip'                       => 'alpha_space|min:0|max:10',
        'url'   			=> 'alpha_space|min:3|max:250',
        
    );

    public function assets()
    {
        return $this->hasMany('Asset', 'supplier_id');
    }

    public function num_assets()
    {
        return $this->hasMany('Asset', 'supplier_id')->count();
    }


    public function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
    return $url;
    }

}
