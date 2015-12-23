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
        'name'   => 'required|alpha_space|min:3|max:255|unique:categories,name,{id},id,deleted_at,NULL',
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

    public function accessoriescount()
    {
        return $this->hasMany('Accessory')->count();
    }

    public function accessories()
    {
        return $this->hasMany('Accessory');
    }

    public function consumablesCount()
    {
        return $this->hasMany('Consumable')->count();
    }

    public function consumables()
    {
        return $this->hasMany('Consumable');
    }

    public function itemCount()
    {
        switch ($this->category_type) {
            case 'asset':
                return $this->assetscount();
            case 'accessory':
                return $this->accessoriescount();
            case 'consumable':
                return $this->consumablesCount();
        }
        return '0';
    }

    public function assets()
    {
        return $this->hasManyThrough('Asset', 'Model');
    }

    public function models()
    {
        return $this->hasMany('Model', 'category_id');
    }

    public function getEula() {

	    $Parsedown = new Parsedown();

	    if ($this->eula_text) {
		    return $Parsedown->text(e($this->eula_text));
	    } elseif ((Setting::getSettings()->default_eula_text) && ($this->use_default_eula=='1')) {
		    return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
	    } else {
		    return null;
	    }

    }

    /**
     * scopeRequiresAcceptance
     *
     * @param $query
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function scopeRequiresAcceptance( $query )
    {

        return $query->where( 'require_acceptance', '=', true );
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
            ->orWhere('category_type', 'LIKE', '%'.$search.'%');
        });
    }

}
