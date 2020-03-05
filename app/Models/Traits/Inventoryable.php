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

    /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v4.8]
     * @return \App\Models\InventoryReconcile
     */
    public function scopeWithQuantity($query, $wheres = null, $tableName = null) 
    {
      // determine group based on class?
      $wheres = [];
      $wheres['item_type'] = static::class;
      $sub = (new InventoryCount)->recentQuantitiesByGroup(['item_type', 'item_id'], $wheres);

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

    public function invCheckout($stock_location_id, $quantity, $occurred_at, $from_state, $to_state = States::IN_STOCK) 
    {
      $adjustment = new InventoryAdjustment;
      $adjustment = $this->addItemType($adjustment);
      $adjustment->stock_location_id = $stock_location_id;
      $adjustment->from_state = States::IN_STOCK;
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
      $adjustment->to_state = States::IN_STOCK;
      $adjustment->occurred_at = $occurred_at;
      $adjustment->qty = $quantity;
      $savedAdjustment = $adjustment->saveAndCount(true);
    }
}
