<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Component;
use App\Models\Setting;
use App\Models\User;
use App\Models\Asset;
use Auth;
use Config;
use DB;
use Input;
use Lang;
use Mail;
use Redirect;
use Slack;
use Str;
use View;
use Validator;
use Illuminate\Http\Request;
use Gate;

/**
 * This class controls all actions related to Components for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ComponentsController extends Controller
{
    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the components listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getDatatable() method that generates the JSON response
    * @since [v3.0]
    * @return View
    */
    public function getIndex()
    {
        return View::make('components/index');
    }


    /**
    * Returns a form to create a new component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::postCreate() method that stores the data
    * @since [v3.0]
    * @return View
    */
    public function getCreate()
    {
        // Show the page
        $category_list = Helper::categoryList('component');
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();

        return View::make('components/edit')
            ->with('item', new Component)
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list);
    }


    /**
    * Validate and store data for new component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getCreate() method that generates the view
    * @since [v3.0]
    * @return Redirect
    */
    public function postCreate()
    {

        // create a new model instance
        $component = new Component();

        // Update the component data
        $component->name                   = e(Input::get('name'));
        $component->category_id            = e(Input::get('category_id'));
        $component->location_id            = e(Input::get('location_id'));
        $component->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $component->order_number           = e(Input::get('order_number'));
        $component->min_amt                = e(Input::get('min_amt'));
        $component->serial                 = e(Input::get('serial'));

        if (e(Input::get('purchase_date')) == '') {
            $component->purchase_date       =  null;
        } else {
            $component->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $component->purchase_cost       =  null;
        } else {
            $component->purchase_cost       = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        $component->qty                    = e(Input::get('qty'));
        $component->user_id                = Auth::user()->id;

        // Was the component created?
        if ($component->save()) {
            $component->logCreate();
            // Redirect to the new component  page
            return redirect()->to("admin/components")->with('success', trans('admin/components/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($component->getErrors());


    }

    /**
    * Return a view to edit a component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::postEdit() method that stores the data.
    * @since [v3.0]
    * @param int $componentId
    * @return View
    */
    public function getEdit($componentId = null)
    {
        // Check if the component exists
        if (is_null($item = Component::find($componentId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/components')->with('error', trans('admin/components/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }

        $category_list =  Helper::categoryList('component');
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();

        return View::make('components/edit', compact('item'))
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list);
    }


    /**
    * Return a view to edit a component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getEdit() method presents the form.
    * @param int $componentId
    * @since [v3.0]
    * @return Redirect
    */
    public function postEdit($componentId = null)
    {
        // Check if the blog post exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/components')->with('error', trans('admin/components/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }


        // Update the component data
        $component->name                   = e(Input::get('name'));
        $component->category_id            = e(Input::get('category_id'));
        $component->location_id            = e(Input::get('location_id'));
        $component->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $component->order_number           = e(Input::get('order_number'));
        $component->min_amt                = e(Input::get('min_amt'));
        $component->serial                 = e(Input::get('serial'));

        if (e(Input::get('purchase_date')) == '') {
            $component->purchase_date       =  null;
        } else {
            $component->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $component->purchase_cost       =  null;
        } else {
            $component->purchase_cost       = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        $component->qty                    = e(Input::get('qty'));

        // Was the component created?
        if ($component->save()) {
            // Redirect to the new component page
            return redirect()->to("admin/components")->with('success', trans('admin/components/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($component->getErrors());




    }

    /**
    * Delete a component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v3.0]
    * @param int $componentId
    * @return Redirect
    */
    public function getDelete($componentId)
    {
        // Check if the blog post exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/components')->with('error', trans('admin/components/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }

            $component->delete();

            // Redirect to the locations management page
            return redirect()->to('admin/components')->with('success', trans('admin/components/message.delete.success'));

    }

    public function postBulk($componentId = null)
    {
        echo 'Stubbed - not yet complete';
    }

    public function postBulkSave($componentId = null)
    {
        echo 'Stubbed - not yet complete';
    }


    /**
    * Return a view to display component information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getDataView() method that generates the JSON response
    * @since [v3.0]
    * @param int $componentId
    * @return View
    */
    public function getView($componentId = null)
    {
        $component = Component::find($componentId);

        if (isset($component->id)) {


            if (!Company::isCurrentUserHasAccess($component)) {
                return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
            } else {
                return View::make('components/view', compact('component'));
            }
        } else {
            // Prepare the error message
            $error = trans('admin/components/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('components')->with('error', $error);
        }


    }

    /**
    * Returns a view that allows the checkout of a component to an asset.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::postCheckout() method that stores the data.
    * @since [v3.0]
    * @param int $componentId
    * @return View
    */
    public function getCheckout($componentId)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return redirect()->to('components')->with('error', trans('admin/components/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }

        // Get the dropdown of assets and then pass it to the checkout view
        $assets_list = Helper::detailedAssetList();

        return View::make('components/checkout', compact('component'))->with('assets_list', $assets_list);

    }

    /**
    * Validate and store checkout data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getCheckout() method that returns the form.
    * @since [v3.0]
    * @param int $componentId
    * @return Redirect
    */
    public function postCheckout(Request $request, $componentId)
    {



        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return redirect()->to('components')->with('error', trans('admin/components/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }


        $max_to_checkout = $component->numRemaining();
        $validator = Validator::make($request->all(),[
            "asset_id"          => "required",
            "assigned_qty"      => "required|numeric|between:1,$max_to_checkout"
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin_user = Auth::user();
        $asset_id = e(Input::get('asset_id'));

      // Check if the user exists
        if (is_null($asset = Asset::find($asset_id))) {
            // Redirect to the component management page with error
            return redirect()->to('admin/components')->with('error', trans('admin/components/message.asset_does_not_exist'));
        }
        
      // Update the component data
        $component->asset_id =   $asset_id;

        $component->assets()->attach($component->id, array(
        'component_id' => $component->id,
        'user_id' => $admin_user->id,
        'created_at' => date('Y-m-d H:i:s'),
        'assigned_qty' => e(Input::get('assigned_qty')),
        'asset_id' => $asset_id));

        $logaction = $component->logCheckout(e(Input::get('note')), $asset_id);

        $settings = Setting::getSettings();

        if ($settings->slack_endpoint) {

            $slack_settings = [
                'username' => $settings->botname,
                'channel' => $settings->slack_channel,
                'link_names' => true
            ];

            $client = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);

            try {
                    $client->attach([
                        'color' => 'good',
                        'fields' => [
                            [
                                'title' => 'Checked Out:',
                                'value' => class_basename(strtoupper($logaction->item_type)).' <'.config('app.url').'/admin/components/'.$component->id.'/view'.'|'.$component->name.'> checked out to <'.config('app.url').'/hardware/'.$asset->id.'/view|'.$asset->showAssetName().'> by <'.config('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
                            ],
                            [
                                'title' => 'Note:',
                                'value' => e($logaction->note)
                            ],
                        ]
                    ])->send('Component Checked Out');

            } catch (Exception $e) {

            }
        }

      // Redirect to the new component page
        return redirect()->to("admin/components")->with('success', trans('admin/components/message.checkout.success'));



    }


    /**
    * Generates the JSON response for accessories listing view.
    *
    * For debugging, see at /api/accessories/list
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v3.0]
    * @return string JSON
    **/
    public function getDatatable()
    {
        $components = Company::scopeCompanyables(Component::select('components.*')->whereNull('components.deleted_at')
            ->with('company', 'location', 'category'));

        if (Input::has('search')) {
            $components = $components->TextSearch(Input::get('search'));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }

        $allowed_columns = ['id','name','min_amt','order_number','serial','purchase_date','purchase_cost','companyName','category','total_qty'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        switch ($sort) {
            case 'category':
                $components = $components->OrderCategory($order);
                break;
            case 'location':
                $components = $components->OrderLocation($order);
                break;
            case 'companyName':
                $components = $components->OrderCompany($order);
                break;
            default:
                $components = $components->orderBy($sort, $order);
                break;
        }

        $consumCount = $components->count();
        $components = $components->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($components as $component) {
            $actions = '<nobr>';
            if (Gate::allows('components.checkout')) {
                $actions .= '<a href="' . route('checkout/component',
                        $component->id) . '" style="margin-right:5px;" class="btn btn-info btn-sm ' . (($component->numRemaining() > 0) ? '' : ' disabled') . '" ' . (($component->numRemaining() > 0) ? '' : ' disabled') . '>' . trans('general.checkout') . '</a>';
            }

            if (Gate::allows('components.edit')) {
                $actions .= '<a href="' . route('update/component',
                        $component->id) . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }

            if (Gate::allows('components.delete')) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/component',
                        $component->id) . '" data-content="' . trans('admin/components/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($component->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }

            $actions .='</nobr>';
            $company = $component->company;

            $rows[] = array(
                'checkbox'      =>'<div class="text-center"><input type="checkbox" name="component['.$component->id.']" class="one_required"></div>',
                'id'            => $component->id,
                'name'          => (string)link_to('admin/components/'.$component->id.'/view', e($component->name)),
                'serial_number'          => $component->serial,
                'location'   => ($component->location) ? e($component->location->name) : '',
                'qty'           => e($component->qty),
                'min_amt'           => e($component->min_amt),
                'category'           => ($component->category) ? e($component->category->name) : 'Missing category',
                'order_number'  => e($component->order_number),
                'purchase_date'  => e($component->purchase_date),
                'purchase_cost'  => Helper::formatCurrencyOutput($component->purchase_cost),
                'numRemaining'  => $component->numRemaining(),
                'actions'       => $actions,
                'companyName'   => is_null($company) ? '' : e($company->name),
            );
        }

        $data = array('total' => $consumCount, 'rows' => $rows);

        return $data;

    }

    /**
    * Return JSON data to populate the components view,
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getView() method that returns the view.
    * @since [v3.0]
    * @param int $componentId
    * @return string JSON
    */
    public function getDataView($componentId)
    {
        //$component = Component::find($componentID);
        $component = Component::with('assets')->find($componentId);


        if (!Company::isCurrentUserHasAccess($component)) {
            return ['total' => 0, 'rows' => []];
        }

        $rows = array();

        foreach ($component->assets as $component_assignment) {
            $rows[] = array(
            'name' => (string)link_to('/hardware/'.$component_assignment->id.'/view', e($component_assignment->showAssetName())),
            'qty' => e($component_assignment->pivot->assigned_qty),
            'created_at' => ($component_assignment->created_at->format('Y-m-d H:i:s')=='-0001-11-30 00:00:00') ? '' : $component_assignment->created_at->format('Y-m-d H:i:s'),
            );
        }

        $componentCount = $component->assets->count();
        $data = array('total' => $componentCount, 'rows' => $rows);
        return $data;
    }
}
