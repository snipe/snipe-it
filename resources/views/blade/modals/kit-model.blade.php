{{-- $kitId is passed by ModalController::show. See snipeit_modals.js. --}}
<x-modals
    :title="trans('admin/kits/general.append_model')"
    :action="route('api.kits.models.store', $kitId)"
    submitToSelect2
>
    <x-input.model-select
        name="model"
        id="modal_model_select"
        :label="trans('general.asset_model')"
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
