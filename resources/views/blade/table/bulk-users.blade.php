@aware(['name'])

@can('view', \App\Models\User::class)
    <x-table.bulk-actions
        :name="$name"
        :action_route="route('users/bulkedit')"
        model_name="users"
        :actions="[
            'edit' => ['label' => trans('general.bulk_edit')],
            'send_assigned' => ['label' => trans('admin/users/general.email_assigned')],
            'delete' => ['label' => trans('general.bulk_checkin_delete')],
            'merge' => ['label' => trans('general.merge_users')],
            'bulkpasswordreset' => ['label' => trans('button.send_password_link')],
            'print' => ['label' => trans('admin/users/general.print_assigned')],
        ]"
    />
@endcan
