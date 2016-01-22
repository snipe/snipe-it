<?php

class Depreciation extends Elegant
{
    // Declare the rules for the form validation
    protected $rules = array(
        'name' => 'required|alpha_space|min:3|max:255|unique:depreciations,name,{id}',
        'months' => 'required|min:1|max:240|integer',
    );

    public function has_models()
    {
        return $this->hasMany('Model', 'depreciation_id')->count();
    }

    public function has_licenses()
    {
      return $this->hasMany('License','depreciation_id')->count();
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
           $query->where('name', 'LIKE', '%'.$search.'%')
           ->orWhere('months', 'LIKE', '%'.$search.'%');
      });
      }
}
