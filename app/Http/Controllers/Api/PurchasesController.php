<?php


namespace App\Http\Controllers\Api;


use App\Http\Transformers\InventoriesTransformer;
use App\Http\Transformers\InventoryItemTransformer;
use App\Http\Transformers\LocationsTransformer;
use App\Models\Asset;
use App\Models\Consumable;
use App\Models\Location;
use App\Models\Statuslabel;
use DateTime;
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

        $purchases = Purchase::with('supplier', 'assets', 'invoice_type', 'legal_person','user')
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
                'purchases.user_id',
                'purchases.created_at',
                'purchases.deleted_at',
            ])->withCount([
                'assets as assets_count',
            ]);

        if ($request->filled('search')) {
            $purchases = $purchases->TextSearch($request->input('search'));
        }

        $allowed_columns =
            [
                'id', 'invoice_number', 'bitrix_id', 'final_price', 'status', 'created_at',
                'deleted_at'
            ];


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        $purchases->orderBy($sort, $order);
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
        $purchase->bitrix_result_at = new DateTime();
        if ($purchase->save()) {
            $assets = Asset::where('purchase_id', $purchase->id)->get();
            if (count($assets) > 0) {
                $status = Statuslabel::where('name', 'Доступные')->first();
//                $status = Statuslabel::where('name', 'Ожидает инвентаризации')->first();
                foreach ($assets as &$value) {
                    $value->status_id = $status->id;
                    $value->save();
                }
            }
            $consumables_server = Consumable::where('purchase_id', $purchase->id)->get();
            $consumables = json_decode($purchase->consumables_json, true);
            if ($purchase->consumables_json != null && count($consumables) > 0 && count($consumables_server) == 0) {
                foreach ($consumables as &$consumable_new) {
                    $consumable_server = new Consumable();
                    $consumable_server->name = $consumable_new["name"];
                    $consumable_server->category_id = $consumable_new["category_id"];
//                    $consumable_server->location_id = 1;
//                    $consumable_server->company_id = $consumable_new["company_id"];
                    $consumable_server->order_number = $purchase->id;
                    $consumable_server->manufacturer_id = $consumable_new["manufacturer_id"];
                    $consumable_server->model_number = $consumable_new["model_number"];
                    $consumable_server->purchase_date = $purchase->created_at;
                    $consumable_server->purchase_cost = Helper::ParseFloat($consumable_new["purchase_cost"]);
                    $consumable_server->qty = Helper::ParseFloat($consumable_new["quantity"]);
                    $consumable_server->purchase_id = $purchase->id;
                    $consumable_server->save();
                }
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
        $purchase->bitrix_result_at =new DateTime();
        if ($purchase->save()) {
            $status = Statuslabel::where('name', 'Отклонено')->first();
            $assets = Asset::where('purchase_id', $purchase->id)->get();
            foreach ($assets as &$value) {
                $value->status_id = $status->id;
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
    public function resend(Request $request, $purchaseId = null)
    {
        $this->authorize('view', Location::class);
        $purchase = Purchase::findOrFail($purchaseId);

        $params_json = $purchase->bitrix_send_json;
        $params = json_decode($params_json, true);
        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();
//        $response = $client->request('POST', 'https://bitrixdev.legis-s.ru/rest/1/lp06vc4xgkxjbo3t/lists.element.add.json/',$params);
        $response = $client->request('POST', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/lists.element.add.json/', $params);
        $response = $response->getBody()->getContents();
        $bitrix_result = json_decode($response, true);
        $bitrix_id = $bitrix_result["result"];
        $purchase->bitrix_id = $bitrix_id;


        if ($purchase->save()) {
            return "ok";
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $purchase->getErrors()));
    }

}