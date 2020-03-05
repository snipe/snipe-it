<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\InventoryRequest;
use App\Models\Accessory;
use App\Models\InventoryAdjustment;
use App\Models\InventoryCount;
use App\Models\User;
use App\Enums\States;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Gate;
use Input;
use Lang;
use Redirect;
use Illuminate\Http\Request;
use Slack;
use Str;
use View;
use Image;
use App\Http\Requests\ImageUploadRequest;

/** This controller handles all actions related to Accessories for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class InventoryAdjustmentsController extends Controller
{
  use InventoryRequest;
  /**
   * Returns a view with a form to create a new Accessory Inventory Adjustment.
   *
   * @author [Peter Brink] [<pbrink231@gmail.com>]
   * @return View
   */
    public function create(Request $request)
    {
        $this->authorize('create', InventoryAdjustment::class);

        $item = new InventoryAdjustment;
        if (request('accessories')) {
          $accessory = Accessory::find(request('accessories'));
          $item->

        }

        
        $item->occurred_at = date_format(new \Carbon(), 'Y-m-d H:i:s');
        return view('accessories/inventory/adjustment')
          ->with('accessory', $accessory)
          ->with('item', $item)
          ->with('states', new States);
    }


  /**
   * Validate and save new Accessory from form post
   *
   * @author  Peter Brink <pbrink231@gmail.com>
   * @return Redirect
   */
    public function store(Request $request)
    {
        $this->authorize(InventoryAdjustment::class);

        // get item
        $item = $this->determineInventoryItem();

        if (!$item)
          return redirect()->back()->withInput()->with('error', trans('message.not_found', ['attribute' => request('inventory_item_type')]) );

        if (request('from_state') == request('to_state'))
          return redirect()->back()->withInput()->with('from_state', trans('admin/inventory/message.cannot_move_same_state') );



        $addedFields = [];

        if(Auth::user())
          $addedFields['user_id'] = Auth::user()->id;

        $addedFields = $item->fillItemType($addedFields);

        $request->merge($addedFields);

        $rules = array(
          'item_type' => 'required|string',
          'item_id' => 'required|integer',
          'stock_location_id' => 'exists:locations,id|nullable|numeric',
          'from_state' => 'required|not_in:'.request('to_state').'|in:'.implode(',', States::$from_states_manual),
          'to_state' => 'required|in:'.implode(',', States::$to_states_manual),
          'qty' => 'required|min:1',
          'occurred_at' => 'nullable', // |date_format:'.\DateTime::ISO8601,
        );
        $validator = \Validator::make($request->all(), $rules);
        $stock_location_id = request('stock_location_id');
        if (!$stock_location_id) {
          // set occurred at to now
          $stock_location_id = 0;
        }
        $occurred_at = request('occurred_at');
        if (!$occurred_at) {
          // set occurred at to now
          $occurred_at = Carbon::now();
        }


        if ($validator->fails()) {
          return redirect()->back()->withInput()->withErrors($validator);
        }

        $fromInventoryItem = [
          'item_type'         => request('item_type'),
          'item_id'           => request('item_id'),
          'stock_location_id' => $stock_location_id,
          'state'             => request('from_state')
        ];
        $toInventoryItem = [
          'item_type'         => request('item_type'),
          'item_id'           => request('item_id'),
          'stock_location_id' => $stock_location_id,
          'state'             => request('to_state')
        ];

        // check if quantity is available to move
        if (request('from_state') != States::NONE) {
          $currentFromCount = (new InventoryCount)->lastCount(request('item_type'), request('item_id'), $stock_location_id, request('from_state'))->first();
          if (!$currentFromCount || $currentFromCount->qty < request('qty')) {
            return redirect()->back()->withInput()->with('qty', trans('admin/inventory/message.not_enough_in_state') );
          }
        }

        // create a new model instance
        $adjustment = new InventoryAdjustment();

        // Update the accessory data
        $adjustment->item_type          = request('item_type');
        $adjustment->item_id            = request('item_id');
        $adjustment->stock_location_id  = $stock_location_id;
        $adjustment->from_state         = request('from_state');
        $adjustment->to_state           = request('to_state');
        $adjustment->qty                = request('qty');
        $adjustment->occurred_at        = $occurred_at;
        $adjustment->price              = Helper::ParseFloat(request('purchase_cost'));
        $adjustment->source_id          = request('source_id');
        $adjustment->reference_id       = request('reference_id');
        $adjustment->notes              = request('notes');
          
        if (!$isUpdated = $adjustment->saveAndCount()) {
          return redirect()->back()->withInput()->withErrors($adjustment->getErrors());
        }

        // determine which page to go back to
        switch(request('inventory_item_type'))
        {
            case 'accessory':
              return redirect()->route('accessories.show', request('item_id'))->with('success', trans('message.create.success', ['attribute' => trans('general.invadjust')]));
            case 'consumable':
              return redirect()->route('consumables.show', request('item_id'))->with('success', trans('message.create.success', ['attribute' => trans('general.invadjust')]));
            case 'component':
              return redirect()->route('components.show', request('item_id'))->with('success', trans('message.create.success', ['attribute' => trans('general.invadjust')]));
        }
        return redirect()->back()->with('success', trans('message.create.success', ['attribute' => trans('general.invadjust')]));
    }

  /**
   * Return view for the Accessory update form, prepopulated with existing data
   *
   * @author  Peter Brink <pbrink231@gmail.com>
   * @param  int  $accessoryId
   * @return View
   */
    public function edit(Request $request, $accessoryInvadjustId = null)
    {

        if ($item = InventoryAdjustment::find($accessoryInvadjustId)) {
            $this->authorize($item);
            return view('accessories/edit', compact('item'));
        }

        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));

    }


  /**
   * Save edited Accessory from form post
   *
   * @author  Peter Brink <pbrink231@gmail.com>
   * @param  int  $accessoryId
   * @return Redirect
   */
    public function update(ImageUploadRequest $request, $accessoryId = null)
    {

        if (is_null($accessory = Accessory::find($accessoryId))) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));
        }

        $this->authorize($accessory);

        // Update the accessory data
        $accessory->name                    = request('name');
        $accessory->location_id             = request('location_id');
        $accessory->min_amt                 = request('min_amt');
        $accessory->category_id             = request('category_id');
        $accessory->company_id              = Company::getIdForCurrentUser(request('company_id'));
        $accessory->manufacturer_id         = request('manufacturer_id');
        $accessory->order_number            = request('order_number');
        $accessory->model_number            = request('model_number');
        $accessory->purchase_date           = request('purchase_date');
        $accessory->purchase_cost           = request('purchase_cost');
        $accessory->qty                     = request('qty');
        $accessory->supplier_id             = request('supplier_id');

        $accessory = $request->handleImages($accessory,600, public_path().'/uploads/accessories');


        // Was the accessory updated?
        if ($accessory->save()) {
            return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($accessory->getErrors());
    }

  /**
   * Delete the given accessory.
   *
   * @author  Peter Brink <pbrink231@gmail.com>
   * @param  int  $accessoryId
   * @return Redirect
   */
    public function destroy(Request $request, $accessoryId)
    {
        if (is_null($accessory = Accessory::find($accessoryId))) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.not_found'));
        }

        $this->authorize($accessory);


        if ($accessory->hasUsers() > 0) {
             return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers())));
        }
        $accessory->delete();
        return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.delete.success'));
    }



  /**
  * Returns a view that invokes the ajax table which  contains
  * the content for the accessory detail view, which is generated in getDataView.
  *
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryID
  * @see AccessoriesController::getDataView() method that generates the JSON response
  * @since [v1.0]
  * @return View
  */
    public function show(Request $request, $accessoryID = null)
    {
        $accessory = Accessory::find($accessoryID);
        $this->authorize('view', $accessory);
        if (isset($accessory->id)) {
            return view('accessories/view', compact('accessory'));
        }
        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist', compact('id')));
    }
}
