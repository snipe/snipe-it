<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Company;
use App\Models\Component;
use App\Helpers\Helper;
use App\Models\Serial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * This class controls all actions related to Components for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ComponentsController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the components listing, which is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::getDatatable() method that generates the JSON response
     * @since [v3.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Component::class);

        return view('components/index');
    }


    /**
     * Returns a form to create a new component.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::postCreate() method that stores the data
     * @since [v3.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Component::class);

        return view('components/edit')->with('category_type', 'component')
            ->with('item', new Component);
    }

    /**
     * Validate and store data for new component.
     *
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException*@throws \Throwable
     * @see ComponentsController::getCreate() method that generates the view
     * @since [v3.0]
     * @author [A. Gianotto] [<snipe@snipe.net>]
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Component::class);
        $component = new Component();
        $component->name                   = $request->input('name');
        $component->category_id            = $request->input('category_id');
        $component->location_id            = $request->input('location_id');
        $component->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $component->order_number           = $request->input('order_number', null);
        $component->min_amt                = $request->input('min_amt', null);
        $component->serial                 = $request->input('serial', null);
        $component->purchase_date          = $request->input('purchase_date', null);
        $component->purchase_cost          = Helper::ParseCurrency($request->input('purchase_cost', null));
        $component->qty                    = $request->input('qty');
        $component->user_id                = Auth::id();
        $component->notes                  = $request->input('notes');

        $component = $request->handleImages($component);

        if ($component->save()) {

            // If serial is not empty, explode it into an array and save each serial to the serials table.
            // Check if the serials do not already exist in the database using the Serial model.
            if (!empty($component->serial)) {
                // Break the serials into an array and remove empty values.
                $serials = preg_split('/[\s,]+/', $component->serial);
                $this->saveSerials($serials, $component);

                // If the serials are saved, set the component serial to null.
                if ($this->verifySerialsSavedToDb($serials)) {
                    $component->serial = null;
                    $component->save();
                }
            }

            return redirect()->route('components.index')->with('success', trans('admin/components/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($component->getErrors());
    }

    /**
     * This method checks if the serials already exist in the database.
     *
     * @param $serials
     * @return bool
     */
    private function verifySerialsSavedToDb($serials): bool
    {
        $serialsSavedCount = Serial::whereIn('serial_number', $serials)->count();
        $serialsCount = count($serials);

        return $serialsSavedCount === $serialsCount;
    }

    /**
     * @param $serials
     * @param $component
     * @return void
     * @throws \Throwable
     */
    private function saveSerials($serials, $component)
    {
        // Remove empty values from the array.
        $serials = array_filter($serials);

        foreach ($serials as $serial) {
            try {
                $serial = trim($serial);
                $serial_exists = Serial::where('serial_number', '=', $serial)->exists();

                if ($serial_exists !== true) {
                    // Add the serial to the serials table
                    $record = new Serial();
                    $record->serial_number = $serial;
                    $record->component_id = $component->id;
                    $record->notes = null;
                    $record->saveOrFail();
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }

    /**
     * Return a view to edit a component.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::postEdit() method that stores the data.
     * @since [v3.0]
     * @param int $componentId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($componentId = null)
    {
        if ($item = Component::find($componentId)) {
            $this->authorize('update', $item);

            return view('components/edit', compact('item'))->with('category_type', 'component');
        }

        return redirect()->route('components.index')->with('error', trans('admin/components/message.does_not_exist'));
    }


    /**
     * Return a view to edit a component.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::getEdit() method presents the form.
     * @param ImageUploadRequest $request
     * @param int $componentId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v3.0]
     */
    public function update(ImageUploadRequest $request, $componentId = null)
    {
        if (is_null($component = Component::find($componentId))) {
            return redirect()->route('components.index')->with('error', trans('admin/components/message.does_not_exist'));
        }
        $min = $component->numCheckedOut();
        $validator = Validator::make($request->all(), [
            'qty' => "required|numeric|min:$min",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $this->authorize('update', $component);

        // Update the component data
        $component->name                   = $request->input('name');
        $component->category_id            = $request->input('category_id');
        $component->location_id            = $request->input('location_id');
        $component->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $component->order_number           = $request->input('order_number');
        $component->min_amt                = $request->input('min_amt');
        $component->serial                 = $request->input('serial');
        $component->purchase_date          = $request->input('purchase_date');
        $component->purchase_cost          = Helper::ParseCurrency(request('purchase_cost'));
        $component->qty                    = $request->input('qty');
        $component->notes                  = $request->input('notes');

        $component = $request->handleImages($component);

        if ($component->save()) {
            // If serial is not empty, explode it into an array and save each serial to the serials table.
            // Check if the serials do not already exist in the database using the Serial model.
            if (!empty($component->serial)) {
                // Separate the serials by comma or new line.
                $serials = preg_split('/[\s,]+/', $component->serial);
                $this->saveSerials($serials, $component);

                // If the serials are saved, set the component serial to null.
                if ($this->verifySerialsSavedToDb($serials)) {
                    $component->serial = null;
                    $component->save();
                }
            }

            return redirect()->route('components.index')->with('success', trans('admin/components/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($component->getErrors());
    }

    /**
     * Delete a component.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param int $componentId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($componentId)
    {
        if (is_null($component = Component::find($componentId))) {
            return redirect()->route('components.index')->with('error', trans('admin/components/message.does_not_exist'));
        }

        $this->authorize('delete', $component);

        // Remove the image if one exists
        if (Storage::disk('public')->exists('components/'.$component->image)) {
            try {
                Storage::disk('public')->delete('components/'.$component->image);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        $component->delete();

        return redirect()->route('components.index')->with('success', trans('admin/components/message.delete.success'));
    }

    /**
     * Return a view to display component information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::getDataView() method that generates the JSON response
     * @since [v3.0]
     * @param int $componentId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($componentId = null)
    {
        $component = Component::with('serials.asset')->find($componentId);

        if (isset($component->id)) {
            $this->authorize('view', $component);

            return view('components/view', compact('component'));
        }
        // Redirect to the user management page
        return redirect()->route('components.index')
            ->with('error', trans('admin/components/message.does_not_exist'));
    }
}
