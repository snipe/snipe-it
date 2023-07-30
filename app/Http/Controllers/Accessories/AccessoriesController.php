<?php

namespace App\Http\Controllers\Accessories;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Accessory;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Redirect;

/** This controller handles all actions related to Accessories for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class AccessoriesController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the accessories listing, which is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see AccessoriesController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Accessory::class);

        return view('accessories/index');
    }

    /**
     * Returns a view with a form to create a new Accessory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Accessory::class);
        $category_type = 'accessory';

        return view('accessories/edit')->with('category_type', $category_type)
          ->with('item', new Accessory);
    }

    /**
     * Validate and save new Accessory from form post
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param ImageUploadRequest $request
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize(Accessory::class);
        
        // create a new model instance
        $accessory = new Accessory();

        // Update the accessory data
        $accessory->name                    = request('name');
        $accessory->category_id             = request('category_id');
        $accessory->location_id             = request('location_id');
        $accessory->min_amt                 = request('min_amt');
        $accessory->company_id              = Company::getIdForCurrentUser(request('company_id'));
        $accessory->order_number            = request('order_number');
        $accessory->manufacturer_id         = request('manufacturer_id');
        $accessory->model_number            = request('model_number');
        $accessory->purchase_date           = request('purchase_date');
        $accessory->purchase_cost           = request('purchase_cost');
        $accessory->qty                     = request('qty');
        $accessory->user_id                 = Auth::user()->id;
        $accessory->supplier_id             = request('supplier_id');
        $accessory->notes                   = request('notes');

        $accessory = $request->handleImages($accessory);

        // Was the accessory created?
        if ($accessory->save()) {
            // Redirect to the new accessory  page
            return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($accessory->getErrors());
    }

    /**
     * Return view for the Accessory update form, prepopulated with existing data
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $accessoryId
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($accessoryId = null)
    {

        if ($item = Accessory::find($accessoryId)) {
            $this->authorize($item);

            return view('accessories/edit', compact('item'))->with('category_type', 'accessory');
        }

        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));

    }

    /**
     * Returns a view that presents a form to clone an accessory.
     *
     * @author [J. Vinsmoke]
     * @param int $accessoryId
     * @since [v6.0]
     * @return View
     */
    public function getClone($accessoryId = null)
    {

        $this->authorize('create', Accesory::class);

        // Check if the asset exists
        if (is_null($accessory_to_clone = Accessory::find($accessoryId))) {
            // Redirect to the asset management page
            return redirect()->route('accessory.index')->with('error', trans('admin/accessories/message.does_not_exist'));
        }

        $accessory = clone $accessory_to_clone;
        $accessory->id = null;
        $accessory->location_id = null;

        return view('accessories/edit')
            ->with('item', $accessory);
        
    }

    /**
     * Save edited Accessory from form post
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param ImageUploadRequest $request
     * @param  int $accessoryId
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ImageUploadRequest $request, $accessoryId = null)
    {
        if ($accessory = Accessory::withCount('users as users_count')->find($accessoryId)) {

            $this->authorize($accessory);

            $validator = Validator::make($request->all(), [
                "qty" => "required|numeric|min:$accessory->users_count"
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }



            // Update the accessory data
            $accessory->name = request('name');
            $accessory->location_id = request('location_id');
            $accessory->min_amt = request('min_amt');
            $accessory->category_id = request('category_id');
            $accessory->company_id = Company::getIdForCurrentUser(request('company_id'));
            $accessory->manufacturer_id = request('manufacturer_id');
            $accessory->order_number = request('order_number');
            $accessory->model_number = request('model_number');
            $accessory->purchase_date = request('purchase_date');
            $accessory->purchase_cost = request('purchase_cost');
            $accessory->qty = request('qty');
            $accessory->supplier_id = request('supplier_id');
            $accessory->notes = request('notes');

            $accessory = $request->handleImages($accessory);

            // Was the accessory updated?
            if ($accessory->save()) {
                return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.update.success'));
            }
        } else {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));
        }

        return redirect()->back()->withInput()->withErrors($accessory->getErrors());
    }

    /**
     * Delete the given accessory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $accessoryId
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($accessoryId)
    {
        if (is_null($accessory = Accessory::find($accessoryId))) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.not_found'));
        }

        $this->authorize($accessory);


        if ($accessory->hasUsers() > 0) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.assoc_users', ['count'=> $accessory->hasUsers()]));
        }

        if ($accessory->image) {
            try {
                Storage::disk('public')->delete('accessories'.'/'.$accessory->image);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        $accessory->delete();

        return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.delete.success'));
    }


    /**
     * Returns a view that invokes the ajax table which  contains
     * the content for the accessory detail view, which is generated in getDataView.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $accessoryID
     * @see AccessoriesController::getDataView() method that generates the JSON response
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($accessoryID = null)
    {
        $accessory = Accessory::withCount('users as users_count')->find($accessoryID);
        $this->authorize('view', $accessory);
        if (isset($accessory->id)) {
            return view('accessories/view', compact('accessory'));
        }

        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist', ['id' => $accessoryID]));
    }
}
