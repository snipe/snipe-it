<?php
namespace App\Http\Controllers\Licenses;

use App\Http\Controllers\Controller;
use App\Models\LicenseModel;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * This controller handles all actions related to Licenses for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class LicensesController extends Controller
{

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the licenses listing, which is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LicensesController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', LicenseModel::class);
        return view('licenses/index');
    }


    /**
     * Returns a form view that allows an admin to create a new licence.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see AccessoriesController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', LicenseModel::class);
        $maintained_list = [
            '' => 'Maintained',
            '1' => 'Yes',
            '0' => 'No'
        ];

        return view('licenses/edit')
            ->with('depreciation_list', Helper::depreciationList())
            ->with('maintained_list', $maintained_list)
            ->with('item', new LicenseModel);

    }


    /**
     * Validates and stores the license form data submitted from the new
     * license form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LicensesController::getCreate() method that provides the form view
     * @since [v1.0]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', LicenseModel::class);
        // create a new model instance
        $licenseModel = new LicenseModel();
        // Save the licenseModel data
        $licenseModel->company_id        = Company::getIdForCurrentUser($request->input('company_id'));
        $licenseModel->depreciation_id   = $request->input('depreciation_id');
        $licenseModel->expiration_date   = $request->input('expiration_date');
        $licenseModel->license_email     = $request->input('license_email');
        $licenseModel->license_name      = $request->input('license_name');
        $licenseModel->maintained        = $request->input('maintained', 0);
        $licenseModel->manufacturer_id   = $request->input('manufacturer_id');
        $licenseModel->name              = $request->input('name');
        $licenseModel->notes             = $request->input('notes');
        $licenseModel->order_number      = $request->input('order_number');
        $licenseModel->purchase_cost     = $request->input('purchase_cost');
        $licenseModel->purchase_date     = $request->input('purchase_date');
        $licenseModel->purchase_order    = $request->input('purchase_order');
        $licenseModel->purchase_order    = $request->input('purchase_order');
        $licenseModel->reassignable      = $request->input('reassignable', 0);
        $licenseModel->seats             = $request->input('seats');
        $licenseModel->serial            = $request->input('serial');
        $licenseModel->supplier_id       = $request->input('supplier_id');
        $licenseModel->category_id       = $request->input('category_id');
        $licenseModel->termination_date  = $request->input('termination_date');
        $licenseModel->user_id           = Auth::id();

        if ($licenseModel->save()) {
            return redirect()->route("licenses.index")->with('success', trans('admin/licenses/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($licenseModel->getErrors());
    }

    /**
     * Returns a form with existing license data to allow an admin to
     * update license information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $licenseId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($licenseId = null)
    {
        if (is_null($item = LicenseModel::find($licenseId))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('update', $item);

        $maintained_list = [
            '' => 'Maintained',
            '1' => 'Yes',
            '0' => 'No'
        ];

        return view('licenses/edit', compact('item'))
            ->with('depreciation_list', Helper::depreciationList())
            ->with('maintained_list', $maintained_list);
    }


    /**
     * Validates and stores the license form data submitted from the edit
     * license form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LicensesController::getEdit() method that provides the form view
     * @since [v1.0]
     * @param Request $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $licenseId = null)
    {
        if (is_null($licenseModel = LicenseModel::find($licenseId))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('update', $licenseModel);

        $licenseModel->company_id        = Company::getIdForCurrentUser($request->input('company_id'));
        $licenseModel->depreciation_id   = $request->input('depreciation_id');
        $licenseModel->expiration_date   = $request->input('expiration_date');
        $licenseModel->license_email     = $request->input('license_email');
        $licenseModel->license_name      = $request->input('license_name');
        $licenseModel->maintained        = $request->input('maintained',0);
        $licenseModel->name              = $request->input('name');
        $licenseModel->notes             = $request->input('notes');
        $licenseModel->order_number      = $request->input('order_number');
        $licenseModel->purchase_cost     = $request->input('purchase_cost');
        $licenseModel->purchase_date     = $request->input('purchase_date');
        $licenseModel->purchase_order    = $request->input('purchase_order');
        $licenseModel->reassignable      = $request->input('reassignable', 0);
        $licenseModel->serial            = $request->input('serial');
        $licenseModel->termination_date  = $request->input('termination_date');
        $licenseModel->seats             = e($request->input('seats'));
        $licenseModel->manufacturer_id   =  $request->input('manufacturer_id');
        $licenseModel->supplier_id       = $request->input('supplier_id');
        $licenseModel->category_id       = $request->input('category_id');

        if ($licenseModel->save()) {
            return redirect()->route('licenses.show', ['license' => $licenseId])->with('success', trans('admin/licenses/message.update.success'));
        }
        // If we can't adjust the number of seats, the error is flashed to the session by the event handler in LicenseModelModel.php
        return redirect()->back()->withInput()->withErrors($licenseModel->getErrors());
    }

    /**
     * Checks to see whether the selected license can be deleted, and
     * if it can, marks it as deleted.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($licenseId)
    {
        // Check if the licenseModel exists
        if (is_null($licenseModel = LicenseModel::find($licenseId))) {
            // Redirect to the licenseModel management page
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('delete', $licenseModel);

        if ($licenseModel->assigned_license_count == 0) {
            // Delete the licenseModel and the associated licenseModel seats
            DB::table('license_seats')
                ->where('id', $licenseModel->id)
                ->update(array('assigned_to' => null,'asset_id' => null));

            $licenses = $licenseModel->licenses();
            $licenses->delete();
            $licenseModel->delete();

            // Redirect to the licenses management page
            return redirect()->route('licenses.index')->with('success', trans('admin/licenses/message.delete.success'));
            // Redirect to the licenseModel management page
        }
        // There are still licenses in use.
        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.assoc_users'));

    }


    /**
     * Makes the license detail page.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $licenseId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($licenseId = null)
    {

        $licenseModel = LicenseModel::with('assignedusers', 'licenses.user', 'licenses.asset')->find($licenseId);

        if ($licenseModel) {
            $this->authorize('view', $licenseModel);
            return view('licenses/view', compact('licenseModel'));
        }
        return redirect()->route('licenses.index')
            ->with('error', trans('admin/licenses/message.does_not_exist'));
    }
    

    public function getClone($licenseId = null)
    {
        if (is_null($license_to_clone = LicenseModel::find($licenseId))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('create', LicenseModel::class);

        $maintained_list = [
            '' => 'Maintained',
            '1' => 'Yes',
            '0' => 'No'
        ];
        //clone the orig
        $licenseModel = clone $license_to_clone;
        $licenseModel->id = null;
        $licenseModel->serial = null;

        // Show the page
        return view('licenses/edit')
        ->with('depreciation_list', Helper::depreciationList())
        ->with('item', $licenseModel)
        ->with('maintained_list', $maintained_list);
    }
}
