{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/categories/general.create')"
    :action="route('api.categories.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('general.name')" id="modal-name" required />

    <input type="hidden" name="category_type" id="modal-category_type" value="{{ request('category_type') }}">
</x-modals>
