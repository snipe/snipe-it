<?php

class Country extends Elegant
{
    protected $table = 'countries';
    protected $softDelete = true;
    protected $errors;
    protected $rules = array(
              
        'name'        => 'alpha|min:3|max:255',        
        'code'       => 'alpha|min:2|max:2',       
        );    
    
}