@can('delete', \App\Models\Depreciation::class)
    <x-table.bulk-actions
        name="depreciation"
        :action_route="route('depreciations.bulk.delete')"
        model_name="depreciation"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
