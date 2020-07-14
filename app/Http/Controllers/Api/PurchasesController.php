<?php


namespace App\Http\Controllers\Api;


use App\Http\Transformers\InventoriesTransformer;
use App\Http\Transformers\InventoryItemTransformer;
use App\Http\Transformers\LocationsTransformer;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Statuslabel;
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
        $this->authorize('view', Location::class);

        $purchases = Purchase::with('supplier','assets','invoice_type','legal_person')
            ->select([
                'purchases.id',
                'purchases.invoice_number',
                'purchases.invoice_file',
                'purchases.bitrix_id',
                'purchases.final_price',
                'purchases.status',
                'purchases.supplier_id',
                'purchases.legal_person_id',
                'purchases.invoice_type_id',
                'purchases.comment',
                'purchases.currency',
                'purchases.created_at',
                'purchases.deleted_at',
            ]) ->withCount([
                'assets as assets_count',
            ])
        ;

        if ($request->filled('search')) {
            $purchases = $purchases->TextSearch($request->input('search'));
        }

//        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
//        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
//
//        $purchases->orderBy($sort, $order);
        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($purchases) && ($request->get('offset') > $purchases->count())) ? $purchases->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $total = $purchases->count();
        $purchases = $purchases->skip($offset)->take($limit)->get();
        return (new PurchasesTransformer)->transformPurchases($purchases, $total);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function paid(Request $request, $purchaseId = null)
    {
        $this->authorize('view', Location::class);
        $purchase = Purchase::findOrFail($purchaseId);
        $purchase->status = "paid";
        if ($purchase->save()) {
            $status = Statuslabel::where('name', 'Доступные')->first();
            $assets = Asset::where('purchase_id', $purchase->id)->get();
            foreach ($assets as &$value) {
                $value->status_id  =  $status->id;
                $value->save();
            }
            return response()->json(
                Helper::formatStandardApiResponse(
                    'success',
                    (new PurchasesTransformer)->transformPurchase($purchase),
                    trans('admin/locations/message.update.success')
                )
            );
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $purchase->getErrors()));
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $purchaseId = null)
    {
        $this->authorize('view', Location::class);
        $purchase = Purchase::findOrFail($purchaseId);
        $purchase->status = "rejected";
        if ($purchase->save()) {
            $status = Statuslabel::where('name', 'Отклонено')->first();
            $assets = Asset::where('purchase_id', $purchase->id)->get();
            foreach ($assets as &$value) {
                $value->status_id  =  $status->id;
                $value->save();
            }
            return response()->json(
                Helper::formatStandardApiResponse(
                    'success',
                    (new PurchasesTransformer)->transformPurchase($purchase),
                    trans('admin/locations/message.update.success')
                )
            );
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $purchase->getErrors()));
    }

}