<?php

class Accessory extends Elegant
{
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'accessories';

    /**
    * Category validation rules
    */
    public $rules = array(
        'name'   => 'required|alpha_space|min:3|max:255|unique:accessories,name,{id}',
        'category_id'   	=> 'required|integer',
        'qty'   	=> 'required|integer|min:1',
    );

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    /**
    * Get action logs for this accessory
    */
     public function assetlog()
    {
        return $this->hasMany('Actionlog','accessory_id')->where('asset_type','=','accessory')->orderBy('created_at', 'desc')->withTrashed();
    }
    
    
    public function users()
    {
        return $this->belongsToMany('User', 'users', 'id')->withTrashed();
    }
    
    
}
