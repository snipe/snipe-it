@aware(['name'])

@canany(['update', 'checkout', 'checkin', 'audit', 'delete', 'create'], \App\Models\Asset::class)
    <x-table.bulk-actions
        :name="$name"
        :action_route="route('hardware.bulkedit.show')"
        model_name="assets"
        :actions="[
            'edit' => ['label' => trans('general.bulk_edit')],
            'maintenance' => ['label' => trans('button.add_maintenance')],
            'checkout' => ['label' => trans('general.bulk_checkout')],
            'checkin' => ['label' => trans('admin/hardware/general.bulk_checkin')],
            'audit' => ['label' => trans('admin/hardware/general.bulk_audit')],
            'delete' => ['label' => trans('general.bulk_delete')],
            'labels' => ['label' => trans_choice('button.generate_labels', 2)],
            'restore' => ['label' => trans('button.restore')],
        ]"
    />
@endcanany
