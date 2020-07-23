<?php
namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Inventories.
 *
 * @version    v1.8
 */
final class Inventory extends SnipeModel
{
    protected $table = 'inventories';

    protected $presenter = 'App\Presenters\InventoryPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $rules = array(
//        'bitrix_id'        => 'required',
        'responsible_id'        => 'required',
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

    use Searchable;



    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['name', 'created_at', 'updated_at'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'device',
        'responsible_id',
        'responsible',
        'responsible_photo',
        'coords',
        'log',
        'comment',
        'location_id',
        'status'
    ];

    public function responsible_photo_url()
    {
        return '/uploads/inventories/'.$this->responsible_photo;
    }

    public function inventory_items() {
        return $this->hasMany('\App\Models\InventoryItem');
    }
    public function location()
    {
        return $this->belongsTo('\App\Models\Location');
    }
}