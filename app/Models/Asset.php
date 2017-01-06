<?php
namespace App\Models;

use App\Helpers\Helper;
use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Location;
use App\Models\Loggable;
use App\Models\Requestable;
use App\Models\Setting;
use Auth;
use Config;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use Parsedown;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Assets.
 *
 * @version    v1.0
 */
class Asset extends Depreciable
{
    use Loggable;
    use SoftDeletes;
    use Requestable;

  /**
  * The database table used by the model.
  *
  * @var string
  */
    protected $table = 'assets';

  /**
  * Whether the model should inject it's identifier to the unique
  * validation rules before attempting validation. If this property
  * is not set in the model it will default to true.
  *
  * @var boolean
  */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UniqueUndeletedTrait;

    protected $rules = [
    'name'            => 'min:2|max:255',
    'model_id'        => 'required|integer',
    'status_id'       => 'required|integer',
    'company_id'      => 'integer',
    'warranty_months' => 'integer|min:0|max:240',
    'physical'         => 'integer',
    'checkout_date'   => 'date|max:10|min:10',
    'checkin_date'    => 'date|max:10|min:10',
    'supplier_id'     => 'integer',
    'asset_tag'       => 'required|min:1|max:255|unique_undeleted',
    'status'          => 'integer',
    'purchase_cost'   => 'numeric',
    ];


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = ['name','model_id','status_id','asset_tag'];


    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }


    public function availableForCheckout()
    {
      return (
          empty($this->assigned_to) &&
          $this->assetstatus->deployable == 1 &&
          empty($this->deleted_at)
        );
    }

  /**
  * Checkout asset
  */
    public function checkOutToUser($user, $admin, $checkout_at = null, $expected_checkin = null, $note = null, $name = null)
    {
        if (!$user) {
            return false;
        }

        if ($expected_checkin) {
            $this->expected_checkin = $expected_checkin;
        }

        $this->last_checkout = $checkout_at;

        $this->assigneduser()->associate($user);

        if($name != null)
        {
            $this->name = $name;
        }

        $settings = Setting::getSettings();

        if ($this->requireAcceptance()) {
            $this->accepted="pending";
        }



        if ($this->save()) {

            // $action, $admin, $user, $expected_checkin = null, $note = null, $checkout_at = null
            $log = $this->createLogRecord('checkout', $this, $admin, $user, $expected_checkin, $note, $checkout_at);

            if ((($this->requireAcceptance()=='1')  || ($this->getEula())) && ($user->email!='')) {
                $this->checkOutNotifyMail($log->id, $user, $checkout_at, $expected_checkin, $note);
            }

            if ($settings->slack_endpoint) {
                $this->checkOutNotifySlack($settings, $admin, $note);
            }
            return true;

        }
        return false;

    }

    public function checkOutNotifyMail($log_id, $user, $checkout_at, $expected_checkin, $note)
    {
        $data['log_id'] = $log_id;
        $data['eula'] = $this->getEula();
        $data['first_name'] = $user->first_name;
        $data['item_name'] = $this->showAssetName();
        $data['checkout_date'] = $checkout_at;
        $data['expected_checkin'] = $expected_checkin;
        $data['item_tag'] = $this->asset_tag;
        $data['note'] = $note;
        $data['item_serial'] = $this->serial;
        $data['require_acceptance'] = $this->requireAcceptance();

        if ((($this->requireAcceptance()=='1')  || ($this->getEula())) && (!config('app.lock_passwords'))) {

            \Mail::send('emails.accept-asset', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                $m->subject(trans('mail.Confirm_asset_delivery'));
            });
        }

    }

    public function checkOutNotifySlack($settings, $admin, $note = null)
    {

        if ($settings->slack_endpoint) {

            $slack_settings = [
            'username' => $settings->botname,
            'channel' => $settings->slack_channel,
            'link_names' => true
            ];

            $client = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);

            try {
                $client->attach([
                'color' => 'good',
                'fields' => [
                [
                  'title' => 'Checked Out:',
                  'value' => 'HARDWARE asset <'.config('app.url').'/hardware/'.$this->id.'/view'.'|'.$this->showAssetName().'> checked out to <'.config('app.url').'/admin/users/'.$this->assigned_to.'/view|'.$this->assigneduser->fullName().'> by <'.config('app.url').'/admin/users/'.Auth::user()->id.'/view'.'|'.$admin->fullName().'>.'
                ],
                [
                    'title' => 'Note:',
                    'value' => e($note)
                ],
                  ]
                ])->send('Asset Checked Out');

            } catch (Exception $e) {
                LOG::error($e);
            }
        }

    }


    public function getDetailedNameAttribute()
    {
        if ($this->assignedUser) {
            $user_name = $this->assignedUser->fullName();
        } else {
            $user_name = "Unassigned";
        }
        return $this->asset_tag . ' - ' . $this->name . ' (' . $user_name . ') ' . $this->model->name;
    }
    public function validationRules($id = '0')
    {
        return $this->rules;
    }


    public function createLogRecord($action, $asset, $admin, $user, $expected_checkin = null, $note = null, $checkout_at = null)
    {

        $logaction = new Actionlog();
        $logaction->item_type = Asset::class;
        $logaction->item_id = $this->id;
        $logaction->target_type = User::class;
        // On Checkin, this is the user that previously had the asset.
        $logaction->target_id = $user->id;
        $logaction->note = $note;
        $logaction->user_id = $admin->id;
        if ($checkout_at!='') {
            $logaction->created_at = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($checkout_at)));
        } else {
            $logaction->created_at = \Carbon\Carbon::now();
        }

        if ($action=="checkout") {
            if ($user) {
                $logaction->location_id = $user->location_id;
            }
        } else {
            // Update the asset data to null, since it's being checked in
            $logaction->location_id = null;
        }
        $logaction->user()->associate($admin);
        $log = $logaction->logaction($action);

        return $logaction;
    }


    /**
   * Set depreciation relationship
   */
    public function depreciation()
    {
        return $this->model->belongsTo('\App\Models\Depreciation', 'depreciation_id');
    }

    /**
     * Get components assigned to this asset
     */
    public function components()
    {
        return $this->belongsToMany('\App\Models\Component', 'components_assets', 'asset_id', 'component_id')->withPivot('id')->withTrashed();
    }

  /**
   * Get depreciation attribute from associated asset model
   */
    public function get_depreciation()
    {
        return $this->model->depreciation;
    }

  /**
   * Get uploads for this asset
   */
    public function uploads()
    {

        return $this->hasMany('\App\Models\Actionlog', 'item_id')
                  ->where('item_type', '=', Asset::class)
                  ->where('action_type', '=', 'uploaded')
                  ->whereNotNull('filename')
                  ->orderBy('created_at', 'desc');
    }

    public function assigneduser()
    {
        return $this->belongsTo('\App\Models\User', 'assigned_to')
                  ->withTrashed();
    }

  /**
   * Get the asset's location based on the assigned user
   **/
    public function assetloc()
    {
        if ($this->assigneduser) {
            return $this->assigneduser->userloc();
        } else {
            return $this->belongsTo('\App\Models\Location', 'rtd_location_id');
        }
    }

  /**
   * Get the asset's location based on default RTD location
   **/
    public function defaultLoc()
    {
        return $this->belongsTo('\App\Models\Location', 'rtd_location_id');
    }

  /**
   * Get action logs for this asset
   */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')
                  ->where('item_type', '=', Asset::class)
                  ->orderBy('created_at', 'desc')
                  ->withTrashed();
    }


  /**
   * assetmaintenances
   * Get improvements for this asset
   *
   * @return mixed
   * @author  Vincent Sposato <vincent.sposato@gmail.com>
   * @version v1.0
   */
    public function assetmaintenances()
    {

        return $this->hasMany('\App\Models\AssetMaintenance', 'asset_id')
                  ->orderBy('created_at', 'desc');
    }

  /**
   * Get action logs for this asset
   */
    public function adminuser()
    {
        return $this->belongsTo('\App\Models\User', 'user_id');
    }

  /**
   * Get total assets
   */
    public static function assetcount()
    {

        return Company::scopeCompanyables(Asset::where('physical', '=', '1'))
               ->whereNull('deleted_at', 'and')
               ->count();
    }

  /**
   * Get total assets not checked out
   */
    public static function availassetcount()
    {

        return Asset::RTD()
                  ->whereNull('deleted_at')
                  ->count();

    }

  /**
   * Get requestable assets
   */
    public static function getRequestable()
    {

        return Asset::Requestable()
                  ->whereNull('deleted_at')
                  ->count();

    }

  /**
   * Get asset status
   */
    public function assetstatus()
    {
        return $this->belongsTo('\App\Models\Statuslabel', 'status_id');
    }

  /**
   * Get name for EULA
   **/
    public function showAssetName()
    {

        if ($this->name == '') {
            if ($this->model) {
                return $this->model->name.' ('.$this->asset_tag.')';
            }
            return $this->asset_tag;
        } else {
            return $this->name;
        }
    }

    public function getDisplayNameAttribute()
    {
        return $this->showAssetName();
    }

    public function warrantee_expires()
    {
        $date = date_create($this->purchase_date);
        date_add($date, date_interval_create_from_date_string($this->warranty_months . ' months'));
        return date_format($date, 'Y-m-d');
    }


    public function model()
    {
        return $this->belongsTo('\App\Models\AssetModel', 'model_id')->withTrashed();
    }

    public static function getExpiringWarrantee($days = 30)
    {

        return Asset::where('archived', '=', '0')
            ->whereNotNull('warranty_months')
            ->whereNotNull('purchase_date')
            ->whereNull('deleted_at')
            ->whereRaw(\DB::raw('DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) <= DATE(NOW() + INTERVAL '
                                 . $days
                                 . ' DAY) AND DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) > NOW()'))
            ->orderBy('purchase_date', 'ASC')
            ->get();
    }

  /**
   * Get the license seat information
   **/
    public function licenses()
    {
        return $this->belongsToMany('\App\Models\License', 'license_seats', 'asset_id', 'license_id');
    }

    public function licenseseats()
    {
        return $this->hasMany('\App\Models\LicenseSeat', 'asset_id');
    }

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }

    public function months_until_eol()
    {

        $today = date("Y-m-d");
        $d1    = new DateTime($today);
        $d2    = new DateTime($this->eol_date());

        if ($this->eol_date() > $today) {
            $interval = $d2->diff($d1);
        } else {
            $interval = null;
        }

        return $interval;
    }

    public function eol_date()
    {

        if (( $this->purchase_date ) && ( $this->model )) {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->model->eol . ' months'));
            return date_format($date, 'Y-m-d');
        }

    }

  /**
   * Get auto-increment
   */
    public static function autoincrement_asset()
    {

        $settings = \App\Models\Setting::getSettings();

        if ($settings->auto_increment_assets == '1') {
            $temp_asset_tag = \DB::table('assets')
                ->where('physical', '=', '1')
                ->max('asset_tag');

            $asset_tag_digits = preg_replace('/\D/', '', $temp_asset_tag);
            $asset_tag = preg_replace('/^0*/', '', $asset_tag_digits);

            if ($settings->zerofill_count > 0) {
                return $settings->auto_increment_prefix.Asset::zerofill(($asset_tag + 1),$settings->zerofill_count);
            }
            return $settings->auto_increment_prefix.($asset_tag + 1);
        } else {
            return false;
        }
    }


    public static function zerofill ($num, $zerofill = 3)
    {
        return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
    }


