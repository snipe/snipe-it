{{-- See snipeit_modals.js for what powers this. $statuslabel_types is
     passed in by ModalController::show. --}}
<x-modals
    :title="trans('admin/statuslabels/table.create')"
    :action="route('api.statuslabels.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('admin/statuslabels/table.name')" id="modal-name" required />

    <x-form.row name="type" :label="trans('admin/statuslabels/table.status_type')" required>
        <x-slot:input>
            <x-input.select
                name="type"
                id="modal-type"
                :options="$statuslabel_types"
                required
                style="width:100%;"
            />
        </x-slot:input>
    </x-form.row>
</x-modals>
