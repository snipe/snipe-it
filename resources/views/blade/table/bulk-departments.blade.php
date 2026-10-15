@can('delete', \App\Models\Department::class)
    <x-table.bulk-actions
        name="department"
        :action_route="route('departments.bulk.delete')"
        model_name="department"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
