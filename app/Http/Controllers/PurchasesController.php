<?php


namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FileUploadRequest;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Purchase;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

class PurchasesController extends Controller
{
    public function index()
    {
        // Grab all the locations
        $this->authorize('view', Location::class);
       return view('purchases/index');
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the locations detail page.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $inventoryId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function show($purchaseId = null)
    {
        $this->authorize('view', Location::class);

        $purchase = Purchase::find($purchaseId);

        if (isset($purchase->id)) {
            return view('purchases/view', compact('purchase'));
        }

        return redirect()->route('purchases.index')->with('error', trans('admin/locations/message.does_not_exist'));
    }


    /**
     * Returns a form view used to create a new location.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PurchasesController::postCreate() method that validates and stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('view', Location::class);
        return view('purchases/edit')
            ->with('item', new Purchase);
    }

    /**
     * Validates and stores a new location.
     *
     * @todo Check if a Form Request would work better here.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see PurchasesController::getCreate() method that makes the form
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FileUploadRequest $request)
    {
        $this->authorize('view', Location::class);
        $purchase = new Purchase();
        $purchase->invoice_number      = $request->input('invoice_number');
        $purchase->final_price         = $request->input('final_price');
        $purchase->supplier_id         = $request->input('supplier_id');
        $purchase->legal_person_id     = $request->input('legal_person_id');
        $purchase->invoice_type_id     = $request->input('invoice_type_id');
        $purchase->comment             = $request->input('comment');
        $currency_id = $request->input('currency_id');

        switch ($currency_id) {
            case 341:
                $purchase->currency = "руб";
                break;
            case 342:
                $purchase->currency = "usd";
                break;
            case 343:
                $purchase->currency = "eur";
                break;
        }
        $assets = json_decode($request->input('assets'), true);
        $purchase = $request->handleFile($purchase, public_path().'/uploads/purchases');
        $status = Statuslabel::updateOrCreate(
            ['name' =>"В закупке"],
            [
                'pending' => 1,
                'deployable' => 0,
                'archived' => 0,
            ]
        );

        if ($purchase->save()) {
            $asset_tag = Asset::autoincrement_asset();
            $data_list = "";
            foreach ($assets as &$value) {
                $model= $value["model"];
                $model_id = $value["model_id"];
                $purchase_cost = $value["purchase_cost"];
                $nds = $value["nds"];
                $warranty = $value["warranty"];
                $quantity = $value["quantity"];
                $data_list .= "[".$value["id"]."] ".$model." - Количество: ".$quantity." Цена: ".$purchase_cost."\n";

                $dt = new DateTime();
                for ($i = 1; $i <= $quantity; $i++) {
                    $asset = new Asset();
                    $asset->model()->associate(AssetModel::find((int) $model_id));
                    $asset->asset_tag               = $asset_tag;
                    $asset->model_id                = $model_id;
                    $asset->order_number            = $purchase->invoice_number;
                    $asset->archived                = '0';
                    $asset->physical                = '1';
                    $asset->depreciate              = '0';
                    $asset->status_id               = $status->id;
                    $asset->warranty_months         = $warranty;
                    $asset->purchase_cost           = $purchase_cost;
                    $asset->nds                     = $nds;
                    $asset->purchase_date           = $dt->format('Y-m-d H:i:s');
                    $asset->supplier_id             = $purchase->supplier_id;
                    $asset->purchase_id             = $purchase->id;
                    $asset->user_id                 = Auth::id();
                    $settings = \App\Models\Setting::getSettings();
                    if($asset->save()){
                        if ($settings->zerofill_count > 0) {
                            $asset_tag_digits = preg_replace('/\D/', '', $asset_tag);
                            $asset_tag = preg_replace('/^0*/', '', $asset_tag_digits);
                            $asset_tag++;
                            $asset_tag =  $settings->auto_increment_prefix.Asset::zerofill($asset_tag, $settings->zerofill_count);
                        }else{
                            $asset_tag = $settings->auto_increment_prefix.$asset_tag;
                        }
                    }else{
                        dd($asset->getErrors());
                    }
                }
            }

            $file_data = file_get_contents(public_path().'/uploads/purchases/'.$purchase->invoice_file);

// Encode the image string data into base64
            $file_data_base64 = base64_encode($file_data);

            $user = User::find($asset->user_id);
            /** @var \GuzzleHttp\Client $client */
            $client = new \GuzzleHttp\Client();
            $params = [
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
                'form_params' => [
                    "IBLOCK_TYPE_ID" => "lists",
                    "IBLOCK_ID" => 52,
                    "ELEMENT_CODE" =>"warehouse_buy_".$purchase->id,
                    "FIELDS[NAME]" => $purchase->invoice_number,
                    "FIELDS[CREATED_BY]" => $user->bitrix_id,
                    "FIELDS[PROPERTY_758]" => $purchase->invoice_type->bitrix_id, // тип платежа
                    "FIELDS[PROPERTY_141]" => $purchase->comment , //описание
                    "FIELDS[PROPERTY_142]" => $purchase->final_price , //сумма
                    "FIELDS[PROPERTY_156]" => $currency_id , //валюта
                    "FIELDS[PROPERTY_790]" => $purchase->legal_person->bitrix_id , //Юр. лицо
                    "FIELDS[PROPERTY_158]" => $purchase->supplier->name , //Поставщик название
                    "FIELDS[PROPERTY_824]" => $purchase->supplier->bitrix_id , //Поставщик bitrix_id
                    "FIELDS[PROPERTY_143][0]" => $purchase->invoice_file , //файл имя
                    "FIELDS[PROPERTY_143][1]" => $file_data_base64 , //файл base64
//                    "FIELDS[PROPERTY_1122]" => $data_list , // что покупаем
//                    "FIELDS[PROPERTY_1123]" => $purchase->id."" , //id заказа
//                    "FIELDS[PROPERTY_1121]" => "1" , //покупка из системы
                    "FIELDS[PROPERTY_1127]" => $data_list , // что покупаем
                    "FIELDS[PROPERTY_1128]" => $purchase->id."" , //id заказа
                    "FIELDS[PROPERTY_1120]" => "1" , //покупка из системы

                    //2. На боевом есть еще одно поле PROPERTY_1120=Y - надо передать любое значение, означает что создана из snipe_it
                ]
            ];
//            $response = $client->request('POST', 'https://bitrixdev.legis-s.ru/rest/1/lp06vc4xgkxjbo3t/lists.element.add.json/',$params);
            $response = $client->request('POST', 'https://bitrix.legis-s.ru/rest/1/rzrrat22t46msv7v/lists.element.add.json/',$params);
            $response = $response->getBody()->getContents();
            $bitrix_result = json_decode($response, true);
            $bitrix_id = $bitrix_result["result"];
            $purchase->bitrix_id = $bitrix_id;
            $purchase->save();
            return redirect()->route("purchases.index")->with('success', trans('admin/locations/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($purchase->getErrors());
    }


    public function sendInvoice(Purchase $purchase, $currency_id, $data){
    }

    /**
     * Makes a form view to edit location information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LocationsController::postCreate() method that validates and stores
     * @param int $purchaseId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($purchaseId = null)
    {
        $this->authorize('view', Location::class);
        // Check if the location exists
        if (is_null($item = Purchase::find($purchaseId))) {
            return redirect()->route('purchases.index')->with('error', trans('admin/locations/message.does_not_exist'));
        }


        return view('purchases/edit', compact('item'));
    }



}