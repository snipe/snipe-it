<?php
namespace App\Models;


use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for InventoryItems.
 *
 * @version    v1.8
 */
final class InventoryItem extends SnipeModel
{
    protected $table = 'inventory_items';
    protected $presenter = 'App\Presenters\InventoryItemPresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $rules = array(
        'model'        => 'required',
        'tag'        => 'required',
        'category'        => 'required',
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
    protected $fillable = [
        'name',
        'model',
        'category',
        'manufacturer',
        'serial_number',
        'tag',
        'photo',
        'checked',
        'checked_at',
        'inventory_id',
        'status_id',
        'asset_id',
        'notes',
    ];
    public function photo_url()
    {
        return '/uploads/inventory_items/'.$this->photo;
    }
    public function inventory()
    {
        return $this->belongsTo('\App\Models\Inventory');
    }

    public function asset()
    {
        return $this->belongsTo('\App\Models\Asset');
    }
    public function status()
    {
        return $this->belongsTo('\App\Models\InventoryStatuslabel');
    }
}