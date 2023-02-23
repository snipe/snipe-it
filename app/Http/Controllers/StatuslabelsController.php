<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Statuslabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * This controller handles all actions related to Status Labels for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class StatuslabelsController extends Controller
{
    /**
     * Show a list of all the statuslabels.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Statuslabel::class);

        return view('statuslabels.index');
    }

    public function show($id)
    {
        $this->authorize('view', Statuslabel::class);
        if ($statuslabel = Statuslabel::find($id)) {
            return view('statuslabels.view')->with('statuslabel', $statuslabel);
        }

        return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
    }

    /**
     * Statuslabel create.
     *
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        // Show the page
        $this->authorize('create', Statuslabel::class);

        return view('statuslabels/edit')
            ->with('item', new Statuslabel)
            ->with('statuslabel_types', Helper::statusTypeList());
    }

    /**
     * Statuslabel create form processing.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Statuslabel::class);
        // create a new model instance
        $statusLabel = new Statuslabel();

        if ($request->missing('statuslabel_types')) {
            return redirect()->back()->withInput()->withErrors(['statuslabel_types' => trans('validation.statuslabel_type')]);
        }

        $statusType = Statuslabel::getStatuslabelTypesForDB($request->input('statuslabel_types'));

        // Save the Statuslabel data
        $statusLabel->name = $request->input('name');
        $statusLabel->user_id = Auth::id();
        $statusLabel->notes = $request->input('notes');
        $statusLabel->deployable = $statusType['deployable'];
        $statusLabel->pending = $statusType['pending'];
        $statusLabel->archived = $statusType['archived'];
        $statusLabel->color = $request->input('color');
        $statusLabel->show_in_nav = $request->input('show_in_nav', 0);
        $statusLabel->default_label = $request->input('default_label', 0);

        if ($statusLabel->save()) {
            // Redirect to the new Statuslabel  page
            return redirect()->route('statuslabels.index')->with('success', trans('admin/statuslabels/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($statusLabel->getErrors());
    }

    /**
     * Statuslabel update.
     *
     * @param  int $statuslabelId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($statuslabelId = null)
    {
        $this->authorize('update', Statuslabel::class);
        // Check if the Statuslabel exists
        if (is_null($item = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        $use_statuslabel_type = $item->getStatuslabelType();

        $statuslabel_types = ['' => trans('admin/hardware/form.select_statustype')] + ['undeployable' => trans('admin/hardware/general.undeployable')] + ['pending' => trans('admin/hardware/general.pending')] + ['archived' => trans('admin/hardware/general.archived')] + ['deployable' => trans('admin/hardware/general.deployable')];

        return view('statuslabels/edit', compact('item', 'statuslabel_types'))->with('use_statuslabel_type', $use_statuslabel_type);
    }

    /**
     * Statuslabel update form processing page.
     *
     * @param  int $statuslabelId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $statuslabelId = null)
    {
        $this->authorize('update', Statuslabel::class);
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        if (! $request->filled('statuslabel_types')) {
            return redirect()->back()->withInput()->withErrors(['statuslabel_types' => trans('validation.statuslabel_type')]);
        }

        // Update the Statuslabel data
        $statustype = Statuslabel::getStatuslabelTypesForDB($request->input('statuslabel_types'));
        $statuslabel->name = $request->input('name');
        $statuslabel->notes = $request->input('notes');
        $statuslabel->deployable = $statustype['deployable'];
        $statuslabel->pending = $statustype['pending'];
        $statuslabel->archived = $statustype['archived'];
        $statuslabel->color = $request->input('color');
        $statuslabel->show_in_nav = $request->input('show_in_nav', 0);
        $statuslabel->default_label = $request->input('default_label', 0);

        // Was the asset created?
        if ($statuslabel->save()) {
            // Redirect to the saved Statuslabel page
            return redirect()->route('statuslabels.index')->with('success', trans('admin/statuslabels/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($statuslabel->getErrors());
    }

    /**
     * Delete the given Statuslabel.
     *
     * @param  int $statuslabelId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($statuslabelId)
    {
        $this->authorize('delete', Statuslabel::class);
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.not_found'));
        }

        // Check that there are no assets associated
        if ($statuslabel->assets()->count() == 0) {
            $statuslabel->delete();

            return redirect()->route('statuslabels.index')->with('success', trans('admin/statuslabels/message.delete.success'));
        }

        return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.assoc_assets'));
    }
}
