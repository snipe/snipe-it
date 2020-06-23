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
        // Grab all the locations
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
        $this->authorize('create', Purchase::class);
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
//        $this->authorize('create', Location::class);
        $purchase = new Purchase();
        $purchase->invoice_number      = $request->input('invoice_number');
        $purchase->final_price         = $request->input('final_price');
        $purchase->supplier_id         = $request->input('supplier_id');
        $purchase->comment             = $request->input('comment');
        $assets             = json_decode($request->input('assets'), true);
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
            foreach ($assets as &$value) {
                $model_id = $value["model_id"];
                $purchase_cost = $value["purchase_cost"];
                $nds = $value["nds"];
                $warranty = $value["warranty"];
                $quantity = $value["quantity"];
                $dt = new DateTime();
                $id = Asset::autoincrement_asset();
                for ($i = 1; $i <= $quantity; $i++) {
                    $asset = new Asset();
                    $asset->model()->associate(AssetModel::find((int) $model_id));
                    $asset->asset_tag               =  $id;
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
                    if($asset->save()){
                        $id++;
                    }else{
                        dd($asset);
                        dd($asset->getErrors());
                    }
                }
            }

            return redirect()->route("purchases.index")->with('success', trans('admin/locations/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($purchase->getErrors());
    }


    public function sendInvoice(Purchase $purchase){
        /** @var \GuzzleHttp\Client $client */
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://bitrixdev.legis-s.ru/rest/1/lp06vc4xgkxjbo3t/lists.element.add.json/?select%5B0%5D=UF_*&select%5B1%5D=*');
        $response = $response->getBody()->getContents();
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
//        $this->authorize('update', Location::class);
        // Check if the location exists
        if (is_null($item = Purchase::find($purchaseId))) {
            return redirect()->route('purchases.index')->with('error', trans('admin/locations/message.does_not_exist'));
        }


        return view('purchases/edit', compact('item'));
    }



}