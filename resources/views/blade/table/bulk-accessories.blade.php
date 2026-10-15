@can('delete', \App\Models\Accessory::class)
    <x-table.bulk-actions
        name="accessories"
        :action_route="route('accessories.bulk.delete')"
        model_name="accessory"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
