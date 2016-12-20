<?php
namespace App\Http\Controllers;

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
    * @return View
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
    * @return View
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
    * @return Redirect
    */
    public function store(Request $request)
    {
        $manufacturer = new Manufacturer;
        $manufacturer->name            = e($request->input('name'));
        $manufacturer->user_id          = Auth::user()->id;

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
    * @return View
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
    * @param int $manufacturerId
    * @since [v1.0]
    * @return View
    */
    public function update(Request $request, $manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return redirect()->route('manufacturers.index')->with('error', trans('admin/manufacturers/message.does_not_exist'));
        }

        // Save the  data
        $manufacturer->name     = e($request->input('name'));
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
    * @return View
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
    * @return View
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
            $actions = '<a href="'.route('manufacturers.edit', $manufacturer->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('manufacturers.destroy', $manufacturer->id).'" data-content="'.trans('admin/manufacturers/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($manufacturer->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'            => $manufacturer->id,
                'name'          => (string)link_to_route('manufacturers.show', e($manufacturer->name),['manufacturer' => $manufacturer->id]),
                'assets'        => $manufacturer->assets()->count(),
                'licenses'      => $manufacturer->licenses()->count(),
                'accessories'   => $manufacturer->accessories()->count(),
                'consumables'   => $manufacturer->consumables()->count(),
                'actions'       => $actions
            );
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

        throw new Exception("We shouldn't be here");

    }

    protected function getDataAssetsView(Manufacturer $manufacturer, Request $request)
    {
        $manufacturer = $manufacturer->load('assets.model', 'assets.assigneduser', 'assets.assetstatus', 'assets.company');
        $manufacturer_assets = $manufacturer->assets;

        if ($request->has('search')) {
            $manufacturer_assets = $manufacturer_assets->TextSearch(e($request->input('search')));
        }

        if ($request->has('offset')) {
            $offset = e($request->input('offset'));
        } else {
            $offset = 0;
        }

        if ($request->has('limit')) {
            $limit = e($request->input('limit'));
        } else {
            $limit = 50;
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $count = $manufacturer_assets->count();

        $rows = array();

        foreach ($manufacturer_assets as $asset) {

            $actions = '';
            if ($asset->deleted_at=='') {
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('clone/hardware', $asset->id).'" class="btn btn-info btn-sm" title="Clone asset"><i class="fa fa-files-o"></i></a> <a href="'.route('hardware.edit', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('hardware.destroy', $asset->id).'" data-content="'.trans('admin/hardware/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($asset->asset_tag).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            } elseif ($asset->deleted_at!='') {
                $actions = '<a href="'.route('restore/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }

            if ($asset->availableForCheckout()) {
                if (Gate::allows('checkout', $asset)) {
                    $inout = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.trans('general.checkout').'</a>';
                }
            } else {
                if (Gate::allows('checkin', $asset)) {
                    $inout = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.trans('general.checkin').'</a>';
                }
            }

            $rows[] = array(
                'id' => $asset->id,
                'name' => (string)link_to_route('hardware.show', e($asset->showAssetName()), [$asset->id]),
                'model' => e($asset->model->name),
                'asset_tag' => e($asset->asset_tag),
                'serial' => e($asset->serial),
                'assigned_to' => ($asset->assigneduser) ? (string)link_to_route('users.show', e($asset->assigneduser->fullName()), [$asset->assigneduser->id]): '',
                'actions' => $actions,
                'companyName' => is_null($asset->company) ? '' : $asset->company->name
                );

            if (isset($inout)) {
                $row['change'] = $inout;
            }
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
            $actions = '<span style="white-space: nowrap;">';

            if (Gate::allows('checkout', \App\Models\License::class)) {
                $actions .= '<a href="' . route('licenses.freecheckout', $license->id)
                . '" class="btn btn-primary btn-sm' . (($license->remaincount() > 0) ? '' : ' disabled') . '" style="margin-right:5px;">' . trans('general.checkout') . '</a> ';
            }

            if (Gate::allows('create', $license)) {
                $actions .= '<a href="' . route('clone/license', $license->id)
                . '" class="btn btn-info btn-sm" style="margin-right:5px;" title="Clone asset"><i class="fa fa-files-o"></i></a>';
            }
            if (Gate::allows('edit', $license)) {
                $actions .= '<a href="' . route('licenses.edit', ['license' => $license->id])
                . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }
            if (Gate::allows('delete', $license)) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'
                 . route('licenses.destroy', $license->id)
                 . '" data-content="' . trans('admin/licenses/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($license->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }
            $actions .='</span>';

            $rows[] = array(
                'id'                => $license->id,
                'name'              => (string) link_to_route('licenses.show', $license->name, [$license->id]),
                'serial'            => (string) link_to_route('licenses.show', mb_strimwidth($license->serial, 0, 50, "..."), [$license->id]),
                'totalSeats'        => $license->licenseSeatCount,
                'remaining'         => $license->remaincount(),
                'license_name'      => e($license->license_name),
                'license_email'     => e($license->license_email),
                'purchase_date'     => ($license->purchase_date) ? $license->purchase_date : '',
                'expiration_date'   => ($license->expiration_date) ? $license->expiration_date : '',
                'purchase_cost'     => ($license->purchase_cost) ? number_format($license->purchase_cost, 2) : '',
                'purchase_order'    => ($license->purchase_order) ? e($license->purchase_order) : '',
                'order_number'      => ($license->order_number) ? e($license->order_number) : '',
                'notes'             => ($license->notes) ? e($license->notes) : '',
                'actions'           => $actions,
                'companyName'       => is_null($license->company) ? '' : e($license->company->name),
                'manufacturer'      => $license->manufacturer ? (string) link_to_route('manufacturers.show', $license->manufacturer->name, [$license->manufacturer_id]) : ''
            );
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
        $accessories = $manufacturer->accessories;

        if ($request->has('search')) {
            $accessories = $accessories->TextSearch(e($request->input('search')));
        }

        if ($request->has('limit')) {
            $limit = e($request->input('limit'));
        } else {
            $limit = 50;
        }

        $accessCount = $accessories->count();

        $rows = array();

        foreach ($accessories as $accessory) {

            $actions = '<nobr>';
            if (Gate::allows('checkout', $accessory)) {
                $actions .= '<a href="' . route('checkout/accessory',
                        $accessory->id) . '" style="margin-right:5px;" class="btn btn-info btn-sm" ' . (($accessory->numRemaining() > 0) ? '' : ' disabled') . '>' . trans('general.checkout') . '</a>';
            }
            if (Gate::allows('update', $accessory)) {
                $actions .= '<a href="' . route('accessories.update',
                        $accessory->id) . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }
            if (Gate::allows('delete', $accessory)) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('accessories.destroy',
                        $accessory->id) . '" data-content="' . trans('admin/accessories/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($accessory->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }
            $actions .= '</nobr>';
            $company = $accessory->company;

            $rows[] = array(
            'name'          => (string)link_to_route('accessories.show', $accessory->name, [$accessory->id]),
            'category'      => ($accessory->category) ? (string)link_to_route('categories.show', $accessory->category->name, [$accessory->category->id]) : '',
            'qty'           => e($accessory->qty),
            'order_number'  => e($accessory->order_number),
            'min_amt'  => e($accessory->min_amt),
            'location'      => ($accessory->location) ? e($accessory->location->name): '',
            'purchase_date' => e($accessory->purchase_date),
            'purchase_cost' => number_format($accessory->purchase_cost, 2),
            'numRemaining'  => $accessory->numRemaining(),
            'actions'       => $actions,
            'companyName'   => is_null($company) ? '' : e($company->name),
            'manufacturer'      => $accessory->manufacturer ? (string) link_to_route('manufacturers.show', $accessory->manufacturer->name, [$accessory->manufacturer_id]) : ''

            );
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
        $consumables = $manufacturer->consumables;

        if ($request->has('search')) {
            $consumables = $consumables->TextSearch(e($request->input('search')));
        }

        if ($request->has('limit')) {
            $limit = e($request->input('limit'));
        } else {
            $limit = 50;
        }

        $consumCount = $consumables->count();

        $rows = array();

        foreach ($consumables as $consumable) {
            $actions = '<nobr>';
            if (Gate::allows('checkout', $consumable)) {
                $actions .= '<a href="' . route('checkout/consumable',
                        $consumable->id) . '" style="margin-right:5px;" class="btn btn-info btn-sm" ' . (($consumable->numRemaining() > 0) ? '' : ' disabled') . '>' . trans('general.checkout') . '</a>';
            }

            if (Gate::allows('update', $consumable)) {
                $actions .= '<a href="' . route('consumables.edit',
                        $consumable->id) . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }
            if (Gate::allows('delete', $consumable)) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('consumables.destroy',
                        $consumable->id) . '" data-content="' . trans('admin/consumables/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($consumable->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }

            $actions .='</nobr>';

            $company = $consumable->company;

            $rows[] = array(
                'id'            => $consumable->id,
                'name'          => (string)link_to_route('consumables.show', e($consumable->name), [$consumable->id]),
                'location'      => ($consumable->location) ? e($consumable->location->name) : '',
                'min_amt'       => e($consumable->min_amt),
                'qty'           => e($consumable->qty),
                'manufacturer'  => ($consumable->manufacturer) ? (string) link_to_route('manufacturers.show', $consumable->manufacturer->name, [$consumable->manufacturer_id]): '',
                'model_number'  => e($consumable->model_number),
                'item_no'       => e($consumable->item_no),
                'category'      => ($consumable->category) ? (string) link_to_route('categories.show', $consumable->category->name, [$consumable->category_id]) : 'Missing category',
                'order_number'  => e($consumable->order_number),
                'purchase_date' => e($consumable->purchase_date),
                'purchase_cost' => ($consumable->purchase_cost!='') ? number_format($consumable->purchase_cost, 2): '' ,
                'numRemaining'  => $consumable->numRemaining(),
                'actions'       => $actions,
                'companyName'   => is_null($company) ? '' : e($company->name),
            );
        }

        $data = array('total' => $consumCount, 'rows' => $rows);

        return $data;
    }
}
