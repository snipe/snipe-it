@canany(['update', 'delete'], \App\Models\Location::class)
    <x-table.bulk-actions
        name="locations"
        :action_route="route('locations.bulkdelete.show')"
        model_name="location"
        :actions="[
            'edit' => ['label' => trans('general.bulk_edit')],
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcanany
