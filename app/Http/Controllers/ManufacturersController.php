<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\CustomField;
use App\Models\Manufacturer;
use Auth;
use Exception;
use Gate;
use Input;
use Lang;
use Redirect;
use Str;
use View;
use Illuminate\Http\Request;

/**
 * This controller handles all actions related to Manufacturers for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ManufacturersController extends Controller
{
    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the manufacturers listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Show the page
        return View::make('manufacturers/index', compact('manufacturers'));
    }


    /**
    * Returns a view that displays a form to create a new manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::postCreate()
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('manufacturers/edit')->with('item', new Manufacturer);
    }


    /**
     * Validates and stores the data for a new manufacturer.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ManufacturersController::postCreate()
     * @since [v1.0]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $manufacturer = new Manufacturer;
        $manufacturer->name            = $request->input('name');
        $manufacturer->user_id          = Auth::id();

        if ($manufacturer->save()) {
            return redirect()->route('manufacturers.index')->with('success', trans('admin/manufacturers/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($manufacturer->getErrors());
    }

    /**
    * Returns a view that displays a form to edit a manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::postEdit()
    * @param int $manufacturerId
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($item = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return redirect()->route('manufacturers.index')->with('error', trans('admin/manufacturers/message.does_not_exist'));
        }
        // Show the page
        return View::make('manufacturers/edit', compact('item'));
    }


    /**
     * Validates and stores the updated manufacturer data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ManufacturersController::getEdit()
     * @param Request $request
     * @param int $manufacturerId
     * @return \Illuminate\Http\RedirectResponse
     * @since [v1.0]
     */
    public function update(Request $request, $manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return redirect()->route('manufacturers.index')->with('error', trans('admin/manufacturers/message.does_not_exist'));
        }

        // Save the  data
        $manufacturer->name     = $request->input('name');
        // Was it created?
        if ($manufacturer->save()) {
            // Redirect to the new manufacturer page
            return redirect()->route('manufacturers.index')->with('success', trans('admin/manufacturers/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($manufacturer->getErrors());
    }

    /**
    * Deletes a manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $manufacturerId
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($manufacturerId)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturers page
            return redirect()->route('manufacturers.index')->with('error', trans('admin/manufacturers/message.not_found'));
        }

        if ($manufacturer->has_models() > 0) {
            // Redirect to the asset management page
            return redirect()->route('manufacturers.index')->with('error', trans('admin/manufacturers/message.assoc_users'));
        }
        // Delete the manufacturer
        $manufacturer->delete();
        // Redirect to the manufacturers management page
        return redirect()->route('manufacturers.index')->with('success', trans('admin/manufacturers/message.delete.success'));
    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the manufacturers detail listing, which is generated in getDatatable.
    * This data contains a listing of all assets that belong to that manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getDataView()
    * @param int $manufacturerId
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($manufacturerId = null)
    {
        $manufacturer = Manufacturer::find($manufacturerId);

        if (isset($manufacturer->id)) {
            return View::make('manufacturers/view', compact('manufacturer'));
        }
        // Prepare the error message
        $error = trans('admin/manufacturers/message.does_not_exist', compact('id'));
        // Redirect to the user management page
        return redirect()->route('manufacturers')->with('error', $error);
    }

    /**
     * Generates the JSON used to display the manufacturer listings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ManufacturersController::getIndex()
     * @since [v1.0]
     * @param Request $request
     * @return String JSON
     */
    public function getDatatable(Request $request)
    {
        $manufacturers = Manufacturer::select(array('id','name'))->whereNull('deleted_at');

        if ($request->has('search')) {
            $manufacturers = $manufacturers->TextSearch(e($request->input('search')));
        }
        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        $manufacturers->orderBy($sort, $order);

        $manufacturersCount = $manufacturers->count();
        $manufacturers = $manufacturers->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($manufacturers as $manufacturer) {
            $rows[] = $manufacturer->present()->forDataTable();
        }

        $data = array('total' => $manufacturersCount, 'rows' => $rows);

        return $data;

    }


    /**
     * Generates the JSON used to display the manufacturer detail.
     * This JSON returns data on all of the assets with the specified
     * manufacturer ID number.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ManufacturersController::getView()
     * @param int $manufacturerId
     * @param string $itemType
     * @param Request $request
     * @return String JSON* @since [v1.0]
     */
    public function getDataView($manufacturerId, $itemType = null, Request $request)
    {
        $manufacturer = Manufacturer::find($manufacturerId);

        switch ($itemType) {
            case "assets":
                return $this->getDataAssetsView($manufacturer, $request);
            case "licenses":
                return $this->getDataLicensesView($manufacturer, $request);
            case "accessories":
                return $this->getDataAccessoriesView($manufacturer, $request);
            case "consumables":
                return $this->getDataConsumablesView($manufacturer, $request);
        }

        return "We shouldn't be here";

    }

    protected function getDataAssetsView(Manufacturer $manufacturer, Request $request)
    {
        $manufacturer = $manufacturer->load('assets.model', 'assets.assigneduser', 'assets.assetstatus', 'assets.company');
        $manufacturer_assets = $manufacturer->assets();

        if ($request->has('search')) {
            $manufacturer_assets = $manufacturer_assets->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $count = $manufacturer_assets->count();
        $manufacturer_assets = $manufacturer_assets->skip($offset)->take($limit)->get();
        $rows = array();
        $all_custom_fields = CustomField::all(); // cached;
        foreach ($manufacturer_assets as $asset) {
            $rows[] = $asset->present()->forDataTable($all_custom_fields);
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }

    protected function getDataLicensesView(Manufacturer $manufacturer, Request $request)
    {
        $manufacturer = $manufacturer->load('licenses.company', 'licenses.manufacturer', 'licenses.licenseSeatsRelation');
        $licenses = $manufacturer->licenses;

        if ($request->has('search')) {
            $licenses = $licenses->TextSearch($request->input('search'));
        }

        $licenseCount = $licenses->count();

        $rows = array();

        foreach ($licenses as $license) {
            $rows[] = $license->present()->forDataTable();
        }

        $data = array('total' => $licenseCount, 'rows' => $rows);

        return $data;
    }

    public function getDataAccessoriesView(Manufacturer $manufacturer, Request $request)
    {
        $manufacturer = $manufacturer->load(
            'accessories.location',
            'accessories.company',
            'accessories.category',
            'accessories.manufacturer',
            'accessories.users'
            );
        $accessories = $manufacturer->accessories();

        if ($request->has('search')) {
            $accessories = $accessories->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $accessCount = $accessories->count();
        $accessories = $accessories->skip($offset)->take($limit)->get();
        $rows = array();

        foreach ($accessories as $accessory) {
            $rows[] = $accessory->present()->forDataTable();
        }

        $data = array('total'=>$accessCount, 'rows'=>$rows);

        return $data;
    }

    public function getDataConsumablesView($manufacturer, Request $request)
    {
        $manufacturer = $manufacturer->load(
            'consumables.location',
            'consumables.company',
            'consumables.category',
            'consumables.manufacturer',
            'consumables.users'
        );
        $consumables = $manufacturer->consumables();

        if ($request->has('search')) {
            $consumables = $consumables->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);


        $consumCount = $consumables->count();
        $consumables = $consumables->skip($offset)->take($limit)->get();
        $rows = array();

        foreach ($consumables as $consumable) {
            $rows[] = $consumable->present()->forDataTable();
        }

        $data = array('total' => $consumCount, 'rows' => $rows);

        return $data;
    }
}
