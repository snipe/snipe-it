<?php

class Statuslabel extends Elegant
{
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $table = 'status_labels';


    protected $rules = array(
        'name'  => 'required|alpha_space|min:2|max:100|unique:status_labels,name,{id}',
        'statuslabel_types' => 'required|in:deployable,pending,archived,undeployable',
		'notes'	=> 'alpha_space',
    );

    public function has_assets()
    {
        return $this->hasMany('Asset', 'status_id')->count();
    }

    public function getStatuslabelType() {

    	if ($this->pending == 1) {
			return 'pending';
		} elseif ($this->archived == 1) {
			return 'archived';
		} elseif (($this->archived == 0) && ($this->deployable == 0) && ($this->deployable == 0)) {
			return 'undeployable';
		} else {
			return 'deployable';
		}
    }

    public static function getStatuslabelTypesForDB($type) {
		if ($type == 'pending') {
			$statustype['pending'] = 1;
			$statustype['deployable'] = 0;
			$statustype['archived'] = 0;

		} elseif ($type == 'deployable') {
			$statustype['pending'] = 0;
			$statustype['deployable'] = 1;
			$statustype['archived'] = 0;

		} elseif ($type == 'archived') {
			$statustype['pending'] = 0;
			$statustype['deployable'] = 0;
			$statustype['archived'] = 1;

		} elseif ($type == 'undeployable') {
			$statustype['pending'] = 0;
			$statustype['deployable'] = 0;
			$statustype['archived'] = 0;
		}

		return $statustype;
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
