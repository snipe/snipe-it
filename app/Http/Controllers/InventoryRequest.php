<?php

namespace App\Http\Controllers;

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



trait InventoryRequest
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
}
