<?php

namespace App\Http\Controllers\Accessories;

use App\Events\CheckoutableCheckedOut;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessoryCheckoutRequest;
use App\Models\Accessory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;

class AccessoryCheckoutController extends Controller
{
    /**
     * Return the form to checkout an Accessory to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $id
     */
    public function create($id) : View | RedirectResponse
    {

        if ($accessory = Accessory::withCount('users as users_count')->find($id)) {

            $this->authorize('checkout', $accessory);

            if ($accessory->category) {
                // Make sure there is at least one available to checkout
                if ($accessory->numRemaining() <= 0){
                    return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.checkout.unavailable'));
                }

                // Return the checkout view
                return view('accessories/checkout', compact('accessory'));
            }

            // Invalid category
            return redirect()->route('accessories.edit', ['accessory' => $accessory->id])
                ->with('error', trans('general.invalid_item_category_single', ['type' => trans('general.accessory')]));

        }

        // Not found
        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.not_found'));

    }

    /**
     * Save the Accessory checkout information.
     *
     * If Slack is enabled and/or asset acceptance is enabled, it will also
     * trigger a Slack message and send an email.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @param  int $accessory
     */
    public function store(AccessoryCheckoutRequest $request, Accessory $accessory) : RedirectResponse
    {

        $this->authorize('checkout', $accessory);
        $accessory->assigned_to = $request->input('assigned_to');
        $user = User::find($request->input('assigned_to'));
        $accessory->checkout_qty = $request->input('checkout_qty', 1);

        for ($i = 0; $i < $accessory->checkout_qty; $i++) {
            $accessory->users()->attach($accessory->id, [
                'accessory_id' => $accessory->id,
                'created_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'assigned_to' => $request->input('assigned_to'),
                'note' => $request->input('note'),
            ]);
        }
        event(new CheckoutableCheckedOut($accessory, $user, auth()->user(), $request->input('note')));

        // Redirect to the new accessory page
        return redirect()->route('accessories.index')
            ->with('success', trans('admin/accessories/message.checkout.success'));
    }
}
