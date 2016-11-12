<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
=======
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

/**
 * Model for the Actionlog (the table that keeps a historical log of
 * checkouts, checkins, and updates).
 *
 * @version    v1.0
 */
<<<<<<< HEAD
class Actionlog extends Model implements ICompanyableChild
{
    use SoftDeletes;
    use CompanyableChildTrait;

    protected $dates = [ 'deleted_at' ];

    protected $table      = 'asset_logs';
    public $timestamps = true;
    protected $fillable   = [ 'created_at', 'asset_type','user_id','asset_id','action_type','note','checkedout_to' ];

    public function getCompanyableParents()
    {
        return [ 'accessorylog', 'assetlog', 'licenselog', 'consumablelog' ];
    }

    public function assetlog()
    {

        return $this->belongsTo('\App\Models\Asset', 'asset_id')
                    ->withTrashed();
    }

    public function uploads()
    {

        return $this->belongsTo('\App\Models\Asset', 'asset_id')
                    ->where('action_type', '=', 'uploaded')
                    ->withTrashed();
    }

    public function licenselog()
    {

        return $this->belongsTo('\App\Models\License', 'asset_id')
                    ->withTrashed();
    }

    public function componentlog()
    {

        return $this->belongsTo('\App\Models\Component', 'component_id')
            ->withTrashed();
    }

    public function accessorylog()
    {

        return $this->belongsTo('\App\Models\Accessory', 'accessory_id')
                    ->withTrashed();
    }

    public function consumablelog()
    {

        return $this->belongsTo('\App\Models\Consumable', 'consumable_id')
                    ->withTrashed();
    }

    public function adminlog()
    {

        return $this->belongsTo('\App\Models\User', 'user_id')
                    ->withTrashed();
    }

    public function userlog()
    {

        return $this->belongsTo('\App\Models\User', 'checkedout_to')
                    ->withTrashed();
    }

    public function userasassetlog()
    {

        return $this->belongsTo('\App\Models\User', 'asset_id')
            ->withTrashed();
=======
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
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
    }

    public function childlogs()
    {
<<<<<<< HEAD

=======
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
        return $this->hasMany('\App\Models\ActionLog', 'thread_id');
    }

    public function parentlog()
    {
<<<<<<< HEAD

=======
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
        return $this->belongsTo('\App\Models\ActionLog', 'thread_id');
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

<<<<<<< HEAD
        return DB::table('asset_logs')
                 ->select('*')
                 ->where('action_type', '!=', 'uploaded')
                 ->orderBy('asset_id', 'asc')
                 ->orderBy('created_at', 'asc')
                 ->get();
    }

    /**
       * getLatestCheckoutActionForAssets
       *
       * @return mixed
       * @author  Vincent Sposato <vincent.sposato@gmail.com>
       * @version v1.0
       */
    public function getLatestCheckoutActionForAssets()
    {

        return DB::table('asset_logs')
                 ->select(DB::raw('asset_id, MAX(created_at) as last_created'))
                 ->where('action_type', '=', 'checkout')
                 ->groupBy('asset_id')
                 ->get();
    }

    /**
       * scopeCheckoutWithoutAcceptance
       *
       * @param $query
       *
       * @return mixed
       * @author  Vincent Sposato <vincent.sposato@gmail.com>
       * @version v1.0
       */
    public function scopeCheckoutWithoutAcceptance($query)
    {

        return $query->where('action_type', '=', 'checkout')
                     ->where('accepted_id', '=', null);
    }
=======
        return $this->all()
                 ->where('action_type', '!=', 'uploaded')
                 ->orderBy('item_id', 'asc')
                 ->orderBy('created_at', 'asc')
                 ->get();
    }
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
}
