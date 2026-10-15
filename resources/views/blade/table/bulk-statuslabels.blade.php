@can('delete', \App\Models\Statuslabel::class)
    <x-table.bulk-actions
        name="statuslabel"
        :action_route="route('statuslabels.bulk.delete')"
        model_name="statuslabel"
        :actions="[
            'delete' => ['label' => trans('general.delete')],
        ]"
    />
@endcan
