{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/maintenance_types/general.create')"
    :action="route('api.maintenance-types.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('general.name')" id="modal-name" required />
</x-modals>
