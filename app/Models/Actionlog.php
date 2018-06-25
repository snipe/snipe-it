<?php
namespace App\Models;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Response;
use Carbon;

/**
 * Model for the Actionlog (the table that keeps a historical log of
 * checkouts, checkins, and updates).
 *
 * @version    v1.0
 */
class Actionlog extends SnipeModel
{
    protected $presenter = "App\Presenters\ActionlogPresenter";
    use SoftDeletes;
    use Presentable;
    protected $dates = [ 'deleted_at' ];

    protected $table      = 'action_logs';
    public $timestamps = true;
    protected $fillable   = [ 'created_at', 'item_type','user_id','item_id','action_type','note','target_id', 'target_type' ];

    // Overridden from Builder to automatically add the company
    public static function boot()
    {
        parent::boot();
        static::creating(function (Actionlog $actionlog) {
            // If the admin is a superadmin, let's see if the target instead has a company.
            if (Auth::user() && Auth::user()->isSuperUser()) {
                if ($actionlog->target) {
                    $actionlog->company_id = $actionlog->target->company_id;
                } elseif ($actionlog->item) {
                    $actionlog->company_id = $actionlog->item->company_id;
                }
            } elseif (Auth::user() && Auth::user()->company) {
                $actionlog->company_id = Auth::user()->company_id;
            }
        });
    }
    // Eloquent Relationships below
    public function item()
    {
        return $this->morphTo('item')->withTrashed();
    }

    public function company()
    {
        return $this->hasMany('\App\Models\Company', 'id', 'company_id');
    }

    public function itemType()
    {

        if ($this->item_type == AssetModel::class) {
            return "model";
        }
        return camel_case(class_basename($this->item_type));
    }

    public function targetType()
    {
        if ($this->target_type == User::class) {
            return "user";
        }
        return camel_case(class_basename($this->target_type));
    }

    public function parseItemRoute()
    {
        if ($this->itemType() == "asset") {
            $itemroute = 'assets';
        } elseif ($this->itemType() == "accessory") {
            $itemroute = 'accessories';
        } elseif ($this->itemType()=="consumable") {
            $itemroute = 'consumables';
        } elseif ($this->itemType()=="license") {
            $itemroute = 'licenses';
        } elseif ($this->itemType()=="component") {
            $itemroute = 'components';
        } else {
            $itemroute = '';
        }

        return $itemroute;
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
        return $this->morphTo('target')->withTrashed();
    }

    public function childlogs()
    {
        return $this->hasMany('\App\Models\ActionLog', 'thread_id');
    }

    public function parentlog()
    {
        return $this->belongsTo('\App\Models\ActionLog', 'thread_id');
    }

    public function location() {
        return $this->belongsTo('\App\Models\Location', 'location_id' )->withTrashed();
    }

    /**
       * Check if the file exists, and if it does, force a download
       **/
    public function get_src($type = 'assets', $fieldname = 'filename')
    {
        if ($this->filename!='') {
            $file = config('app.private_uploads') . '/' . $type . '/' . $this->{$fieldname};
            return $file;
        }
        return false;
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

    public function daysUntilNextAudit($monthInterval = 12, $asset = null) {

        $now = Carbon::now();
        $last_audit_date = $this->created_at;
        $next_audit = $last_audit_date->addMonth($monthInterval);
        $next_audit_days = $now->diffInDays($next_audit);

        // Override the default setting for interval if the asset has its own next audit date
        if (($asset) && ($asset->next_audit_date)) {
            $override_default_next = \Carbon::parse($asset->next_audit_date);
            $next_audit_days = $override_default_next->diffInDays($now);
        }

        return $next_audit_days;
    }

    public function calcNextAuditDate($monthInterval = 12, $asset = null) {

        $last_audit_date = Carbon::parse($this->created_at);
        // If there is an asset-specific next date already given,
        if (($asset) && ($asset->next_audit_date)) {
            return \Carbon::parse($asset->next_audit_date);
        }

        return  \Carbon::parse($last_audit_date)->addMonths($monthInterval)->toDateString();
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

    /**
     * Query builder scope to search on text for complex Bootstrap Tables API
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $search      Search term
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeTextSearch($query, $search)
    {
        $search = explode(' OR ', $search);

        return $query->where(function ($query) use ($search) {

            foreach ($search as $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('company', function ($query) use ($search) {
                        $query->where('companies.name', 'LIKE', '%'.$search.'%');
                    });
                })->orWhere('action_type', 'LIKE', '%'.$search.'%')
                    ->orWhere('note', 'LIKE', '%'.$search.'%')
                    ->orWhere('log_meta', 'LIKE', '%'.$search.'%');
            }

        });
    }
}
