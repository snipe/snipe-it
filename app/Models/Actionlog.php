<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * Model for the Actionlog (the table that keeps a historical log of
 * checkouts, checkins, and updates).
 *
 * @version    v1.0
 */
class Actionlog extends SnipeModel
{
    use HasFactory;

    protected $presenter = \App\Presenters\ActionlogPresenter::class;
    use SoftDeletes;
    use Presentable;

    protected $table = 'action_logs';
    public $timestamps = true;
    protected $fillable = ['created_at', 'item_type', 'user_id', 'item_id', 'action_type', 'note', 'target_id', 'target_type', 'stored_eula'];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['action_type', 'note', 'log_meta','user_id'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'company' => ['name'],
        'user' => ['first_name','last_name','username'],
    ];

    /**
     * Override from Builder to automatically add the company
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function (self $actionlog) {
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


    /**
     * Establishes the actionlog -> item relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function item()
    {
        return $this->morphTo('item')->withTrashed();
    }

    /**
     * Establishes the actionlog -> company relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function company()
    {
        return $this->hasMany(\App\Models\Company::class, 'id', 'company_id');
    }

    /**
     * Establishes the actionlog -> item type relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function itemType()
    {
        if ($this->item_type == AssetModel::class) {
            return 'model';
        }

        return camel_case(class_basename($this->item_type));
    }

    /**
     * Establishes the actionlog -> target type relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function targetType()
    {
        if ($this->target_type == User::class) {
            return 'user';
        }

        return camel_case(class_basename($this->target_type));
    }


    /**
     * Establishes the actionlog -> uploads relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function uploads()
    {
        return $this->morphTo('item')
                    ->where('action_type', '=', 'uploaded')
                    ->withTrashed();
    }

    /**
     * Establishes the actionlog -> userlog relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function userlog()
    {
        return $this->target();
    }

    /**
     * Establishes the actionlog -> user relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
                    ->withTrashed();
    }

    /**
     * Establishes the actionlog -> target relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function target()
    {
        return $this->morphTo('target')->withTrashed();
    }

    /**
     * Establishes the actionlog -> location relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function location()
    {
        return $this->belongsTo(\App\Models\Location::class, 'location_id')->withTrashed();
    }


    /**
     * Check if the file exists, and if it does, force a download
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return string | false
     */
    public function get_src($type = 'assets', $fieldname = 'filename')
    {
        if ($this->filename != '') {
            $file = config('app.private_uploads').'/'.$type.'/'.$this->{$fieldname};

            return $file;
        }

        return false;
    }

    /**
     * Saves the log record with the action type
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return bool
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
     * Calculate the number of days until the next audit
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return int
     */
    public function daysUntilNextAudit($monthInterval = 12, $asset = null)
    {
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

    /**
     * Calculate the date of the next audit
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Datetime
     */
    public function calcNextAuditDate($monthInterval = 12, $asset = null)
    {
        $last_audit_date = Carbon::parse($this->created_at);
        // If there is an asset-specific next date already given,
        if (($asset) && ($asset->next_audit_date)) {
            return \Carbon::parse($asset->next_audit_date);
        }

        return  \Carbon::parse($last_audit_date)->addMonths($monthInterval)->toDateString();
    }

    /**
     * Gets action logs in chronological order, excluding uploads
     *
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @since v1.0
     * @return \Illuminate\Database\Eloquent\Collection
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
