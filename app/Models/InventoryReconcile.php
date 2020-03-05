<?php
namespace App\Models;

use App\Enums\States;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;


class InventoryReconcile extends Model
{
    protected $dates = ['occurred_at'];
    protected $table = 'inventory_counts';

    public $rules = array(
        'item_type'         => 'required|string',
        'item_id'           => 'required|integer',
        'state'             => 'required|in:none,in_stock,pending,checked_out,used,waste,lost,ordered_from_supplier,reserved_request',
        'stock_location_id' => 'required|integer',
        'qty'               => 'required|min:1',
        'occurred_at'        => 'required',
    );
    use ValidatingTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item_type', 'item_id', 'state','stock_location_id','qty','occurred_at'];

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

    public function lastReconcile($item_type, $item_id, $stock_location_id, $state)
    {
      return InventoryReconcile::select('s1.id', 's1.item_type', 's1.item_id', 's1.stock_location_id', 's1.state', 's1.occurred_at', 's1.qty')
                                ->from('inventory_reconciles as s1')
                                ->where('item_type', '=', $item_type)
                                ->where('item_id', '=', $item_id)
                                ->where('stock_location_id', '=', $stock_location_id)
                                ->where('state', '=', $state)
                                ->orderBy('s1.occurred_at', 'DESC')
                                ->limit(1)
                                ->first();

    }

    public function lastReconciles($wheres)
    {
      //dd($wheres);
      return InventoryReconcile::select('s1.id', 's1.item_type', 's1.item_id', 's1.stock_location_id', 's1.state', 's1.occurred_at', 's1.qty')
                                ->from('inventory_reconciles as s1')
                                ->join('inventory_reconciles as s2', function($join) use($wheres) {
                                  $join->on('s1.item_type', '=', 's2.item_type');
                                  $join->on('s1.item_id', '=', 's2.item_id');
                                  $join->on('s1.stock_location_id', '=', 's2.stock_location_id');
                                  $join->on('s1.state', '=', 's2.state');
                                  $join->on('s1.occurred_at', '<', 's2.occurred_at');
                                  $join->whereNull('s2.occurred_at');
                                  if ($wheres) {
                                    foreach ($wheres as $key => $value) {
                                      $join->where('s2.'.$key, '=', $value);
                                    }
                                  }
                                });
          

    }
}