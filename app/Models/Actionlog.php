<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model for the Actionlog (the table that keeps a historical log of
 * checkouts, checkins, and updates).
 *
 * @version    v1.0
 */
class Actionlog extends Model implements ICompanyableChild
{
    use SoftDeletes;

    protected $dates = [ 'deleted_at' ];

    protected $table      = 'action_logs';
    public $timestamps = true;
    protected $fillable   = [ 'created_at', 'item_type','user_id','item_id','action_type','note','target_id', 'target_type' ];

    public function getCompanyableParents()
    {
        return ['item'];
        // return [''];
    }

    // Eloquent Relationships below
    public function item()
    {
        return $this->morphTo('item')->withTrashed();
    }

    public function itemType()
    {

        if($this->item_type == AssetModel::class) {
            return "model";
        }
        return camel_case(class_basename($this->item_type));
    }

    public function uploads()
    {
        return $this->morphTo('item')
                    ->where('action_type', '=', 'uploaded')
                    ->withTrashed();
    }

    public function userlog()
    {
        return $this->target();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
                    ->withTrashed();
    }

    public function target()
    {
        return $this->morphTo('target');
    }

    /**
      * Check if the file exists, and if it does, force a download
      **/
    public function get_src($type = 'assets')
    {

        $file = config('app.private_uploads') . '/' . $type . '/' . $this->filename;

        return $file;

    }

    /**
       * Get the parent category name
       */
    public function logaction($actiontype)
    {

        $this->action_type = $actiontype;

        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }


    /**
       * getListingOfActionLogsChronologicalOrder
       *
       * @return mixed
       * @author  Vincent Sposato <vincent.sposato@gmail.com>
       * @version v1.0
       */
    public function getListingOfActionLogsChronologicalOrder()
    {

        return $this->all()
                 ->where('action_type', '!=', 'uploaded')
                 ->orderBy('item_id', 'asc')
                 ->orderBy('created_at', 'asc')
                 ->get();
    }
}
