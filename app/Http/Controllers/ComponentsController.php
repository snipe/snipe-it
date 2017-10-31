<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Company;
use App\Models\Component;
use App\Models\CustomField;
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
use Image;

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
     * @return \Illuminate\Contracts\View\View
    */
    public function index()
    {
        $this->authorize('view', Component::class);
        return view('components/index');
    }


    /**
    * Returns a form to create a new component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::postCreate() method that stores the data
    * @since [v3.0]
    * @return \Illuminate\Contracts\View\View
    */
    public function create()
    {
        $this->authorize('create', Component::class);
        $category_type = 'component';
        return view('components/edit')->with('category_type',$category_type)
            ->with('item', new Component);
    }


    /**
    * Validate and store data for new component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getCreate() method that generates the view
    * @since [v3.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Component::class);
        $component = new Component();
        $component->name                   = $request->input('name');
        $component->category_id            = $request->input('category_id');
        $component->location_id            = $request->input('location_id');
        $component->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $component->order_number           = $request->input('order_number', null);
        $component->min_amt                = $request->input('min_amt', null);
        $component->serial                 = $request->input('serial', null);
        $component->purchase_date          = $request->input('purchase_date', null);
        $component->purchase_cost          = $request->input('purchase_cost', null);
        $component->qty                    = $request->input('qty');
        $component->user_id                = Auth::id();


        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/components/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $component->image = $file_name;
        }

        if ($component->save()) {
            return redirect()->route('components.index')->with('success', trans('admin/components/message.create.success'));
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
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($componentId = null)
    {


        if ($item = Component::find($componentId)) {
            $this->authorize('update', $item);
            $category_type = 'component';
            return view('components/edit', compact('item'))->with('category_type', $category_type);
        }
        return redirect()->route('components.index')->with('error', trans('admin/components/message.does_not_exist'));




    }


    /**
    * Return a view to edit a component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getEdit() method presents the form.
    * @param int $componentId
    * @since [v3.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ImageUploadRequest $request, $componentId = null)
    {
        if (is_null($component = Component::find($componentId))) {
            return redirect()->route('components.index')->with('error', trans('admin/components/message.does_not_exist'));
        }

        $this->authorize('update', $component);


        // Update the component data
        $component->name                   = Input::get('name');
        $component->category_id            = Input::get('category_id');
        $component->location_id            = Input::get('location_id');
        $component->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $component->order_number           = Input::get('order_number');
        $component->min_amt                = Input::get('min_amt');
        $component->serial                 = Input::get('serial');
        $component->purchase_date          = Input::get('purchase_date');
        $component->purchase_cost          = request('purchase_cost');
        $component->qty                    = Input::get('qty');

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/components/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $component->image = $file_name;
        } elseif ($request->input('image_delete')=='1') {
            $component->image = null;
        }

        if ($component->save()) {
            return redirect()->route('components.index')->with('success', trans('admin/components/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($component->getErrors());
    }

    /**
    * Delete a component.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v3.0]
    * @param int $componentId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($componentId)
    {
        if (is_null($component = Component::find($componentId))) {
            return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));
        }

        $this->authorize('delete', $component);
        $component->delete();
        return redirect()->route('components.index')->with('success', trans('admin/components/message.delete.success'));
    }

    public function postBulk($componentId = null)
    {
        //$this->authorize('checkout', $component)
        echo 'Stubbed - not yet complete';
    }

    public function postBulkSave($componentId = null)
    {
        //$this->authorize('edit', Component::class);
        echo 'Stubbed - not yet complete';
    }


    /**
    * Return a view to display component information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::getDataView() method that generates the JSON response
    * @since [v3.0]
    * @param int $componentId
    * @return \Illuminate\Contracts\View\View
     */
    public function show($componentId = null)
    {
        $component = Component::find($componentId);

        if (isset($component->id)) {
            $this->authorize('view', $component);
            return view('components/view', compact('component'));
        }
        // Prepare the error message
        $error = trans('admin/components/message.does_not_exist', compact('id'));
        // Redirect to the user management page
        return redirect()->route('components.index')->with('error', $error);
    }

    /**
    * Returns a view that allows the checkout of a component to an asset.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ComponentsController::postCheckout() method that stores the data.
    * @since [v3.0]
    * @param int $componentId
    * @return \Illuminate\Contracts\View\View
     */
    public function getCheckout($componentId)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));
        }
        $this->authorize('checkout', $component);
        return view('components/checkout', compact('component'));
    }

    /**
     * Validate and store checkout data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::getCheckout() method that returns the form.
     * @since [v3.0]
     * @param Request $request
     * @param int $componentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCheckout(Request $request, $componentId)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));
        }

        $this->authorize('checkout', $component);

        $max_to_checkout = $component->numRemaining();
        $validator = Validator::make($request->all(), [
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
            return redirect()->route('components.index')->with('error', trans('admin/components/message.asset_does_not_exist'));
        }

      // Update the component data
        $component->asset_id =   $asset_id;

        $component->assets()->attach($component->id, [
            'component_id' => $component->id,
            'user_id' => $admin_user->id,
            'created_at' => date('Y-m-d H:i:s'),
            'assigned_qty' => Input::get('assigned_qty'),
            'asset_id' => $asset_id
        ]);

        $component->logCheckout(e(Input::get('note')), $asset);
        return redirect()->route('components.index')->with('success', trans('admin/components/message.checkout.success'));
    }


}
