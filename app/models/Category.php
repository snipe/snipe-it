<?php

class Category extends Elegant
{
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'categories';

    /**
    * Category validation rules
    */
    public $rules = array(
        'user_id' => 'numeric',
        'name'   => 'required|alpha_space|min:3|max:255|unique:categories,name,{id}',
        'category_type'   => 'required',
    );

    public function has_models()
    {
        return $this->hasMany('Model', 'category_id')->count();
    }

     public function assetscount()
    {
        return $this->hasManyThrough('Asset', 'Model')->count();
    }

    public function assets()
    {
        return $this->hasManyThrough('Asset', 'Model');
    }

    public function models()
    {
        return $this->hasMany('Model', 'category_id');
    }
    
    
}
