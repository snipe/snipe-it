<?php
class Supplier extends Elegant
{
    protected $softDelete = true;
    // Declare the rules for the form validation
    protected $rules = array(
        'name'   			=> 'required|alpha_space|min:3',
        'address'   		=> 'alpha_space|min:3',
        'address2'   		=> 'alpha_space|min:2',
        'city'   			=> 'alpha_space|min:3',
        'fax'   			=> 'alpha_space|min:7',
        'phone'   			=> 'alpha_space|min:7',
        'email'   			=> 'email|min:5',
        'url'   			=> 'alpha_space|min:3',
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
