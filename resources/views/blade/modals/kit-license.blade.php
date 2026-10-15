{{-- $kitId is passed by ModalController::show. See snipeit_modals.js. --}}
<x-modals
    :title="trans('admin/kits/general.append_license')"
    :action="route('api.kits.licenses.store', $kitId)"
    submitToSelect2
>
    <x-input.license-select
        name="license"
        id="modal_license_select"
        :label="trans('general.license')"
        required
    />

    <x-form.row
        name="quantity"
        :label="trans('general.quantity')"
        id="modal-quantity_id"
        type="number"
        default="1"
        :min="1"
        required
    />
</x-modals>
