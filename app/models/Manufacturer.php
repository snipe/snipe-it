<?php
class Manufacturer extends Elegant
{
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
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

     public function assetscount()
    {
        return $this->hasManyThrough('Asset', 'Model')->count();
    }

    public function assets()
    {
        return $this->hasManyThrough('Asset', 'Model');
    }

    /**
    * Query builder scope to search on text
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $search      Search term
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeTextSearch($query, $search)
    {

        return $query->where(function($query) use ($search)
        {
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }
}
