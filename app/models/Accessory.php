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
        return $this->belongsToMany('User', 'accessories_users', 'user_id')->withTrashed();
    }
    
    
    public function requireAcceptance() {    
	    return $this->category->require_acceptance;
    }
    
    public function getEula() { 
	      
	    $Parsedown = new Parsedown();
        
	    if ($this->category->eula_text) {
		    return $Parsedown->text(e($this->category->eula_text));
	    } elseif (Setting::getSettings()->default_eula_text) {
		    return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
	    } else {
		    return null;
	    } 
	    
    }

    
}
