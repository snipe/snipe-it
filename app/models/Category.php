<?php

class Category extends Elegant
{
    protected $table = 'categories';
    protected $softDelete = true;

    /**
    * Category validation rules
    */
    public $rules = array(
        'user_id' => 'numeric',
        'name'   => 'required|alpha_dash|min:3|max:255|unique:categories,name,{id}',
    );


    public function has_models()
    {
        return $this->hasMany('Model', 'category_id')->count();
    }

    public function models()
    {
        return $this->hasMany('Model', 'category_id');

    }



}
