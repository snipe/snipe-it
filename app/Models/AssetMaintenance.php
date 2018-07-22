<?php
namespace App\Models;

use App\Helpers\Helper;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Asset Maintenances.
 *
 * @version    v1.0
 */
class AssetMaintenance extends Model implements ICompanyableChild
{
    use SoftDeletes;
    use CompanyableChildTrait;
    use ValidatingTrait;


    protected $dates = [ 'deleted_at', 'start_date' , 'completion_date'];
    protected $table = 'asset_maintenances';
    // Declaring rules for form validation
    protected $rules = [
        'asset_id'               => 'required|integer',
        'supplier_id'            => 'required|integer',
        'asset_maintenance_type' => 'required',
        'title'                  => 'required|max:100',
        'is_warranty'            => 'boolean',
        'start_date'             => 'required|date',
        'completion_date'        => 'nullable|date',
        'notes'                  => 'string|nullable',
        'cost'                   => 'numeric|nullable'
    ];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['title', 'notes', 'asset_maintenance_type', 'cost', 'start_date', 'completion_date'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = []; 


    public function getCompanyableParents()
    {
        return [ 'asset' ];
    }

    /**
       * getImprovementOptions
       *
       * @return array
       * @author  Vincent Sposato <vincent.sposato@gmail.com>
       * @version v1.0
       */
    public static function getImprovementOptions()
    {

        return [
            trans('admin/asset_maintenances/general.maintenance') => trans('admin/asset_maintenances/general.maintenance'),
            trans('admin/asset_maintenances/general.repair')      => trans('admin/asset_maintenances/general.repair'),
            trans('admin/asset_maintenances/general.upgrade')     => trans('admin/asset_maintenances/general.upgrade'),
            'PAT test'      => 'PAT test',
        ];
    }

    public function setIsWarrantyAttribute($value)
    {
        if ($value == '') {
            $value = 0;
        }
        $this->attributes['is_warranty'] = $value;
    }

    /**
     * @param $value
     */
    public function setCostAttribute($value)
    {
        $value =  Helper::ParseFloat($value);
        if ($value == '0.0') {
            $value = null;
        }
        $this->attributes['cost'] = $value;
    }

    /**
     * @param $value
     */
    public function setNotesAttribute($value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['notes'] = $value;
    }

    /**
     * @param $value
     */
    public function setCompletionDateAttribute($value)
    {
        if ($value == '' || $value == "0000-00-00") {
            $value = null;
        }
        $this->attributes['completion_date'] = $value;
    }

    /**
       * asset
       * Get asset for this improvement
       *
       * @return mixed
       * @author  Vincent Sposato <vincent.sposato@gmail.com>
       * @version v1.0
       */
    public function asset()
    {

        return $this->belongsTo('\App\Models\Asset', 'asset_id')
                    ->withTrashed();
    }

    /**
     * Get the admin who created the maintenance
     *
     * @return mixed
     * @author  A. Gianotto <snipe@snipe.net>
     * @version v3.0
     */
    public function admin()
    {

        return $this->belongsTo('\App\Models\User', 'user_id')
            ->withTrashed();
    }

    public function supplier()
    {

        return $this->belongsTo('\App\Models\Supplier', 'supplier_id')
                    ->withTrashed();
    }

    /**
   * -----------------------------------------------
   * BEGIN QUERY SCOPES
   * -----------------------------------------------
   **/ 


    /**
     * Query builder scope to order on admin user
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderAdmin($query, $order)
    {
        return $query->leftJoin('users', 'asset_maintenances.user_id', '=', 'users.id')
            ->orderBy('users.first_name', $order)
            ->orderBy('users.last_name', $order);
    }

    /**
     * Query builder scope to order on asset tag
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderByTag($query, $order)
    {
        return $query->leftJoin('assets', 'asset_maintenances.asset_id', '=', 'assets.id')
            ->orderBy('assets.asset_tag', $order);
    }

    /**
     * Query builder scope to order on asset tag
     *
     * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderByAssetName($query, $order)
    {
        return $query->leftJoin('assets', 'asset_maintenances.asset_id', '=', 'assets.id')
            ->orderBy('assets.name', $order);
    }
}
