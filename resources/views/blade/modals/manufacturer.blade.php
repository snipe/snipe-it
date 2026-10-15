{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/manufacturers/table.create')"
    :action="route('api.manufacturers.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('admin/manufacturers/table.name')" id="modal-name" required />
</x-modals>
