<?php
namespace App\Models;

use App\Models\Loggable;
use App\Models\SnipeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Accessories.
 *
 * @version    v1.0
 */
class Accessory extends SnipeModel
{
    use CompanyableTrait;
    use Loggable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'accessories';

    /**
    * Accessory validation rules
    */
    public $rules = array(
        'name'              => 'required|min:3|max:255',
        'qty'               => 'required|integer|min:1',
        'category_id'       => 'required|integer',
        'company_id'        => 'integer',
        'min_amt'           => 'integer|min:0',
        'purchase_cost'     => 'numeric',
    );


    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','qty','category_id'];

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id')->where('category_type', '=', 'accessory');
    }

    /**
    * Get action logs for this accessory
    */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')->where('item_type', Accessory::class)->orderBy('created_at', 'desc')->withTrashed();
    }


    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'accessories_users', 'accessory_id', 'assigned_to')->withPivot('id')->withTrashed();
    }

    public function hasUsers()
    {
        return $this->belongsToMany('\App\Models\User', 'accessories_users', 'accessory_id', 'assigned_to')->count();
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function checkin_email()
    {
        return $this->category->checkin_email;
    }

    public function requireAcceptance()
    {
        return $this->category->require_acceptance;
    }

    public function getEula()
    {

        $Parsedown = new \Parsedown();

        if ($this->category->eula_text) {
            return $Parsedown->text(e($this->category->eula_text));
        } elseif ((Setting::getSettings()->default_eula_text) && ($this->category->use_default_eula=='1')) {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        } else {
            return null;
        }

    }

    public function numRemaining()
    {
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
        $search = explode('+', $search);

        return $query->where(function ($query) use ($search) {

            foreach ($search as $search) {
                    $query->whereHas('category', function ($query) use ($search) {
                        $query->where('categories.name', 'LIKE', '%'.$search.'%');
                    })->orWhere(function ($query) use ($search) {
                        $query->whereHas('company', function ($query) use ($search) {
                            $query->where('companies.name', 'LIKE', '%'.$search.'%');
                        });
                    })->orWhere(function ($query) use ($search) {
                        $query->whereHas('assetlog', function ($query) use ($search) {
                            $query->where('action_type', '=', 'checkout')
                            ->where('created_at', 'LIKE', '%'.$search.'%');
                        });
                    })->orWhere(function ($query) use ($search) {
                        $query->whereHas('location', function ($query) use ($search) {
                            $query->where('locations.name', 'LIKE', '%'.$search.'%');
                        });
                    })->orWhere('accessories.name', 'LIKE', '%'.$search.'%')
                            ->orWhere('accessories.model_number', 'LIKE', '%'.$search.'%')
                            ->orWhere('accessories.order_number', 'LIKE', '%'.$search.'%')
                            ->orWhere('accessories.purchase_cost', 'LIKE', '%'.$search.'%')
                            ->orWhere('accessories.purchase_date', 'LIKE', '%'.$search.'%');
            }
        });
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
        return $query->leftJoin('companies', 'accessories.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
    }

    /**
    * Query builder scope to order on company
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCategory($query, $order)
    {
        return $query->leftJoin('categories', 'accessories.category_id', '=', 'categories.id')->orderBy('categories.name', $order);
    }

    /**
    * Query builder scope to order on company
    *
    * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations', 'consumables.location_id', '=', 'locations.id')->orderBy('locations.name', $order);
    }
}
