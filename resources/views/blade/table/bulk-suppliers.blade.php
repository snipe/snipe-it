@can('delete', \App\Models\Supplier::class)
    <x-table.bulk-actions
        name="supplier"
        :action_route="route('suppliers.bulk.delete')"
        model_name="supplier"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
