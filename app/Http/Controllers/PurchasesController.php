<?php


namespace App\Http\Controllers;


use App\Http\Requests\FileUploadRequest;
use App\Models\Purchase;
use App\Models\Location;

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
            return view('purchases/view', compact('purchases'));
        }

        return redirect()->route('purchases.index')->with('error', trans('admin/locations/message.does_not_exist'));
    }


    /**
     * Returns a form view used to create a new location.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LocationsController::postCreate() method that validates and stores the data
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
     * @see LocationsController::getCreate() method that makes the form
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

        $purchase = $request->handleFile($purchase, public_path().'/uploads/purchases');

        if ($purchase->save()) {
            return redirect()->route("purchases.index")->with('success', trans('admin/locations/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($purchase->getErrors());
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