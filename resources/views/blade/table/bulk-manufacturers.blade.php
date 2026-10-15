@can('delete', \App\Models\Manufacturer::class)
    <x-table.bulk-actions
        name="manufacturer"
        :action_route="route('manufacturers.bulk.delete')"
        model_name="manufacturer"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
