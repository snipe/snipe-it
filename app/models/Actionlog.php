<?php

class Actionlog extends Eloquent
{
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    protected $table = 'asset_logs';
    public $timestamps = true;
    protected $fillable = ['created_at'];


    public function assetlog()
    {
        return $this->belongsTo('Asset','asset_id')->withTrashed();
    }

     public function uploads()
    {
        return $this->belongsTo('Asset','asset_id')->where('action_type','=','uploaded')->withTrashed();
    }

    public function licenselog()
    {
        return $this->belongsTo('License','asset_id')->withTrashed();
    }

    public function accessorylog()
    {
        return $this->belongsTo('Accessory','accessory_id')->withTrashed();
    }

    public function adminlog()
    {
        return $this->belongsTo('User','user_id')->withTrashed();
    }

    public function userlog()
    {
        return $this->belongsTo('User','checkedout_to')->withTrashed();
    }



    /**
	* Check if the file exists, and if it does, force a download
	**/
    public function get_src() {

			$file = app_path().'/private_uploads/'.$this->filename;
			return $file;

    }



    /**
    * Get the parent category name
    */
    public function logaction($actiontype)
    {
        $this->action_type = $actiontype;

        if($this->save()) {
            return true;
        } else {
            return false;
        }
    }
}
