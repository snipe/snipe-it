<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MaintenanceTypesController extends Controller
{
    public function index(): View
    {
        $this->authorize('index', MaintenanceType::class);

        return view('maintenance-types.index');
    }

    public function create(): View
    {
        $this->authorize('create', MaintenanceType::class);

        return view('maintenance-types.edit')->with('item', new MaintenanceType);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', MaintenanceType::class);

        $type = new MaintenanceType;
        $type->name = $request->input('name');
        $type->tag_color = $request->input('tag_color');
        $type->created_by = auth()->id();

        if ($type->save()) {
            return redirect()->route('maintenance-types.index')
                ->with('success', trans('admin/maintenance_types/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($type->getErrors());
    }

    public function show(MaintenanceType $maintenanceType): View
    {
        $this->authorize('view', $maintenanceType);

        return view('maintenance-types.view')->with('item', $maintenanceType);
    }

    public function edit(MaintenanceType $maintenanceType): View
    {
        $this->authorize('update', $maintenanceType);

        return view('maintenance-types.edit')->with('item', $maintenanceType);
    }

    public function update(Request $request, MaintenanceType $maintenanceType): RedirectResponse
    {
        $this->authorize('update', $maintenanceType);

        $maintenanceType->name = $request->input('name');
        $maintenanceType->tag_color = $request->input('tag_color');

        if ($maintenanceType->save()) {
            return redirect()->route('maintenance-types.index')
                ->with('success', trans('admin/maintenance_types/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($maintenanceType->getErrors());
    }

    public function destroy(MaintenanceType $maintenanceType): RedirectResponse
    {
        $this->authorize('delete', $maintenanceType);

        // Same guard as the API destroy: refuse when any maintenance row
        // still references this type so we don't strand orphaned
        // maintenance_type_id values on a soft-deleted parent.
        if (! $maintenanceType->isDeletable()) {
            return redirect()->route('maintenance-types.index')
                ->with('error', trans('general.bulk_delete_associations.assoc_maintenances', [
                    'item_name' => $maintenanceType->name,
                    'maintenance_count' => $maintenanceType->maintenances()->count(),
                    'item' => trans('admin/maintenance_types/general.maintenance_type'),
                ]));
        }

        $maintenanceType->delete();

        return redirect()->route('maintenance-types.index')
            ->with('success', trans('admin/maintenance_types/message.delete.success'));
    }
}
