<?php

namespace App\Http\Controllers\Components;

use App\Events\CheckoutableCheckedOut;
use App\Events\ComponentCheckedOut;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Serial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComponentCheckoutController extends Controller
{
    /**
     * Returns a view that allows the checkout of a component to an asset.
     *
     * @param int $componentId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentCheckoutController::store() method that stores the data.
     * @since [v3.0]
     */
    public function create($componentId)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));
        }
        $this->authorize('checkout', $component);

        $component->load('serials');

        return view('components/checkout', compact('component'));
    }

    /**
     * Validate and store checkout data.
     *
     * @param Request $request
     * @param int $componentId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @see ComponentCheckoutController::create() method that returns the form.
     * @since [v3.0]
     * @author [A. Gianotto] [<snipe@snipe.net>]
     */
    public function store(Request $request, $componentId)
    {
        // Check if the component exists
        if (is_null($component = Component::find($componentId))) {
            // Redirect to the component management page with error
            return redirect()->route('components.index')->with('error', trans('admin/components/message.not_found'));
        }

        $this->authorize('checkout', $component);

        $max_to_checkout = $component->numRemaining();

        $formData = $request->all();

        if (!empty($formData['serials'])) {
            $formData['serials'] = preg_split('/[\s,]+/', $request->input('serials'));
        }

        $validator = Validator::make($formData, [
            'asset_id' => 'required',
            'assigned_qty' => "required|numeric|between:1,$max_to_checkout",
            'serials.*' => [
                'string',
                Rule::exists('serials', 'serial_number')->where(function ($query) use ($componentId) {
                    // Only check for unassigned serials. If the serial is assigned to another asset, it's not available.
                    return $query->where('status', '=', 0);
                }),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin_user = Auth::user();
        $asset_id = e($request->input('asset_id'));

        // Check if the user exists
        if (is_null($asset = Asset::find($asset_id))) {
            // Redirect to the component management page with error
            return redirect()->route('components.index')->with('error', trans('admin/components/message.asset_does_not_exist'));
        }

        // Update the component data
        $component->asset_id = $asset_id;

        $component->assets()->attach($component->id, [
            'component_id' => $component->id,
            'user_id' => $admin_user->id,
            'created_at' => date('Y-m-d H:i:s'),
            'assigned_qty' => $request->input('assigned_qty'),
            'asset_id' => $asset_id,
            'note' => $request->input('note'),
        ]);

        // If we have serials, we need to update them to reflect the new status
        if ($request->filled('serials')) {
            // Break each serial into an array
            $serials = array_filter(preg_split('/[\s,]+/', $request->input('serials')));
            Serial::whereIn('serial_number', $serials)->update(['status' => 1, 'asset_id' => $asset_id, 'updated_at' => Carbon::now()]);
        }

        event(new CheckoutableCheckedOut($component, $asset, Auth::user(), $request->input('note')));

        return redirect()->route('components.index')->with('success', trans('admin/components/message.checkout.success'));
    }
}
