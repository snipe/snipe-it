<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ComponentRequest;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Component;
use App\Models\Setting;
// use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Asset;
use App\Models\AssetModel;
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
	 *
     * Searches the component table by component tag, and redirects if it finds one
     *
     * @author 
     * @since [v3.0]
     * @return Redirect
     */
    public function getComponentByTag()
    {
        if (Input::get('topsearch')=="true") {
            $topsearch = true;
        } else {
            $topsearch = false;
        }
        if ($component = Component::where('component_tag', '=', Input::get('assetTag'))->first()) {
            return redirect()->route('view/components', $component->id)->with('topsearch', $topsearch);
        }
        return redirect()->to('components')->with('error', trans('admin/components/message.does_not_exist'));

    }

    /**
    * Returns a form to create a new component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::postCreate() method that stores the data
    * @since [v3.0]
    * @return View
    */
    public function getCreate($model_id = null)
    {
        // Show the page
		$model_list = Helper::modelList('component');
		$manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('component');
		$supplier_list = Helper::suppliersList();
        $company_list = Helper::companyList();
		$location_list = Helper::locationsList();
		
		//$statuslabel_types = Helper::statusTypeList();
        
        return View::make('components/edit')
            ->with('item', new Component)
			->with('model_list', $model_list)
			->with('manufacturer_list', $manufacturer_list)
			->with('supplier_list', $supplier_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list)
			->with('category_list', $category_list);
			//->with('statuslabel_types', $statuslabel_types); // $supplier_list is only use for loding modals.blade.php

        if (!is_null($model_id)) {
            $selected_model = AssetModel::find($model_id);
            $view->with('selected_model', $selected_model);
        }
    }


    /**
    * Validate and store data for new component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getCreate() method that generates the view
    * @since [v3.0]
    * @return Redirect
    */
    public function postCreate(ComponentRequest $request)
    {
        // create a new model instance
        $component = new Component();
		$component->model()->associate(AssetModel::find(e(Input::get('model_id'))));
		
		$checkModel = config('app.url').'/api/models/'.e(Input::get('model_id')).'/check';

        // Update the component data
        $component->name                   = e(Input::get('name'));
		$component->serial                 = e(Input::get('serial'));
		$component->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
		$component->model_id               = e(Input::get('model_id'));
		$component->order_number           = e(Input::get('order_number'));
		$component->component_tag          = e(Input::get('component_tag'));
		
		//$component->manufacturer_id        = e(Input::get('manufacturer_id'));
		//$component->model_number           = e(Input::get('model_number'));
        //$component->category_id            = e(Input::get('category_id'));
        $component->location_id            = e(Input::get('location_id'));
        $component->min_amt                = e(Input::get('min_amt'));
        

        // if (e(Input::get('status_id')) == '') {
            // $component->status_id =  null;
        // } else {
            // $component->status_id = e(Input::get('status_id'));
        // }

		
        if (e(Input::get('warranty_months')) == '') {
            $component->warranty_months =  null;
        } else {
            $component->warranty_months        = e(Input::get('warranty_months'));
        }

	
        if (e(Input::get('purchase_cost')) == '0.00') {
            $component->purchase_cost       =  null;
        } else {
            $component->purchase_cost       = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }
		
		
        if (e(Input::get('purchase_date')) == '') {
            $component->purchase_date       =  null;
        } else {
            $component->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('supplier_id')) == '') {
            $component->supplier_id =  0;
        } else {
            $component->supplier_id        = e(Input::get('supplier_id'));
        }
		
		
        $component->qty                    = e(Input::get('qty'));
        $component->user_id                = Auth::user()->id;

        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.
        /*$model = AssetModel::find($request->get('model_id'));
		
        if ($model->fieldset) {
            foreach ($model->fieldset->fields as $field) {
                $component->{\App\Models\CustomField::name_to_db_name($field->name)} = e($request->input(\App\Models\CustomField::name_to_db_name($field->name)));
            }
        }
		*/
		
		/*
        // Was the component created?
        if ($component->save()) {
            $component->logCreate();
            // Redirect to the new component  page
            return redirect()->to('admin/components')->with('success', trans('admin/components/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($component->getErrors());
		*/
		

            // Was the asset created?
        if ($component->save()) {
            $component->logCreate();
            //if (Input::get('assigned_to')!='') {
            //    $user = User::find(e(Input::get('assigned_to')));
            //    $asset->checkOutToUser($user, Auth::user(), date('Y-m-d H:i:s'), '', 'Checked out on asset creation', e(Input::get('name')));
            //}
            // Redirect to the asset listing page
            \Session::flash('success', trans('admin/components/message.create.success'));
            return response()->json(['redirect_url' => route('components')]);
        }
        \Input::flash();
        \Session::flash('errors', $asset->getErrors());
        return response()->json(['errors' => $asset->getErrors()], 500);

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

		$model_list = Helper::modelList('component');
		$supplier_list = Helper::suppliersList();
		$manufacturer_list = Helper::manufacturerList();
        $category_list =  Helper::categoryList('component');
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();
		
		//$statuslabel_types = Helper::statusTypeList();

        return View::make('components/edit', compact('item'))
			->with('model_list', $model_list)
			->with('manufacturer_list', $manufacturer_list)
			->with('supplier_list', $supplier_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list)
			->with('category_list', $category_list);
			//->with('statuslabel_types', $statuslabel_types); // $supplier_list is only use for loding modals.blade.php
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
    public function postEdit(ComponentRequest $request, $componentId = null)
    {
		\Debugbar::info('ComponentsController::postEdit');
		
        // Check if the blog post exists
        if (!$component = Component::find($componentId)) {
            // Redirect to the blogs management page
            return redirect()->to('admin/components')->with('error', trans('admin/components/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($component)) {
            return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }
		
        // if ($request->has('status_id')) {
            // $component->status_id = e($request->input('status_id'));
        // } else {
            // $component->status_id =  null;
        // }

        if ($request->has('warranty_months')) {
            $component->warranty_months = e($request->input('warranty_months'));
        } else {
            $component->warranty_months =  null;
        }


        if ($request->has('purchase_cost')) {
            $component->purchase_cost = Helper::ParseFloat(e($request->input('purchase_cost')));
        } else {
            $component->purchase_cost =  null;
        }

        if ($request->has('purchase_date')) {
            $component->purchase_date = e($request->input('purchase_date'));
        } else {
            $component->purchase_date =  null;
        }

        if ($request->has('supplier_id')) {
            $component->supplier_id = e($request->input('supplier_id'));
        } else {
            $component->supplier_id =  null;
        }
		
        //// If the box isn't checked, it's not in the request at all.
        //$component->requestable = $request->has('requestable');

        if ($request->has('location_id')) {
            $component->location_id = e($request->input('location_id'));
        } else {
            $component->location_id =  null;
        }

        // if ($request->has('image_delete')) {
            // unlink(public_path().'/uploads/components/'.$component->image);
            // $component->image = '';
        // }
/*

        // Update the component data
        $component->name                   = e(Input::get('name'));
		//$component->manufacturer_id        = e(Input::get('manufacturer_id'));
		$component->model_number            = e(Input::get('model_number'));
        $component->category_id            = e(Input::get('category_id'));
        $component->location_id            = e(Input::get('location_id'));
        $component->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $component->order_number           = e(Input::get('order_number'));
        $component->min_amt                = e(Input::get('min_amt'));
        $component->serial                 = e(Input::get('serial'));
		$component->qty                    = e(Input::get('qty'));

*/
        // Update the component data
        $component->name         = e($request->input('name'));
        $component->serial       = e($request->input('serial'));
        $component->company_id   = Company::getIdForCurrentUser(e($request->input('company_id')));
        $component->model_id     = e($request->input('model_id'));
        $component->order_number = e($request->input('order_number'));
        $component->component_tag = e($request->input('component_tag'));
        $component->min_amt       = e($request->input('min_amt'));
		$component->qty           = e($request->input('qty'));
		
        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.
        /*
		$model = AssetModel::find($request->get('model_id'));
        if ($model->fieldset) {
            foreach ($model->fieldset->fields as $field) {

                if ($field->field_encrypted=='1') {
                    if (Gate::allows('admin')) {
                        $component->{\App\Models\CustomField::name_to_db_name($field->name)} = \Crypt::encrypt(e($request->input(\App\Models\CustomField::name_to_db_name($field->name))));
                    }
                } else {
                    $component->{\App\Models\CustomField::name_to_db_name($field->name)} = e($request->input(\App\Models\CustomField::name_to_db_name($field->name)));
                }
            }
        }
		*/


		\Debugbar::info('ComponentsController::save_ing');
        if ($component->save()) {
			\Debugbar::info('ComponentsController::save_ok');
			
            // Redirect to the new component page
            \Session::flash('success', trans('admin/components/message.update.success'));
            //return response()->json(['redirect_url' => route("admin/components", $componentId)]);
			return response()->json(['redirect_url' => route('components')]);
        }
		\Debugbar::info('ComponentsController::save_fail');
		
        \Input::flash();
        \Session::flash('errors', $asset->getErrors());
        return response()->json(['errors' => $asset->getErrors()], 500);


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
  * Check the component back into inventory
  *
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $componentId
  * @return View
  **/
    public function getCheckin(Request $request, $componentAssetId = null, $backto = null)
    {
        // Check if the component exists
        if (is_null($component_asset = DB::table('components_assets')->find($componentAssetId))) {
            // Redirect to the component management page with error
            return redirect()->to('components')->with('error', trans('admin/components/message.not_found'));
        }

        $component = Component::find($component_asset->component_id);

        if (!Company::isCurrentUserHasAccess($component)) {
			return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        } else {
            return View::make('components/checkin', compact('component', 'component_asset'))->with('backto', $backto);
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
			'asset_id' => $asset_id
		));

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
        return redirect()->to('admin/components')->with('success', trans('admin/components/message.checkout.success'));

    }

  /**
  * Check in the item so that it can be checked out again to someone else
  *
  * @uses 
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryId
  * @return Redirect
  **/
    public function postCheckin(Request $request, $componentAssetId = null, $backto = null)
    {
        // Check if the component exists
        if (is_null($component_asset = DB::table('components_assets')->find($componentAssetId))) {
            // Redirect to the component management page with error
            return redirect()->to('components')->with('error', trans('admin/components/message.not_found'));
        }

        $component = Component::find($component_asset->component_id);

        if (!Company::isCurrentUserHasAccess($component)) {
			return redirect()->to('admin/components')->with('error', trans('general.insufficient_permissions'));
        }

		$return_to = e($component_asset->asset_id);
		$logaction = $component->logCheckin(Asset::find($return_to), e(Input::get('note')));
		$admin_user = Auth::user();

		// Was the components_assets updated?
		if (DB::table('components_assets')->where('id', '=', $component_asset->id)->delete()) {
		
            $settings = Setting::getSettings();

            if ($settings->slack_endpoint) {

                $slack_settings = [
                'username' => e($settings->botname),
                'channel' => e($settings->slack_channel),
                'link_names' => true
                ];

                $client = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);

                try {
                    $client->attach([
                        'color' => 'good',
                        'fields' => [
                            [
                                'title' => 'Checked In:',
                                'value' => class_basename(strtoupper($logaction->item_type)).' <'.config('app.url').'/admin/component/'.e($component->id).'/view'.'|'.e($component->name).'> checked in by <'.config('app.url').'/admin/users/'.e($admin_user->id).'/view'.'|'.e($admin_user->fullName()).'>.'
                            ],
                            [
                                'title' => 'Note:',
                                'value' => e($logaction->note)
                            ],

                        ]
                    ])->send('Accessory Checked In');

                } catch (Exception $e) {

                }

            }

	
            if ($backto=='hardware') {
                return redirect()->to("admin/hardware/".$return_to->id.'/view')->with('success', trans('admin/components/message.checkin.success'));
            } else {
                return redirect()->to("admin/components/".$component->id."/view")->with('success', trans('admin/components/message.checkin.success'));
            }
			
        }

        // Redirect to the accessory management page with error
        return redirect()->to('admin/components')->with('error', trans('admin/components/message.checkin.error'));
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
    public function getDatatable(Request $request/*, $status = null*/)
    {
		// ->whereNull('components.deleted_at')
        $components = Company::scopeCompanyables(Component::select('components.*')
							->with('company', 'location', 'model', 'model.category', 'model.manufacturer' ));

        if ($request->has('search')) {
            $components = $components->TextSearch(e($request->get('search')));
        }

        if ($request->has('offset')) {
            $offset = e($request->get('offset'));
        } else {
            $offset = 0;
        }

        if ($request->has('limit')) {
            $limit = e($request->get('limit'));
        } else {
            $limit = 50;
        }

        if ($request->has('order_number')) {
            $components->where('order_number', '=', e($request->get('order_number')));
        }

        // switch ($status) {
            // case 'Deleted':
                // $components->withTrashed()->Deleted();
                // break;
            // case 'Pending':
                // $components->Pending();
                // break;
            // case 'RTD':
                // $components->RTD();
                // break;
            // case 'Undeployable':
                // $components->Undeployable();
                // break;
            // case 'Archived':
                // $components->Archived();
                // break;
            // case 'Requestable':
                // $components->RequestableAssets();
                // break;
            // case 'Deployed':
                // $components->Deployed();
                // break;
        // }
		
        // if ($request->has('status_id')) {
            // $components->where('status_id','=', e($request->get('status_id')));
        // }


        $allowed_columns = [
			'id',
			'name',
			'component_tag',
			'serial',
			'model',
			'model_number',
			'category',
			'manufacturer',
			'notes',
			'order_number',
			'companyName',
			'location',
			// 'status_label',
			'qty',
			'min_amt',
			'created_at',
			'purchase_date',
			'purchase_cost',
		];
		
		
		$order = $request->get('order') === 'asc' ? 'asc' : 'desc';
		$sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'component_tag';

        switch ($sort) {
            case 'model':
                $components = $components->OrderModels($order);
                break;
            case 'model_number':
                $components = $components->OrderModelNumber($order);
                break;
            case 'category':
                $components = $components->OrderCategory($order);
                break;
            case 'manufacturer':
                $components = $components->OrderManufacturer($order);
                break;
            case 'companyName':
                $components = $components->OrderCompany($order);
                break;
            case 'location':
                $components = $components->OrderLocation($order);
                break;	
            //case 'status_label':
            //    $components = $components->OrderStatus($order);
            //    break;
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
			

            $rows[] = array(
                'checkbox'       =>'<div class="text-center"><input type="checkbox" name="component['.$component->id.']" class="one_required"></div>',
                'id'             => $component->id,
                'name'           => (string)link_to('admin/components/'.$component->id.'/view', e($component->name)),
				'component_tag'  => '<a title="'.e($component->component_tag).'" href="components/'.$component->id.'/view">'.e($component->component_tag).'</a>',
                'serial'         => $component->serial,
				'model'          => ($component->model) ? (string)link_to('/hardware/models/'.$component->model->id.'/view', e($component->model->name)) : 'No model',
				'model_number'   => ($component->model && $component->model->model_number) ? (string)$component->model->model_number : '',
				//'status_label'   => ($asset->assigneduser) ? 'Deployed' : ((e($asset->assetstatus)) ? e($asset->assetstatus->name) : ''),
                'location'       => ($component->location) ? (string)link_to('admin/settings/locations/'.$component->location->id.'/view',e($component->location->name)) : '',
				'category'       => ($component->model && $component->model->category) ? 
									(string)link_to('/admin/settings/categories/'.$component->model->category->id.'/view', e($component->model->category->name)) : '',
				'manufacturer'   => ($component->model && $component->model->manufacturer) ? 
									(string)link_to('/admin/settings/manufacturers/'.$component->model->manufacturer->id.'/view', e($component->model->manufacturer->name)) : '',
                'purchase_date'  => e($component->purchase_date),
                'purchase_cost'  => Helper::formatCurrencyOutput($component->purchase_cost),
				'notes'          => e($component->notes),
				'order_number'   => e($component->order_number),
                'qty'            => e($component->qty),
                'min_amt'        => e($component->min_amt),
                'numRemaining'   => $component->numRemaining(),
                'actions'        => $actions,
                'companyName'    => is_null($component->company) ? '' : e($component->company->name),
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
        //$component = Component::find($componentId);
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
