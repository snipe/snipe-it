@can('delete', \App\Models\License::class)
    <x-table.bulk-actions
        name="licenses"
        :action_route="route('licenses.bulk.delete')"
        model_name="license"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
            'delete_with_checkin' => ['label' => trans('admin/licenses/general.bulk.delete_with_checkin.label')],
        ]"
    />
@endcan
