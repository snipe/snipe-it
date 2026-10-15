@can('delete', \App\Models\MaintenanceType::class)
    <x-table.bulk-actions
        name="maintenancetype"
        :action_route="route('maintenance-types.bulk.delete')"
        model_name="maintenanceType"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
