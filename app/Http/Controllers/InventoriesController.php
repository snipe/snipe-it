<?php
namespace App\Http\Controllers;


use App\Http\Transformers\ImportsTransformer;
use App\Models\Import;
use App\Models\Inventory;

class InventoriesController extends Controller
{
    public function index()
    {
//        $this->authorize('import');
        return view('inventories/index');
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
    public function show($inventoryId = null)
    {
        $inventory = Inventory::find($inventoryId);

        if (isset($inventory->id)) {
            return view('inventories/view', compact('inventory'));
        }

        return redirect()->route('inventory.index')->with('error', trans('admin/locations/message.does_not_exist'));
    }
}