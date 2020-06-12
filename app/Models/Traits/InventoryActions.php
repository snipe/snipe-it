<?php

namespace App\Models\Traits;

use App\Models\AssetModel;
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



trait InventoryActions
{

      /**
     * Find target for checkout
     * @return SnipeModel   Type for inventory
     */
    protected function determineInventoryItem()
    {
        // This item is checked out to a location
        switch(request('inventory_item_type'))
        {
            case 'accessory':
                return Accessory::find(request('accessory_id'));
            case 'consumable':
                return Consumable::find(request('consumable_id'));
            case 'component':
                return Component::find(request('component_id'));
        }
        return null;
    }

          /**
     * Find target for checkout
     * @return SnipeModel   Type for inventory
     */
    protected function determineTypeClassToName($string)
    {
        // This item is checked out to a location
        switch($string)
        {
            case Accessory::class:
                return 'accessories';
            case Consumable::class:
                return 'consumables';
            case Component::class:
                return 'components';
        }
        return null;
    }

    /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v4.8]
     * @return \App\Models\InventoryTransfer
     */
    public function invTransfer($transfer)
    {
        $transfer = $this->determineItemType($transfer);

        return $transfer;
    }


    /**
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v4.8]
     * @return \App\Models\InventoryReconcile
     */
    /*
    public function invReconcile($location_id, $state, $qty, $occurred_at)
    {
      $reconcile = new InventoryReconcile;
      $reconcile = $this->determineItemType($reconcile);

      $reconcile->location_id = $from_location_id;
      $reconcile->state = $state;
      $reconcile->qty = $qty;
      $reconcile->occurred_at = $occurred_at;

      return $reconcile;
    }
    */



    /**
     * Create an Inventory count for a item, location, state
     * @author  Peter Brink <pbrink231@gmail.com>
     * @since [v4.8]
     * @return \App\Models\InventoryCount
     */
    public function makeInvCount($item_type, $item_id, $stock_location_id, $state)
    {
      $itemInfo = [
        'item_type' => $item_type,
        'item_id'   => $item_id,
        'stock_location_id' => $stock_location_id,
        'state'     => $state
      ];
      if ($itemInfo['state'] == States::NONE) {
        return;
      }

      // update count for state on item
      // find last inventory reconcile
      $reconcile = new InventoryReconcile;
      $foundReconcile = $reconcile->lastReconcile($itemInfo['item_type'], $itemInfo['item_id'], $itemInfo['stock_location_id'], $itemInfo['state']);
      // if no count then use all transactions
      $sinceTime = null;
      $startQty = 0;
      if ($foundReconcile) {
        $startQty = $foundReconcile->qty;
        $sinceTime = $foundReconcile->occurred_at;
      }


      // get all adjustments
      $adjustment_minus = $this->fromAdjustments($itemInfo);
      $adjustment_add = $this->toAdjustments($itemInfo);
      $transfer_minus = 0;
      $transfer_add = 0;

      $newCountQty = $startQty - $adjustment_minus - $transfer_minus + $adjustment_add + $transfer_add;

      $count = new InventoryCount;


      // get invnetory adjustment changes since last count
      // get inventory transfer changes since last count
      // sum and update
      $count->item_type = $itemInfo['item_type'];
      $count->item_id = $itemInfo['item_id'];
      $count->stock_location_id = $itemInfo['stock_location_id'];
      $count->state = $itemInfo['state'];
      $count->qty = $newCountQty;
      $count->occurred_at = \Carbon::now();

      if (!$count->save()) {
        dd($count);
      }
      return;
    }

    public function fromAdjustments($item, $since = null) {
      return (new InventoryAdjustment)::where('item_type', '=', $item['item_type'])
                                      ->where('item_id', '=', $item['item_id'])
                                      ->where('stock_location_id', '=', $item['stock_location_id'])
                                      ->where('from_state', '=', $item['state'])
                                      ->sum('qty');
    }

    public function toAdjustments($item, $since = null) {
      return (new InventoryAdjustment)::where('item_type', '=', $item['item_type'])
                                      ->where('item_id', '=', $item['item_id'])
                                      ->where('stock_location_id', '=', $item['stock_location_id'])
                                      ->where('to_state', '=', $item['state'])
                                      ->sum('qty');
    }
}
