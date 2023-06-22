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

        if (is_null($consumable = Consumable::with('users')->find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }

        // Make sure there is at least one available to checkout
        if ($consumable->numRemaining() <= 0){
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.checkout.unavailable'));
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
    public function store(Request $request, $consumableId)
    {
        if (is_null($consumable = Consumable::with('users')->find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }

        $this->authorize('checkout', $consumable);

        // Make sure there is at least one available to checkout
        if ($consumable->numRemaining() <= 0) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.checkout.unavailable'));
        }


        $admin_user = Auth::user();
        $assigned_to = e($request->input('assigned_to'));

        // Check if the user exists
        if (is_null($user = User::find($assigned_to))) {
            // Redirect to the consumable management page with error
            return redirect()->route('consumables.checkout.show', $consumable)->with('error', trans('admin/consumables/message.checkout.user_does_not_exist'))->withInput();
        }

        // Update the consumable data
        $consumable->assigned_to = e($request->input('assigned_to'));

        $consumable->users()->attach($consumable->id, [
            'consumable_id' => $consumable->id,
            'user_id' => $admin_user->id,
            'assigned_to' => e($request->input('assigned_to')),
            'note' => $request->input('note'),
        ]);

        event(new CheckoutableCheckedOut($consumable, $user, Auth::user(), $request->input('note')));

        // Redirect to the new consumable page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.checkout.success'));
    }
}
