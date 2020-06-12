<?php

namespace App\Models\Traits;

use App\Models\Asset;
use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Component;
use App\Models\InventoryAdjustment;
use App\Models\InventoryTransfer;
use App\Models\InventoryReconcile;
use App\Models\InventoryCount;
use App\Enums\States;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;



trait Inventoryable
{

  public function getDateFormat()
  {
      return 'Y-m-d H:i:s.u';
  }

        /**
    * Helper method to determine the log item type
    */
    public function fillItemType($invItem)
    {
        $invItem['item_type'] = static::class;
        $invItem['item_id'] = $this->id;

        return $invItem;
    }


        /**
    * Helper method to determine the log item type
    */
    public function addItemType($invItem)
    {
        $invItem->item_type = static::class;
        $invItem->item_id = $this->id;

        return $invItem;
    }



    /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v3.4]
     * @return \App\Models\InventoryAdjustment
     */
    public function adjustments()
    {
        return $this->morphMany(InventoryAdjustment::class, 'item');
    }

    // item create adjustment
    public function reconcile($stock_location_id, $state, $qty, $occurred_at = null)
    {
      $item_type = static::class;
      $item_id = $this->id;

      $reconcile = new InventoryReconcile;
      $reconcile->item_type = $item_type;
      $reconcile->item_id = $item_id;
      $reconcile->stock_location_id = $stock_location_id;
      $reconcile->qty = $qty;
      if ($occurred_at) {
        $reconcile->occurred_at = $occurred_at;
      } else {
        $reconcile->occurred_at = \Carbon::now();
      }
      $reconcile->saveAndCount();
    }

    public function itemStockRemainingInLocation($stock_location_id)
    {
      // get last inventory count
      return (new InventoryCount)->lastCount(static::class, $this->id, $stock_location_id, States::IN_STOCK);
    }

    public function itemStockRemaining()
    {
      $wheres = [
        'item_type' => static::class,
        'item_id' => $this->id,
        'state' => States::IN_STOCK
      ];

      $group = [
        'item_type',
        'item_id',
        'state'
      ];

      // get last inventory count
      return (new InventoryCount)->recentQuantitiesByState($group, $wheres)->first()->in_stock;
    }

        /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v4.8]
     */
    public function scopeLocationItems($query, $location_id, $item_type) {
      $query->join('inventory_items_locations', function($join) use ($item_type, $item_id) {
        $join->where('inventory_items_locations.item_type', '=', $item_type);
        $join->where('inventory_items_locations.item_id', '=', $item_id);
        $join->on('inventory_items_locations.stock_location_id', '=', 'locations.id');
      });
    }


    /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v4.8]
     * @return \App\Models\InventoryReconcile
     */
    public function scopeWithQuantityByState($query, $wheres = null, $tableName = null) 
    {
      // determine group based on class?
      $wheres = [];
      $wheres['item_type'] = static::class;
      $sub = (new InventoryCount)->recentQuantitiesByState(['item_type', 'item_id'], $wheres);

      $tableName = $this->getTable();
  
      $query->join(DB::raw("({$sub->toSql()}) AS ss"), function($join) use ($sub, $tableName) {
            $join->on("ss.item_id", '=', "{$tableName}.id")
                 ->addBinding($sub->getBindings());  
                 // bindings for sub-query WHERE added
      });
      //dd($query->toSql());

      return $query;

      /* Laravel 5.6.17 join with subquery method
      $latestPosts = DB::table('posts')
                   ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
                   ->where('is_published', true)
                   ->groupBy('user_id');
      $users = DB::table('users')
      ->joinSub($latestPosts, 'latest_posts', function ($join) {
          $join->on('users.id', '=', 'latest_posts.user_id');
      })->get();
      */
    }

    public function invCheckout($stock_location_id, $quantity, $occurred_at, $from_state = States::IN_STOCK) 
    {
      $adjustment = new InventoryAdjustment;
      $adjustment = $this->addItemType($adjustment);
      $adjustment->stock_location_id = $stock_location_id;
      $adjustment->from_state = $from_state;
      $adjustment->to_state = States::CHECKED_OUT;
      $adjustment->occurred_at = $occurred_at;
      $adjustment->qty = $quantity;
      $savedAdjustment = $adjustment->saveAndCount(true);
    }

    public function invCheckin($stock_location_id, $quantity, $occurred_at, $to_state = States::IN_STOCK) 
    {
      $adjustment = new InventoryAdjustment;
      $adjustment = $this->addItemType($adjustment);
      $adjustment->stock_location_id = $stock_location_id;
      $adjustment->from_state = States::CHECKED_OUT;
      $adjustment->to_state = $to_state;
      $adjustment->occurred_at = $occurred_at;
      $adjustment->qty = $quantity;
      $savedAdjustment = $adjustment->saveAndCount(true);
    }
}
