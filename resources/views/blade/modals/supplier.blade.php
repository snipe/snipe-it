{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/suppliers/table.create')"
    :action="route('api.suppliers.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('admin/suppliers/table.name')" id="modal-name" required />
    <x-form.row name="contact" :label="trans('admin/suppliers/table.contact')" id="modal-contact" />
    <x-form.row name="url" :label="trans('general.url')" id="modal-url" />
    <x-form.row
        name="phone"
        :label="trans('admin/suppliers/table.phone')"
        id="modal-phone"
        type="tel"
       
        input_icon="phone"
        input_group_addon="left"
    />
    <x-form.row
        name="fax"
        :label="trans('admin/suppliers/table.fax')"
        id="modal-fax"
        type="tel"
       
        input_icon="fax"
        input_group_addon="left"
    />
    <x-form.row
        name="email"
        :label="trans('admin/suppliers/table.email')"
        id="modal-email"
        type="email"
       
        input_icon="envelope"
        input_group_addon="left"
    />
    <x-form.row
        name="notes"
        :label="trans('general.notes')"
        id="modal-notes"
        type="textarea"
       
        :rows="3"
    />
</x-modals>
