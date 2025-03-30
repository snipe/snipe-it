<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Asset Maintenances.
 *
 * @version    v1.0
 */
class AssetMaintenance extends Model implements ICompanyableChild
{
    use HasFactory;
    use SoftDeletes;
    use CompanyableChildTrait;
    use ValidatingTrait;



    protected $table = 'asset_maintenances';
    protected $rules = [
        'asset_id'               => 'required|integer',
        'supplier_id'            => 'required|integer',
        'asset_maintenance_type' => 'required',
        'title'                  => 'required|max:100',
        'is_warranty'            => 'boolean',
        'start_date'             => 'required|date_format:Y-m-d',
        'completion_date'        => 'date_format:Y-m-d|nullable',
        'notes'                  => 'string|nullable',
        'cost'                   => 'numeric|nullable',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'asset_id',
        'supplier_id',
        'asset_maintenance_type',
        'is_warranty',
        'start_date',
        'completion_date',
        'asset_maintenance_time',
        'notes',
        'cost',
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes =
        [
            'title',
            'notes',
            'asset_maintenance_type',
            'cost',
            'start_date',
            'completion_date'
        ];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'asset'     => ['name', 'asset_tag', 'serial'],
        'asset.model'     => ['name', 'model_number'],
        'asset.supplier' => ['name'],
        'asset.assetstatus' => ['name'],
        'supplier' => ['name'],
    ];

    public function getCompanyableParents()
    {
        return ['asset'];
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
            trans('admin/asset_maintenances/general.pat_test')     => trans('admin/asset_maintenances/general.pat_test'),
            trans('admin/asset_maintenances/general.calibration')     => trans('admin/asset_maintenances/general.calibration'),
            trans('admin/asset_maintenances/general.software_support')      => trans('admin/asset_maintenances/general.software_support'),
            trans('admin/asset_maintenances/general.hardware_support')      => trans('admin/asset_maintenances/general.hardware_support'),
            trans('admin/asset_maintenances/general.configuration_change')     => trans('admin/asset_maintenances/general.configuration_change'),
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
        $value = Helper::ParseCurrency($value);
        if ($value == 0) {
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
        if ($value == '' || $value == '0000-00-00') {
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
        return $this->belongsTo(\App\Models\Asset::class, 'asset_id')
                    ->withTrashed();
    }

    /**
     * Get the admin who created the maintenance
     *
     * @return mixed
     * @author  A. Gianotto <snipe@snipe.net>
     * @version v3.0
     */
    public function adminuser()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by')
            ->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id')
                    ->withTrashed();
    }

    /**
     * -----------------------------------------------
     * BEGIN QUERY SCOPES
     * -----------------------------------------------
     **/

    /**
     * Query builder scope to order on a supplier
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderBySupplier($query, $order)
    {
        return $query->leftJoin('suppliers as suppliers_maintenances', 'asset_maintenances.supplier_id', '=', 'suppliers_maintenances.id')
            ->orderBy('suppliers_maintenances.name', $order);
    }



    /**
     * Query builder scope to order on asset tag
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderByTag($query, $order)
    {
        return $query->leftJoin('assets', 'asset_maintenances.asset_id', '=', 'assets.id')
            ->orderBy('assets.asset_tag', $order);
    }

    /**
     * Query builder scope to order on asset tag
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderByAssetName($query, $order)
    {
        return $query->leftJoin('assets', 'asset_maintenances.asset_id', '=', 'assets.id')
            ->orderBy('assets.name', $order);
    }

    /**
     * Query builder scope to order on serial
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  string                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderByAssetSerial($query, $order)
    {
        return $query->leftJoin('assets', 'asset_maintenances.asset_id', '=', 'assets.id')
            ->orderBy('assets.serial', $order);
    }

    /**
     * Query builder scope to order on status label name
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order         Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    public function scopeOrderStatusName($query, $order)
    {
        return $query->join('assets as maintained_asset', 'asset_maintenances.asset_id', '=', 'maintained_asset.id')
            ->leftjoin('status_labels as maintained_asset_status', 'maintained_asset_status.id', '=', 'maintained_asset.status_id')
            ->orderBy('maintained_asset_status.name', $order);
    }

    /**
     * Query builder scope to order on the user that created it
     */
    public function scopeOrderByCreatedBy($query, $order)
    {
        return $query->leftJoin('users as admin_sort', 'asset_maintenances.created_by', '=', 'admin_sort.id')->select('asset_maintenances.*')->orderBy('admin_sort.first_name', $order)->orderBy('admin_sort.last_name', $order);
    }
}
