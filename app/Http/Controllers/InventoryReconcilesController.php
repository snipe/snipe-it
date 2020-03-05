<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\InventoryReconcile;
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
class InventoryReconcilesController extends Controller
{

  public function index(Request $request)
  {
    $invcount = new InventoryReconcile;
    dd($invcount->lastReconcile('App\Models\Accessory', '3', '5', 'in_stock'));
    $updatedcounts = $invcount->lastReconciles(['state' => 'in_stock', 'item_id' => '2']);
    dd($updatedcounts->toSql());
    $data = $updatedcounts->first();
    //dd($data);
    return $data;
  }
  /**
   * Returns a view with a form to create a new Accessory Inventory Adjustment.
   *
   * @author [Peter Brink] [<pbrink231@gmail.com>]
   * @return View
   */
    public function create(Request $request)
    {
        //return dd('test');
        //$this->authorize('create', InventoryAdjustment::class);
        $accessory = null;
        if (request('accessory_id')) {
          $accessory = Accessory::find($accessoryId);
        }
        $item = new InventoryAdjustment;
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
        if (!$accessory = Accessory::find(request('accessory_id'))) {
          return redirect()->back()->with('error', trans('admin/accessory/message.does_not_exist'));
        }
        

        // create a new model instance
        $adjustment = new InventoryAdjustment();

        // Update the accessory data
        $adjustment->location_id        = request('location_id');
        $adjustment->from_state         = request('from_state');
        $adjustment->to_state           = request('to_state');
        $adjustment->qty                = request('qty');
        $adjustment->occurred_at         = request('occurred_at');
        $adjustment->price              = Helper::ParseFloat(request('purchase_cost'));
        $adjustment->source_id          = request('source_id');
        $adjustment->reference_id       = request('reference_id');
        $adjustment->notes              = request('notes');

        $savedAdjustment = $accessory->invAdjust($adjustment);

        
        // Was the accessory created?
        if ($savedAdjustment) {
            // Redirect to the new accessory  page
            return redirect()->route('accessories.show', $accessory->id)->with('success', trans('admin/inventory/message.invadjust.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($adjustment->getErrors());
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
