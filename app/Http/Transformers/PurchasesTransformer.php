<?php
namespace App\Http\Transformers;

use App\Http\Transformers\InventoryItemTransformer;
use App\Http\Transformers\LocationsTransformer;
use App\Http\Transformers\SuppliersTransformer;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Integer;
use Gate;
use App\Helpers\Helper;

class PurchasesTransformer
{

    public function transformPurchases (Collection $purchases, $total)
    {
        $array = array();
        foreach ($purchases as $purchase) {
            $array[] = self::transformPurchase($purchase);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPurchase (Purchase $purchase, $full = false)
    {
        $array = [
            'id' => (int) $purchase->id,
            'invoice_number' =>  ($purchase->invoice_number) ? e($purchase->invoice_number) : null,
            'invoice_file' => ($purchase->getInvoiceFile()) ? $purchase->getInvoiceFile() : null,
            'bitrix_id' =>  ($purchase->bitrix_id) ? e($purchase->bitrix_id) : null,
            'final_price' =>  ($purchase->final_price) ? e($purchase->final_price) : null,
            'paid' =>  ($purchase->paid) ? e($purchase->paid) : null,
            'supplier' => ($purchase->supplier) ? [
                'id' => (int) $purchase->supplier->id,
                'name'=> e($purchase->supplier->name)
            ]  : null,
            'assets_count' => (int) $purchase->assets_count,
            'comment' =>  ($purchase->comment) ? e($purchase->comment) : null,
            'created_at' => Helper::getFormattedDateObject($purchase->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($purchase->updated_at, 'datetime'),
        ];

        return $array;
    }

    public function transformPurchasesDatatable($purchases) {
        return (new DatatablesTransformer)->transformDatatables($purchases);
    }

}
