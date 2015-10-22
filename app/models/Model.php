<?php

//use CustomField;

class Model extends Elegant
{
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'models';

    // Declare the rules for the form validation
    protected $rules = array(
        'name'   		=> 'required|alpha_space|min:2|max:255|unique:models,deleted_at,NULL',
        'modelno'   		=> 'alpha_space|min:1|max:255',
        'category_id'   	=> 'required|integer',
        'manufacturer_id'   => 'required|integer',
        'eol'   => 'required|integer:min:0|max:240',
        'user_id' => 'integer',
    );

    public function assets()
    {
        return $this->hasMany('Asset', 'model_id');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    public function depreciation()
    {
        return $this->belongsTo('Depreciation','depreciation_id');
    }

    public function adminuser()
    {
        return $this->belongsTo('User','user_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo('Manufacturer','manufacturer_id');
    }
    
    public function fieldset()
    {
        return $this->belongsTo('CustomFieldset','fieldset_id');
    }

    /**
	* -----------------------------------------------
	* BEGIN QUERY SCOPES
	* -----------------------------------------------
	**/

    /**
	* Query builder scope for Deleted assets
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/

	public function scopeDeleted($query)
	{
		return $query->whereNotNull('deleted_at');
	}

    /**
     * scopeInCategory
     * Get all models that are in the array of category ids
     *
     * @param       $query
     * @param array $categoryIdListing
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function scopeInCategory( $query, array $categoryIdListing )
    {

        return $query->whereIn( 'category_id', $categoryIdListing );
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

        return $query->where('name', 'LIKE', "%$search%")
            ->orWhere('modelno', 'LIKE', "%$search%")
            ->orWhere(function($query) use ($search) {
                $query->whereHas('depreciation', function($query) use ($search) {
                    $query->where('name','LIKE','%'.$search.'%');
                });
            })
            ->orWhere(function($query) use ($search) {
                $query->whereHas('category', function($query) use ($search) {
                    $query->where('name','LIKE','%'.$search.'%');
                });
            })
            ->orWhere(function($query) use ($search) {
                $query->whereHas('manufacturer', function($query) use ($search) {
                    $query->where('name','LIKE','%'.$search.'%');
                });
            });

    }

}
