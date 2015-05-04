<?php

class Location extends Elegant
{
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'locations';
    protected $rules = array(
            'name'  		=> 'required|alpha_space|min:3|max:255|unique:locations,name,{id}',
            'city'   		=> 'required|alpha_space|min:3|max:255',
            'state'   		=> 'alpha_space|min:2|max:32',
            'country'   	=> 'required|alpha_space|min:2|max:2|max:2',
            'address'		=> 'alpha_space|min:5|max:80',
            'address2'		=> 'alpha_space|min:5|max:80',
            'zip'   		=> 'alpha_space|min:3|max:10',
        );

    public function has_users() {
        return $this->hasMany('User', 'location_id');
    }

    public function assets() {
        return $this->hasMany('Actionlog','location_id');
    }

    public function parent() {
        return $this->belongsTo('Location', 'parent_id');
    }

    public function childLocations() {
        return $this->hasMany('Location')->where('parent_id','=',$this->id);
    }
}
