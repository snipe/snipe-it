<?php

namespace App\Http\Controllers\Consumables;

use App\Events\ConsumableCheckedOut;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ConsumablesController;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use DB;

class ConsumableReplenishController extends Controller
{
    /**
     * Return a view to replenish a consumable .
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ConsumableCheckoutController::store() method that stores the data.
     * @since [v1.0]
     * @param int $consumableId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($consumableId)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }
        $this->authorize('update', $consumable);

        return view('consumables/replenish', compact('consumable'));
    }

    /**
     * Saves the replenish information
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @see ConsumableReplenishCheckoutController::create() method that returns the form.
     * @since [v6.0]
     * @param int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $consumableId)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }

        $request->validate([
            "totalnum" => "required|regex:/^[0-9]*$/|gt:0"
          ],[            
            'totalnum.gt' =>  trans('admin/consumables/message.under'),
            'totalnum.required' => trans('admin/consumables/message.required'),
            'totalnum.regex' => trans('admin/consumables/message.numeric'),
          ]);

        $this->authorize('update', $consumable);

        $admin_user = Auth::user();

        // Update the consumable data
        $consumable->assigned_to = e($request->input('assigned_to'));

        $consumable->replenishusers()->attach($consumable->id, [
            'consumable_id' => $consumable->id,            
            'user_id' => $admin_user->id,
            'initial_qty' => $consumable->qty,            
            'total_replenish' => e($request->input('totalnum')),
            'replenishnote' => e($request->input('replenishnote'))
        ]);

        $addedquantity = $consumable->qty + e($request->input('totalnum'));
        
        // Storing value to database
        event(new ConsumableCheckedOut($consumable, Auth::user(), $consumable->qty, $request->input('note'), $request->input('totalnum')));

        // Updating quantity to consumable
        DB::table('consumables')
        ->where('id',$consumable->id)
        ->update(['qty'=> $addedquantity]);

        // Redirect to the new consumable page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.checkout.success'));
    }
}
