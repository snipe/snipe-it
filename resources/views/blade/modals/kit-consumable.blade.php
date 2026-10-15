{{-- $kitId is passed by ModalController::show. See snipeit_modals.js. --}}
<x-modals
    :title="trans('admin/kits/general.append_consumable')"
    :action="route('api.kits.consumables.store', $kitId)"
    submitToSelect2
>
    <x-input.consumable-select
        name="consumable"
        id="modal_consumable_select"
        :label="trans('general.consumable')"
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
