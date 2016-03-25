<?php namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Component;
use App\Models\Setting;
use App\Models\User;
use App\Models\Asset;
use App\Http\Requests\ComponentCheckoutRequest;
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

class ComponentsController extends Controller
{
    /**
     * Show a list of all the components.
     *
     * @return View
     */

    public function getIndex()
    {
        return View::make('components/index');
    }


    /**
     * Component create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $category_list = array('' => '') + DB::table('categories')->where('category_type', '=', 'component')->whereNull('deleted_at')->orderBy('name', 'ASC')->lists('name', 'id');
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();

        return View::make('components/edit')
            ->with('component', new Component)
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list);
    }


    /**
     * Component create form processing.
     *
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
        $component->min_amt             = e(Input::get('min_amt'));

        if (e(Input::get('purchase_date')) == '') {
            $component->purchase_date       =  null;
        } else {
            $component->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $component->purchase_cost       =  null;
        } else {
            $component->purchase_cost       = e(Input::get('purchase_cost'));
        }

        $component->total_qty                    = e(Input::get('total_qty'));
        $component->user_id                = Auth::user()->id;

        // Was the component created?
        if ($component->save()) {
            // Redirect to the new component  page
            return Redirect::to("admin/components")->with('success', Lang::get('admin/components/message.create.success'));
        }

        return Redirect::back()->withInput()->withErrors($component->getErrors());


    }

    /**
     * Component update.
     *
     * @param  int  $componentId
     * @return View
     */
    public function getEdit($componentId = null)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/components')->with('error', Lang::get('admin/components/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return Redirect::to('admin/components')->with('error', Lang::get('general.insufficient_permissions'));
        }

            $category_list =  Helper::categoryList();
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();

        return View::make('components/edit', compact('component'))
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list);
    }


    /**
     * Component update form processing page.
     *
     * @param  int  $componentId
     * @return Redirect
     */
    public function postEdit($componentId = null)
    {
        // Check if the blog post exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/components')->with('error', Lang::get('admin/components/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return Redirect::to('admin/components')->with('error', Lang::get('general.insufficient_permissions'));
        }


        // Update the component data
        $component->name                   = e(Input::get('name'));
        $component->category_id            = e(Input::get('category_id'));
        $component->location_id            = e(Input::get('location_id'));
        $component->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $component->order_number           = e(Input::get('order_number'));
        $component->min_amt             = e(Input::get('min_amt'));

        if (e(Input::get('purchase_date')) == '') {
            $component->purchase_date       =  null;
        } else {
            $component->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $component->purchase_cost       =  null;
        } else {
            $component->purchase_cost       = e(Input::get('purchase_cost'));
        }

        $component->total_qty                    = e(Input::get('total_qty'));

        // Was the component created?
        if ($component->save()) {
            // Redirect to the new component page
            return Redirect::to("admin/components")->with('success', Lang::get('admin/components/message.update.success'));
        }

        return Redirect::back()->withInput()->withErrors($component->getErrors());




    }

    /**
     * Delete the given component.
     *
     * @param  int  $componentId
     * @return Redirect
     */
    public function getDelete($componentId)
    {
        // Check if the blog post exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/components')->with('error', Lang::get('admin/components/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return Redirect::to('admin/components')->with('error', Lang::get('general.insufficient_permissions'));
        }

            $component->delete();

            // Redirect to the locations management page
            return Redirect::to('admin/components')->with('success', Lang::get('admin/components/message.delete.success'));

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
    *  Get the component information to present to the component view page
    *
    * @param  int  $componentId
    * @return View
    **/
    public function getView($componentID = null)
    {
        $component = Component::find($componentID);

        if (isset($component->id)) {


            if (!Company::isCurrentUserHasAccess($component)) {
                return Redirect::to('admin/components')->with('error', Lang::get('general.insufficient_permissions'));
            } else {
                return View::make('components/view', compact('component'));
            }
        } else {
            // Prepare the error message
            $error = Lang::get('admin/components/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('components')->with('error', $error);
        }


    }

    /**
    * Check out the component to a person
    **/
    public function getCheckout($componentId)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return Redirect::to('components')->with('error', Lang::get('admin/components/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return Redirect::to('admin/components')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Get the dropdown of assets and then pass it to the checkout view
        $assets_list = Helper::assetsList();

        return View::make('components/checkout', compact('component'))->with('assets_list', $assets_list);

    }

    /**
    * Check out the component to a person
    **/
    public function postCheckout(ComponentCheckoutRequest $request, $componentId)
    {
      // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return Redirect::to('components')->with('error', Lang::get('admin/components/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return Redirect::to('admin/components')->with('error', Lang::get('general.insufficient_permissions'));
        }

        $admin_user = Auth::user();
        $asset_id = e(Input::get('asset_id'));

      // Check if the user exists
        if (is_null($asset = Asset::find($asset_id))) {
            // Redirect to the component management page with error
            return Redirect::to('admin/components')->with('error', Lang::get('admin/components/message.asset_does_not_exist'));
        }

      // Update the component data
        $component->asset_id =   $asset_id;

        $component->assets()->attach($component->id, array(
        'component_id' => $component->id,
        'user_id' => $admin_user->id,
        'created_at' => date('Y-m-d h:i:s'),
        'assigned_qty' => e(Input::get('assigned_qty')),
        'asset_id' => $asset_id));

        $logaction = new Actionlog();
        $logaction->component_id = $component->id;
        $logaction->asset_id = $asset_id;
        $logaction->asset_type = 'component';
        $logaction->location_id = $asset->location_id;
        $logaction->user_id = Auth::user()->id;
        $logaction->note = e(Input::get('note'));

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
                                'value' => strtoupper($logaction->asset_type).' <'.config('app.url').'/admin/components/'.$component->id.'/view'.'|'.$component->name.'> checked out to <'.config('app.url').'/hardware/'.$asset->id.'/view|'.$asset->name.'> by <'.config('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
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


        $log = $logaction->logaction('checkout');

      // Redirect to the new component page
        return Redirect::to("admin/components")->with('success', Lang::get('admin/components/message.checkout.success'));



    }


    public function getDatatable()
    {
        $components = Component::select('components.*')->whereNull('components.deleted_at')
            ->with('company', 'location', 'category');

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

        $allowed_columns = ['id','name','min_amt','order_number','purchase_date','purchase_cost','companyName','category','total_qty'];
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
            $actions = '<nobr><a href="'.route('checkout/component', $component->id).'" style="margin-right:5px;" class="btn btn-info btn-sm" '.(($component->numRemaining() > 0 ) ? '' : ' disabled').'>'.Lang::get('general.checkout').'</a><a href="'.route('update/component', $component->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/component', $component->id).'" data-content="'.Lang::get('admin/components/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($component->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></nobr>';
            $company = $component->company;

            $rows[] = array(
                'checkbox'      =>'<div class="text-center"><input type="checkbox" name="component['.$component->id.']" class="one_required"></div>',
                'id'            => $component->id,
                'name'          => (string)link_to('admin/components/'.$component->id.'/view', $component->name),
                'location'   => ($component->location) ? e($component->location->name) : '',
                'total_qty'           => $component->total_qty,
                'min_amt'           => $component->min_amt,
                'category'           => ($component->category) ? $component->category->name : 'Missing category',
                'order_number'  => $component->order_number,
                'purchase_date'  => $component->purchase_date,
                'purchase_cost'  => ($component->purchase_cost!='') ? number_format($component->purchase_cost, 2): '' ,
                'numRemaining'  => $component->numRemaining(),
                'actions'       => $actions,
                'companyName'   => is_null($company) ? '' : e($company->name),
            );
        }

        $data = array('total' => $consumCount, 'rows' => $rows);

        return $data;

    }

    public function getDataView($componentID)
    {
        //$component = Component::find($componentID);
        $component = Component::with('assets')->find($componentID);

  //  $component->load('componentAssigments.admin','componentAssigments.user');

        if (!Company::isCurrentUserHasAccess($component)) {
            return ['total' => 0, 'rows' => []];
        }

        $rows = array();

        foreach ($component->assets as $component_assignment) {
            $rows[] = array(
            'name' => (string)link_to('/hardware/'.$component_assignment->id.'/view', $component_assignment->name),
            'qty' => $component_assignment->pivot->assigned_qty,
            'created_at' => ($component_assignment->created_at->format('Y-m-d H:i:s')=='-0001-11-30 00:00:00') ? '' : $component_assignment->created_at->format('Y-m-d H:i:s'),
            );
        }

        $componentCount = $component->assets->count();
        $data = array('total' => $componentCount, 'rows' => $rows);
        return $data;
    }
}
