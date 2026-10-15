{{-- See snipeit_modals.js for what powers this --}}
<x-modals
    :title="trans('admin/locations/table.create')"
    :action="route('api.locations.store')"
    submitToSelect2
>
    <x-form.row name="name" :label="trans('general.name')" id="modal-name" required />

    {{-- Scoped-locations FMCS pins the new location to the creator's
         first company. When enabled we submit company_id as a hidden
         field and skip the picker. Otherwise the user picks the
         company via select2. --}}
    @if (($snipeSettings->scope_locations_fmcs == '1') && (auth()->user()->companies->isNotEmpty()))
        <input type="hidden" name="company_id" id="modal-company_id" value="{{ auth()->user()->companies->first()->id }}">
    @else
        {{-- Explicit id so the modal's company picker doesn't collide with
             an outer page's company picker (which also renders as
             #company_id_select). Duplicate ids leave select2 bound to the
             wrong element and the dropdown never opens. --}}
        <x-input.company-select
            name="company_id"
            id="modal_company_id_select"
            :label="trans('general.company')"
        />
    @endif

    <x-form.row name="city" :label="trans('general.city')" id="modal-city" />

    <x-form.row name="country" :label="trans('general.country')">
        <x-slot:input>
            <x-input.country-select
                name="country"
                :selected="old('country')"
                id="modal-country"
            />
        </x-slot:input>
    </x-form.row>
</x-modals>
