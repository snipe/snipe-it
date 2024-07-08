<?php

namespace App\Http\Controllers\Components;

use App\Events\CheckoutableCheckedOut;
use App\Events\ComponentCheckedOut;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ComponentCheckoutController extends Controller
{
    /**
     * Returns a view that allows the checkout of a component to an asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentCheckoutController::store() method that stores the data.
     * @since [v3.0]
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {

        if ($component = Component::find($id)) {

            $this->authorize('checkout', $component);

            // Make sure the category is valid
            if ($component->category) {

                // Make sure there is at least one available to checkout
                if ($component->numRemaining() <= 0){
                    return redirect()->route('components.index')
                        ->with('error', trans('admin/components/message.checkout.unavailable'));
                }

                // Return the checkout view
                return view('components/checkout', compact('component'));
            }

            // Invalid category
            return redirect()->route('components.edit', ['component' => $component->id])
                ->with('error', trans('general.invalid_item_category_single', ['type' => trans('general.component')]));
        }

        // Not found
        return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));

    }

    /**
     * Validate and store checkout data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentCheckoutController::create() method that returns the form.
     * @since [v3.0]
     * @param Request $request
     * @param int $componentId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $componentId)
    {
        // Check if the component exists
        if (!$component = Component::find($componentId)) {
            // Redirect to the component management page with error
            return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));
        }

        $this->authorize('checkout', $component);

        $max_to_checkout = $component->numRemaining();

        // Make sure there are at least the requested number of components available to checkout
        if ($max_to_checkout < $request->get('assigned_qty')) {
            return redirect()->back()->withInput()->with('error', trans('admin/components/message.checkout.unavailable', ['remaining' => $max_to_checkout, 'requested' => $request->get('assigned_qty')]));
        }

        $validator = Validator::make($request->all(), [
            'asset_id'          => 'required|exists:assets,id',
            'assigned_qty'      => "required|numeric|min:1|digits_between:1,$max_to_checkout",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the user exists
        $asset = Asset::find($request->input('asset_id'));

        // Update the component data
        $component->asset_id = $request->input('asset_id');
        $component->assets()->attach($component->id, [
            'component_id' => $component->id,
            'user_id' => auth()->user(),
            'created_at' => date('Y-m-d H:i:s'),
            'assigned_qty' => $request->input('assigned_qty'),
            'asset_id' => $request->input('asset_id'),
            'note' => $request->input('note'),
        ]);

        event(new CheckoutableCheckedOut($component, $asset, auth()->user(), $request->input('note')));

        return redirect()->route('components.index')->with('success', trans('admin/components/message.checkout.success'));
    }
}
