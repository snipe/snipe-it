{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/models/table.create')"
    :action="route('api.models.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('general.name')" id="modal-name" required />

    <x-input.category-select
        name="category_id"
        id="modal_category_id_select"
        :label="trans('general.category')"
        categoryType="asset"
        required
    />

    <x-input.manufacturer-select
        name="manufacturer_id"
        id="modal_manufacturer_id_select"
        :label="trans('general.manufacturer')"
    />

    <x-form.row name="model_number" :label="trans('general.model_no')" id="modal-model_number" />

    <x-form.row name="fieldset_id" :label="trans('admin/models/general.fieldset')">
        <x-slot:input>
            <x-input.select
                name="fieldset_id"
                id="modal-fieldset_id"
                :options="Helper::customFieldsetList()"
                :selected="old('fieldset_id')"
                style="width:100%;"
            />
        </x-slot:input>
    </x-form.row>
</x-modals>
