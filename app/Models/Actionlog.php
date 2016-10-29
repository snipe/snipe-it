<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Model for the Actionlog (the table that keeps a historical log of
 * checkouts, checkins, and updates).
 *
 * @version    v1.0
 */
class Actionlog extends Model
{
    use SoftDeletes;

    protected $dates = [ 'deleted_at' ];

    protected $table      = 'action_logs';
    public $timestamps = true;
    protected $fillable   = [ 'created_at', 'item_type','user_id','item_id','action_type','note','target_id', 'target_type' ];

    // Overridden from Builder to automatically add the company
    public static function boot()
    {
        parent::boot();
        static::creating( function (Actionlog $actionlog) {
            // If the admin is a superadmin, let's see if the target instead has a company.
            if (Auth::user() && Auth::user()->isSuperUser()) {
                if ($actionlog->target) {
                    $actionlog->company_id = $actionlog->target->company_id;
                } else if ($actionlog->item) {
                    $actionlog->company_id = $actionlog->item->company_id;
                }
            } else if (Auth::user() && Auth::user()->company) {
                $actionlog->company_id = Auth::user()->company_id;
            }
        });
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

    public function childlogs()
    {
        return $this->hasMany('\App\Models\ActionLog', 'thread_id');
    }

    public function parentlog()
    {
        return $this->belongsTo('\App\Models\ActionLog', 'thread_id');
    }

    /**
       * Check if the file exists, and if it does, force a download
       **/
    public function get_src($type = 'assets', $fieldname = 'filename')
    {
        $file = config('app.private_uploads') . '/' . $type . '/' . $this->{$fieldname};
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
