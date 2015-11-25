<?php

class Consumable extends Elegant
{
    use SoftDeletingTrait;
    use CompanyableTrait;

    protected $dates = ['deleted_at'];
    protected $table = 'consumables';

    /**
    * Category validation rules
    */
    public $rules = array(
        'name'        => 'required|alpha_space|min:3|max:255',
        'qty'         => 'required|integer|min:0',
        'category_id' => 'integer',
        'company_id'  => 'required|integer',
    );

    public function admin()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function consumableAssigments()
    {
        return $this->hasMany('ConsumableAssignment');
    }

    public function company()
    {
        return $this->belongsTo('Company', 'company_id');
    }

    public function location()
    {
        return $this->belongsTo('Location', 'location_id');
    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    /**
    * Get action logs for this consumable
    */
     public function assetlog()
    {
        return $this->hasMany('Actionlog','consumable_id')->where('asset_type','=','consumable')->orderBy('created_at', 'desc')->withTrashed();
    }


    public function users()
    {
        return $this->belongsToMany('User', 'consumables_users', 'consumable_id','assigned_to')->withPivot('user_id')->withTrashed()->withTimestamps();
    }

    public function hasUsers()
    {
        return $this->belongsToMany('User', 'consumables_users', 'consumable_id','assigned_to')->count();
    }


    public function requireAcceptance() {
	    return $this->category->require_acceptance;
    }

    public function getEula() {

	    $Parsedown = new Parsedown();

	    if ($this->category->eula_text) {
		    return $Parsedown->text(e($this->category->eula_text));
	    } elseif ((Setting::getSettings()->default_eula_text) && ($this->category->use_default_eula=='1')) {
		    return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
	    } else {
		    return null;
	    }

    }

    public function numRemaining() {
	    $checkedout = $this->users->count();
	    $total = $this->qty;
	    $remaining = $total - $checkedout;
	    return $remaining;
    }

    /**
    * Query builder scope to search on text
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $search      Search term
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
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
  		$search = explode(' ', $search);

  		return $query->where(function($query) use ($search)
  		{
  			foreach ($search as $search) {
  					$query->whereHas('category', function($query) use ($search) {
  						$query->where('categories.name','LIKE','%'.$search.'%');
          })->orWhere(function($query) use ($search) {
  					$query->whereHas('company', function($query) use ($search) {
  						$query->where('companies.name','LIKE','%'.$search.'%');
  					});
          })->orWhere(function($query) use ($search) {
  					$query->whereHas('location', function($query) use ($search) {
  						$query->where('locations.name','LIKE','%'.$search.'%');
  					});
  				})->orWhere('consumables.name','LIKE','%'.$search.'%')
  				->orWhere('consumables.order_number','LIKE','%'.$search.'%')
          ->orWhere('consumables.purchase_cost','LIKE','%'.$search.'%')
          ->orWhere('consumables.purchase_date','LIKE','%'.$search.'%');
  			}
  		});
  	}

    /**
  	* Query builder scope to order on company
  	*
  	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  	* @param  text                              $order    	 Order
  	*
  	* @return Illuminate\Database\Query\Builder          Modified query builder
  	*/
  	public function scopeOrderCategory($query, $order)
  	{
  		return $query->join('categories', 'consumables.category_id', '=', 'categories.id')->orderBy('categories.name', $order);
  	}

    /**
  	* Query builder scope to order on company
  	*
  	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  	* @param  text                              $order    	 Order
  	*
  	* @return Illuminate\Database\Query\Builder          Modified query builder
  	*/
  	public function scopeOrderLocation($query, $order)
  	{
  		return $query->leftJoin('locations', 'consumables.location_id', '=', 'locations.id')->orderBy('locations.name', $order);
  	}


    /**
  	* Query builder scope to order on company
  	*
  	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  	* @param  text                              $order    	 Order
  	*
  	* @return Illuminate\Database\Query\Builder          Modified query builder
  	*/
  	public function scopeOrderCompany($query, $order)
  	{
  		return $query->leftJoin('companies', 'consumables.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
  	}



}
