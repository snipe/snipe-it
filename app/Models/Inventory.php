<?php
namespace App\Models;

use App\Models\Traits\InventoryActions;
use App\Enums\States;
use App\Enums\AssetTypes;
use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use DB;



class Inventory extends Model
{
    protected $table = 'inventory_items_locations';

    public $rules = array(
        'item_type'         => 'required|string',
        'item_id'           => 'required|integer',
        'stock_location_id' => 'required|integer',
        'min_amt'           => 'nullable|integer',
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item_type', 'item_id', 'stock_location_id', 'min_amt'];

    /**
     * Inventory polymorphic relationship
     */
    public function item()
    {
        return $this->morphTo();
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'stock_location_id');
    }

    public function quantities()
    {
      $sub = (new InventoryCount)->recentQuantitiesByState(['stock_location_id'], $wheres);
      //dd($sub->get());

      $tableName = $this->getTable();
      //dd($tableName);
  
      $query->leftJoin(DB::raw("({$sub->toSql()}) AS ss"), function($join) use ($sub, $tableName) {
            $join->on("ss.stock_location_id", '=', "{$tableName}.id")
                  ->addBinding($sub->getBindings());  
                  // bindings for sub-query WHERE added
      });

      return $query;
    }

    /**
     * Get all of the owning commentable models.
     */
    public function inventoriable()
    {
        return $this->morphTo();
    }
}