@can('delete', \App\Models\Company::class)
    <x-table.bulk-actions
        name="company"
        :action_route="route('companies.bulk.delete')"
        model_name="company"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
