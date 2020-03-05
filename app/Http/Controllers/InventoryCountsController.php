<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
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
class InventoryCountsController extends Controller
{

  public function index(Request $request)
  {
    $invcount = new InventoryCount;
    $updatedcounts = $invcount->recentQuantitiesByGroup(['stock_location_id']);
    //dd($updatedcounts->toSql());
    $data = $updatedcounts->get();
    //dd($data);
    return $data;
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

        $savedAdjustment = $accessory->saveAndCount($adjustment);

        
        // Was the accessory created?
        if ($savedAdjustment) {
            // Redirect to the new accessory  page
            return redirect()->route('accessories.show', $accessory->id)->with('success', trans('admin/inventory/message.invadjust.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($adjustment->getErrors());
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
