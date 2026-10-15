{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/companies/table.create')"
    :action="route('api.companies.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('general.name')" id="modal-name" required />

    <x-input.company-select
        name="parent_id"
        id="modal_parent_id_select"
        :label="trans('admin/companies/table.parent')"
        onlyTopLevel
    />
</x-modals>
