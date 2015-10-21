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
        'name'   => 'required|alpha_space|min:3|max:255',
        'category_id'   	=> 'required|integer',
        'qty'   	=> 'required|integer|min:1',
    );

    public function category()
    {
        return $this->belongsTo('Category', 'category_id')->where('category_type','=','accessory');
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
        return $this->belongsToMany('User', 'accessories_users', 'accessory_id','assigned_to')->withPivot('id')->withTrashed();
    }

    public function hasUsers()
    {
        return $this->belongsToMany('User', 'accessories_users', 'accessory_id','assigned_to')->count();
    }

    public function checkin_email() {
        return $this->category->checkin_email;
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
    public function scopeTextSearch($query, $search)
    {

        return $query->where(function($query) use ($search)
        {
                $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }

}
