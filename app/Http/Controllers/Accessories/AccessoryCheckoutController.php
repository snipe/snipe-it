<?php

namespace App\Http\Controllers\Accessories;

use App\Events\CheckoutableCheckedOut;
use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AccessoryCheckoutController extends Controller
{
    /**
     * Return the form to checkout an Accessory to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $accessoryId
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($accessoryId)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory management page with error
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.not_found'));
        }

        if ($accessory->category) {
            $this->authorize('checkout', $accessory);

            // Get the dropdown of users and then pass it to the checkout view
            return view('accessories/checkout', compact('accessory'));
        }

        return redirect()->back()->with('error', 'The category type for this accessory is not valid. Edit the accessory and select a valid accessory category.');
    }

    /**
     * Save the Accessory checkout information.
     *
     * If Slack is enabled and/or asset acceptance is enabled, it will also
     * trigger a Slack message and send an email.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @param  int $accessoryId
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $accessoryId)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory management page with error
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.user_not_found'));
        }

        if(is_null($request->input('note'))) {
            return redirect()->route('accessories.checkout.show', $accessory->id)->with('warning', "Notes are required.");
        }

        /* 
        The assigned_to value is hardcoded to user id 8 in the view with a hidden value which is a dummy user account
        It's ugly and I hate it but nothing else works on the backend right now
        This ultimately is not very secure for obvious reasons.
        After further testing, it doesn't like not having the assigned_to value from the front end somewhere.
        I need to find where that check is happening to maybe cheese it that way.
        */
        $this->authorize('checkout', $accessory);
        if (!$user = User::find($request->input('assigned_to'))) {
            return redirect()->route('accessories.checkout.show', $accessory->id)->with('error', trans('admin/accessories/message.checkout.user_does_not_exist'));
        }


        // Update the accessory data
        // This allows for QTY support. If more than 1 is needed, it loops. I don't like this method but this works for now. Need to revisit it later to optimize it better.
        // e.g. Build qty into logs and not have a log generate for a every single individual checkout.

        for ($i = 1; $i <= (int) $request->input('qty'); $i++) {
            $accessory->assigned_to = $request->input('assigned_to');
            $accessory->users()->attach($accessory->id, [
                'accessory_id' => $accessory->id,
                'created_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'assigned_to' => $request->get('assigned_to'),
                'note' => $request->input('note'),
            ]);
            event(new CheckoutableCheckedOut($accessory, $user, Auth::user(), $request->input('note')));
        }


        // DB::table('accessories_users')->where('assigned_to', '=', $accessory->assigned_to)->where('accessory_id', '=', $accessory->id)->first();


        // Redirect to the new accessory page
        return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.checkout.success'));
    }
}