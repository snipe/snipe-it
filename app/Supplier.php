<?php
class Supplier extends Elegant
{
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

    protected $rules = array(
        'name'              => 'required|alpha_space|min:3|max:255|unique:suppliers,name,{id}',
        'address'           => 'alpha_space|min:3|max:50',
        'address2'          => 'alpha_space|min:2|max:50',
        'city'              => 'alpha_space|min:3|max:255',
        'state'                         => 'alpha_space|min:0|max:32',
        'country'                       => 'alpha_space|min:0|max:2',
        'fax'               => 'alpha_space|min:7|max:20',
        'phone'             => 'alpha_space|min:7|max:20',
        'contact'                       => 'alpha_space|min:0|max:100',
        'notes'                       => 'alpha_space|min:0|max:255',
        'email'             => 'email|min:5|max:150',
        'zip'                       => 'alpha_space|min:0|max:10',
        'url'               => 'alpha_space|min:3|max:250',
    );

    public function assets()
    {
        return $this->hasMany('Asset', 'supplier_id');
    }

    public function asset_maintenances()
    {
        return $this->hasMany('AssetMaintenance', 'supplier_id');
    }

    public function num_assets()
    {
        return $this->hasMany('Asset', 'supplier_id')->count();
    }

    public function licenses()
    {
        return $this->hasMany('License', 'supplier_id');
    }

    public function num_licenses()
    {
        return $this->hasMany('License', 'supplier_id')->count();
    }

    public function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
    return $url;
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
