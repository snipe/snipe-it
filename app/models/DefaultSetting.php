<?php

class DefaultSetting extends Elegant
{
    protected $table = 'defaults';
    protected $softDelete = true;
    protected $errors;
    protected $rules = array(
              
        'table_name'        => 'alpha|min:6|max:255',        
        'column_name'       => 'alpha|min:6|max:255',       
        );    
   
}