<?php
namespace App\Models;

use App\Enums\States;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;


class InventoryReconcile extends Model
{
    protected $dates = ['occurred_at'];
    protected $table = 'inventory_transfer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item_type', 'item_id', 'state','from_stock_location_id', 'to_stock_location_id','qty','occurred_at','user_id','source_id','reference_id', 'note'];

    /**
     * Inventory polymorphic relationship
     */
    public function item()
    {
        return $this->morphTo('item_type');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}