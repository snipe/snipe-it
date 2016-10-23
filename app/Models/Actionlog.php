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
}
