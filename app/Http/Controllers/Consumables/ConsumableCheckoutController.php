<?php

namespace App\Http\Controllers\Consumables;

use App\Events\CheckoutableCheckedOut;
use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ConsumableCheckoutController extends Controller
{
    /**
     * Return a view to checkout a consumable to a user.
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
        $this->authorize('checkout', $consumable);

        return view('consumables/checkout', compact('consumable'));
    }

    /**
     * Saves the checkout information
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ConsumableCheckoutController::create() method that returns the form.
     * @since [v1.0]
     * @param int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $consumableId, $byAdmin = true)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }

        $this->authorize('checkout', $consumable);

        $admin_user = Auth::user();
        $assigned_to = e($request->input('assigned_to'));

        if ($byAdmin)
        {        

            // Check if the user exists
            if (is_null($user = User::find($assigned_to))) {
                // Redirect to the consumable management page with error
                return redirect()->route('checkout/consumable', $consumable)->with('error', trans('admin/consumables/message.checkout.user_does_not_exist'));
            }

            // Update the consumable data
            $consumable->assigned_to = e($request->input('assigned_to'));
            
            $target = e($request->input('assigned_to'));
            $assigned_by = $admin_user->id;
        }
        else {
            $target = $admin_user->id;
            $user = $admin_user;
            $assigned_by = null;
        }

        $consumable->users()->attach($consumable->id, [
            'consumable_id' => $consumable->id,
            'user_id' => $assigned_by,          
            'assigned_to' => $target,            
            
        ]);

        event(new CheckoutableCheckedOut($consumable, $user, Auth::user(), $request->input('note')));

        // Redirect to the new consumable page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.checkout.success'));
    }

    
    /**
     * Return a view to checkout a consumable to a user.
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @see ConsumableCheckoutController::store() method that stores the data.
     * @since [v6.0]
     * @param int $consumableId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function selfcreate($consumableId)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }
        $this->authorize('selfcheckout', $consumable);

        return view('consumables/selfcheckout', compact('consumable'));
    }

    
    /**
     * Saves the selfcheckout information
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @see ConsumableCheckoutController::create() method that returns the form.
     * @since [v6.0]
     * @param int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function selfstore(Request $request, $consumableId)
    {
        return $this->store($request, $consumableId, false);
    }

    
}
