<?php

namespace App\Http\Controllers\Accessories;

use App\Events\CheckoutableCheckedOut;
use App\Helpers\Helper;
use App\Http\Controllers\CheckInOutRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessoryCheckoutRequest;
use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\View\View;
use \Illuminate\Http\RedirectResponse;

class AccessoryCheckoutController extends Controller
{

    use CheckInOutRequest;

    /**
     * Return the form to checkout an Accessory to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $id
     */
    public function create($id) : View | RedirectResponse
    {

        if ($accessory = Accessory::withCount('checkouts as checkouts_count')->find($id)) {

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
     * @param  Accessory $accessory
     */
    public function store(AccessoryCheckoutRequest $request, Accessory $accessory) : RedirectResponse
    {
        $this->authorize('checkout', $accessory);

        $accessory->setLogTarget($this->determineCheckoutTarget());

        $accessory->setLogQuantity($request->input('checkout_qty', 1));
        $accessory->setLogNote($request->input('note'));

        event(new CheckoutableCheckedOut($accessory, $accessory->getLogTarget(), auth()->user(), $accessory->getLogNote()));

        $request->request->add(['checkout_to_type' => request('checkout_to_type')]);
        $request->request->add(['assigned_to' => $accessory->getLogTarget()->id]);

        session()->put(['redirect_option' => $request->get('redirect_option'), 'checkout_to_type' => $request->get('checkout_to_type')]);

        $accessory->checkout();

        // Redirect to the new accessory page
        return redirect()->to(Helper::getRedirectOption($request, $accessory->id, 'Accessories'))
            ->with('success', trans('admin/accessories/message.checkout.success'));
    }
}
