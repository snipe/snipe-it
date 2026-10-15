{{-- Confirmation modal for marking a maintenance complete. Rendered on any
     page that lists maintenances via `x-table.maintenances`. The bootstrap-
     table actions formatter that emits the green checkmark button lives in
     partials/bootstrap-table.blade.php. The click handler that populates the
     form action and shows this modal lives in resources/assets/js/snipeit.js
     as a delegated `.complete-maintenance` handler. --}}
<x-modals
    id="completeMaintenanceModal"
    stacked
    :title="trans('admin/maintenances/form.mark_complete')"
    :submit_label="trans('admin/maintenances/form.mark_complete')"
    submit_class="btn-success"
    form_attrs='id="completeMaintenanceForm"'
>
    <p>{{ trans('admin/maintenances/message.complete.confirm') }}</p>
    <x-form.row
        name="note"
        id="completionNote"
        type="textarea"
        :rows="3"
        :label="trans('admin/maintenances/form.completion_notes')"
    />
</x-modals>
