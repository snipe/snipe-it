<?php

namespace App\Http\Controllers\Consumables;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Company;
use App\Models\Consumable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use App\Models\Group;

/**
 * This controller handles all actions related to Consumables for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ConsumablesController extends Controller
{
    /**
     * Return a view to display component information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ConsumablesController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Consumable::class);

        return view('consumables/index');
    }

    /**
     * Return a view to display the form view to create a new consumable
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ConsumablesController::postCreate() method that stores the form data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Consumable::class);
        $user =  User::find(Auth::id());

        if($user->isSuperUser()){
            $userGroups = Group::pluck('name', 'id')->toArray();
        }else{
            $userGroups = $user->isAdminofGroup();
        }

        return view('consumables/edit')->with('category_type', 'consumable')
            ->with('item', new Consumable)
            ->with('groups',$userGroups);
    }

    /**
     * Validate and store new consumable data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ConsumablesController::getCreate() method that returns the form view
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Consumable::class);
        $consumable = new Consumable();
        $consumable->name                   = $request->input('name');
        $consumable->category_id            = $request->input('category_id');
        $consumable->location_id            = $request->input('location_id');
        $consumable->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $consumable->order_number           = $request->input('order_number');
        $consumable->min_amt                = $request->input('min_amt');
        $consumable->manufacturer_id        = $request->input('manufacturer_id');
        $consumable->model_number           = $request->input('model_number');
        $consumable->item_no                = $request->input('item_no');
        $consumable->purchase_date          = $request->input('purchase_date');
        $consumable->purchase_cost          = Helper::ParseCurrency($request->input('purchase_cost'));
        $consumable->qty                    = $request->input('qty');
        $consumable->user_id                = Auth::id();

        $consumable = $request->handleImages($consumable);

        if ($consumable->save()) {
            $consumable->groups()->sync($request->input('groups'),false);
            return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($consumable->getErrors());
    }

    /**
     * Returns a form view to edit a consumable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $consumableId
     * @see ConsumablesController::postEdit() method that stores the form data.
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($consumableId = null)
    {

        $user =  User::find(Auth::id());

        if($user->isSuperUser()){
            $userGroups = Group::pluck('name', 'id')->toArray();
        }else{
            $userGroups = $user->isAdminofGroup();
        }

        if ($item = Consumable::find($consumableId)) {
            $this->authorize($item);

            $itemGrp= $item->groups()->pluck('name', 'id')->toArray();
            
            $result = count(array_intersect($userGroups, $itemGrp));

            if($result|| $item->user_id == Auth::id()){
                return view('consumables/edit', compact('item'))->with('category_type', 'consumable')
                ->with('groups',$userGroups);
            }else{
                return redirect()->route('consumables.index')->with('error', "You can not edit"); 
            }
        }

        return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
    }

    /**
     * Returns a form view to edit a consumable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param ImageUploadRequest $request
     * @param  int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @see ConsumablesController::getEdit() method that stores the form data.
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $consumableId = null)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }

        $this->authorize($consumable);

        $consumable->name                   = $request->input('name');
        $consumable->category_id            = $request->input('category_id');
        $consumable->location_id            = $request->input('location_id');
        $consumable->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $consumable->order_number           = $request->input('order_number');
        $consumable->min_amt                = $request->input('min_amt');
        $consumable->manufacturer_id        = $request->input('manufacturer_id');
        $consumable->model_number           = $request->input('model_number');
        $consumable->item_no                = $request->input('item_no');
        $consumable->purchase_date          = $request->input('purchase_date');
        $consumable->purchase_cost          = Helper::ParseCurrency($request->input('purchase_cost'));
        $consumable->qty                    = Helper::ParseFloat($request->input('qty'));

        $consumable = $request->handleImages($consumable);

        if ($consumable->save()) {
            $consumable->groups()->sync($request->input('groups'),false);
            return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($consumable->getErrors());
    }

    /**
     * Delete a consumable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $consumableId
     * @since [v1.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($consumableId)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }
        $this->authorize($consumable);

        $user =  User::find(Auth::id());

        if($user->isSuperUser()){
            $userGroups = Group::pluck('name', 'id')->toArray();
        }else{
            $userGroups = $user->isAdminofGroup();
        }

        $accessoryGrp= $consumable->groups()->pluck('name', 'id')->toArray();

        $result = count(array_intersect($userGroups, $accessoryGrp));

        if($result|| $consumable->user_id == Auth::id()){
            $consumable->delete();
        }else{
            return redirect()->route('consumables.index')->with('error', 'You can not delete');
        }
        // Redirect to the locations management page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.delete.success'));
    }

    /**
     * Return a view to display component information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ConsumablesController::getDataView() method that generates the JSON response
     * @since [v1.0]
     * @param int $consumableId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($consumableId = null)
    {
        $consumable = Consumable::find($consumableId);
        $this->authorize($consumable);
        if (isset($consumable->id)) {
            return view('consumables/view', compact('consumable'));
        }

        return redirect()->route('consumables.index')
            ->with('error', trans('admin/consumables/message.does_not_exist'));
    }
}