public function checkin_email()
    {
        return $this->model->category->checkin_email;
    }

    public function requireAcceptance()
    {
        return $this->model->category->require_acceptance;
    }

    public function getEula()
    {

        $Parsedown = new \Parsedown();

        if ($this->model->category->eula_text) {
            return $Parsedown->text(e($this->model->category->eula_text));
        } elseif ($this->model->category->use_default_eula == '1') {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        } else {
            return null;
        }

    }


  /**
   * -----------------------------------------------
   * BEGIN QUERY SCOPES
   * -----------------------------------------------
   **/

  /**
   * Query builder scope for hardware
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeHardware($query)
    {

        return $query->where('physical', '=', '1');
    }

  /**
   * Query builder scope for pending assets
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopePending($query)
    {

        return $query->whereHas('assetstatus', function ($query) {

            $query->where('deployable', '=', 0)
                ->where('pending', '=', 1)
                ->where('archived', '=', 0);
        });
    }


    /**
    * Query builder scope for pending assets
    *
    * @param  Illuminate\Database\Query\Builder $query Query builder instance
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */

    public function scopeAssetsByLocation($query, $location)
    {
        return $query->where(function ($query) use ($location) {

            $query->whereHas('assigneduser', function ($query) use ($location) {

                $query->where('users.location_id', '=', $location->id);
            })->orWhere(function ($query) use ($location) {

                $query->where('assets.rtd_location_id', '=', $location->id);
                $query->whereNull('assets.assigned_to');
            });
        });
    }


    /**
    * Query builder scope for RTD assets
    *
    * @param  Illuminate\Database\Query\Builder $query Query builder instance
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */

    public function scopeRTD($query)
    {

        return $query->whereNULL('assigned_to')
                   ->whereHas('assetstatus', function ($query) {

                       $query->where('deployable', '=', 1)
                             ->where('pending', '=', 0)
                             ->where('archived', '=', 0);
                   });
    }

  /**
   * Query builder scope for Undeployable assets
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeUndeployable($query)
    {

        return $query->whereHas('assetstatus', function ($query) {

            $query->where('deployable', '=', 0)
                ->where('pending', '=', 0)
                ->where('archived', '=', 0);
        });
    }

    /**
     * Query builder scope for non-Archived assets
     *
     * @param  Illuminate\Database\Query\Builder $query Query builder instance
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */

    public function scopeNotArchived($query)
    {

        return $query->whereHas('assetstatus', function ($query) {

            $query->where('archived', '=', 0);
        });
    }

  /**
   * Query builder scope for Archived assets
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeArchived($query)
    {

        return $query->whereHas('assetstatus', function ($query) {

            $query->where('deployable', '=', 0)
                ->where('pending', '=', 0)
                ->where('archived', '=', 1);
        });
    }

  /**
   * Query builder scope for Deployed assets
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeDeployed($query)
    {

        return $query->where('assigned_to', '>', '0');
    }

  /**
   * Query builder scope for Requestable assets
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

    public function scopeRequestableAssets($query)
    {

        return Company::scopeCompanyables($query->where('requestable', '=', 1))
        ->whereHas('assetstatus', function ($query) {

            $query->where('deployable', '=', 1)
                 ->where('pending', '=', 0)
                 ->where('archived', '=', 0);
        });
    }


  /**
  * Query builder scope for Deleted assets
  *
  * @param  Illuminate\Database\Query\Builder $query Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */

    public function scopeDeleted($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    /**
   * scopeInModelList
   * Get all assets in the provided listing of model ids
   *
   * @param       $query
   * @param array $modelIdListing
   *
   * @return mixed
   * @author  Vincent Sposato <vincent.sposato@gmail.com>
   * @version v1.0
   */
    public function scopeInModelList($query, array $modelIdListing)
    {
        return $query->whereIn('model_id', $modelIdListing);
    }

  /**
  * Query builder scope to get not-yet-accepted assets
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeNotYetAccepted($query)
    {
        return $query->where("accepted", "=", "pending");
    }

  /**
  * Query builder scope to get rejected assets
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeRejected($query)
    {
        return $query->where("accepted", "=", "rejected");
    }


  /**
  * Query builder scope to get accepted assets
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeAccepted($query)
    {
        return $query->where("accepted", "=", "accepted");
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
                $query->whereHas('model', function ($query) use ($search) {
                    $query->whereHas('category', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('categories.name', 'LIKE', '%'.$search.'%')
                            ->orWhere('models.name', 'LIKE', '%'.$search.'%')
                            ->orWhere('models.model_number', 'LIKE', '%'.$search.'%');
                        });
                    });
                })->orWhereHas('model', function ($query) use ($search) {
                    $query->whereHas('manufacturer', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('manufacturers.name', 'LIKE', '%'.$search.'%');
                        });
                    });
                })->orWhere(function ($query) use ($search) {
                    $query->whereHas('assetstatus', function ($query) use ($search) {
                        $query->where('status_labels.name', 'LIKE', '%'.$search.'%');
                    });
                })->orWhere(function ($query) use ($search) {
                    $query->whereHas('company', function ($query) use ($search) {
                        $query->where('companies.name', 'LIKE', '%'.$search.'%');
                    });
                })->orWhere(function ($query) use ($search) {
                    $query->whereHas('defaultLoc', function ($query) use ($search) {
                        $query->where('locations.name', 'LIKE', '%'.$search.'%');
                    });
                })->orWhere(function ($query) use ($search) {
                    $query->whereHas('assigneduser', function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            $query->where('users.first_name', 'LIKE', '%'.$search.'%')
                            ->orWhere('users.last_name', 'LIKE', '%'.$search.'%')
                            ->orWhere(function ($query) use ($search) {
                                $query->whereHas('userloc', function ($query) use ($search) {
                                    $query->where('locations.name', 'LIKE', '%'.$search.'%');
                                });
                            });
                        });
                    });
                })->orWhere('assets.name', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.asset_tag', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.serial', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.order_number', 'LIKE', '%'.$search.'%')
                    ->orWhere('assets.notes', 'LIKE', '%'.$search.'%');
            }
            foreach (CustomField::all() as $field) {
                $query->orWhere($field->db_column_name(), 'LIKE', "%$search%");
            }
        });
    }

    /**
    * Query builder scope to order on model
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderModels($query, $order)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')->orderBy('models.name', $order);
    }

    /**
    * Query builder scope to order on model number
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderModelNumber($query, $order)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')->orderBy('models.model_number', $order);
    }


    /**
    * Query builder scope to order on assigned user
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderAssigned($query, $order)
    {
        return $query->leftJoin('users', 'assets.assigned_to', '=', 'users.id')->select('assets.*')->orderBy('users.first_name', $order)->orderBy('users.last_name', $order);
    }

    /**
    * Query builder scope to order on status
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderStatus($query, $order)
    {
        return $query->join('status_labels', 'assets.status_id', '=', 'status_labels.id')->orderBy('status_labels.name', $order);
    }

  /**
    * Query builder scope to order on company
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies', 'assets.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
    }

  /**
  * Query builder scope to order on category
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $order         Order
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
    public function scopeOrderCategory($query, $order)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')
            ->join('categories', 'models.category_id', '=', 'categories.id')
            ->orderBy('categories.name', $order);
    }


    /**
     * Query builder scope to order on manufacturer
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderManufacturer($query, $order)
    {
        return $query->join('models', 'assets.model_id', '=', 'models.id')
            ->join('manufacturers', 'models.manufacturer_id', '=', 'manufacturers.id')
            ->orderBy('manufacturers.name', $order);
    }

  /**
    * Query builder scope to order on location
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
  * TODO: Extend this method out for checked out assets as well. Right now it
  * only checks the location name related to rtd_location_id
    */
    public function scopeOrderLocation($query, $order)
    {
        return $query->join('locations', 'locations.id', '=', 'assets.rtd_location_id')->orderBy('locations.name', $order);
    }
}
