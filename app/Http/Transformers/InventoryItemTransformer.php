<?php
namespace App\Http\Transformers;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Integer;
use Gate;
use App\Helpers\Helper;

class InventoryItemTransformer
{

    public function transformInventoryItems(Collection $inventory_items, $total)
    {
        $array = array();
        foreach ($inventory_items as $inventory_item) {
            $array[] = self::transformInventoryItem($inventory_item);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
    public function transformInventoryItemsvsAsset(Collection $inventory_items, $total)
    {
        $array = array();
        foreach ($inventory_items as $inventory_item) {
            $array[] = self::transformInventoryItem($inventory_item,true);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }


    public function transformInventoryItem (InventoryItem $inventory_item,$vsAsset = false)
    {

        $array = [
            'id' => (int) $inventory_item->id,
            'notes' => ($inventory_item->notes) ? e($inventory_item->notes) : null,
            'name' => ($inventory_item->name) ? e($inventory_item->name) : null,
            'model' =>  ($inventory_item->model) ? e($inventory_item->model) : null,
            'category' =>  ($inventory_item->category) ? e($inventory_item->category) : null,
            'manufacturer' =>  ($inventory_item->manufacturer) ? e($inventory_item->manufacturer) : null,
            'serial_number' =>  ($inventory_item->serial_number) ? e($inventory_item->serial_number) : null,
            'tag' =>  ($inventory_item->tag) ? e($inventory_item->tag) : null,
            'photo' =>  ($inventory_item->photo) ? e($inventory_item->photo_url()) : null,
            'checked' =>  (bool) $inventory_item->checked,
            'successfully' =>  (bool) $inventory_item->successfully,
            'checked_at' => Helper::getFormattedDateObject($inventory_item->checked_at, 'datetime'),
            'asset_id' =>   (int) $inventory_item->asset_id,
//            'asset' => ($inventory_item->asset_id) ? (new AssetsTransformer)->transformAsset($inventory_item->asset) : null,
            'status' => ($inventory_item->status_id) ? (new InventoryStatuslabelsTransformer())->transformInventoryStatuslabel($inventory_item->status) : null,
            'inventory_id' =>  (int) $inventory_item->inventory_id,
            'created_at' => Helper::getFormattedDateObject($inventory_item->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($inventory_item->updated_at, 'datetime'),
        ];
        if ($vsAsset){
            $array["asset"] = ($inventory_item->asset_id) ? (new AssetsTransformer)->transformAsset($inventory_item->asset) : null;

        }

        return $array;
    }

    public function transformInventoryItemsDatatable($inventory_items) {
        return (new DatatablesTransformer)->transformDatatables($inventory_items);
    }

}
