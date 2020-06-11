<?php


namespace App\Http\Controllers\Api;


use App\Http\Transformers\InventoriesTransformer;
use App\Http\Transformers\InventoryItemTransformer;
use App\Http\Transformers\LocationsTransformer;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\PurchasesTransformer;
use App\Models\Company;
use App\Models\User;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Helpers\Helper;
use App\Http\Requests\SaveUserRequest;
use App\Models\Purchase;
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\AccessoriesTransformer;
use App\Http\Transformers\LicensesTransformer;
use Auth;
use App\Models\AssetModel;
use Illuminate\Database\Eloquent\Builder;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->authorize('view', User::class);

        $purchases = Purchase::with('supplier')
            ->select([
                'purchases.id',
                'purchases.invoice_number',
                'purchases.invoice_file',
                'purchases.bitrix_id',
                'purchases.final_price',
                'purchases.paid',
                'purchases.supplier_id',
                'purchases.comment',
                'purchases.created_at',
                'purchases.deleted_at',
            ])
        ;

        if ($request->filled('search')) {
            $purchases = $purchases->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($purchases) && ($request->get('offset') > $purchases->count())) ? $purchases->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $total = $purchases->count();
        $purchases = $purchases->skip($offset)->take($limit)->get();
        return (new PurchasesTransformer)->transformPurchases($purchases, $total);
    }

}