@props([
    'item' => null,
    'hasAddress2' => true,
])

<x-form.row
    :label="trans('general.address')"
    :$item
    name="address"
    input_div_class="col-md-7"
/>

@if ($hasAddress2)
    <x-form.row
        :label="trans('general.address')"
        :$item
        name="address2"
        label_class="sr-only"
        input_div_class="col-md-7 col-md-offset-3"
    />
@endif

<x-form.row
    :label="trans('general.city')"
    :$item
    name="city"
    input_div_class="col-md-7"
/>

<x-form.row
    :label="trans('general.state')"
    :$item
    name="state"
    input_div_class="col-md-7"
/>

<x-form.row
    :label="trans('general.country')"
    name="country"
    input_div_class="col-md-7"
    :help_text="trans('general.countries_manually_entered_help')"
>
    <x-slot:input>
        <x-input.country-select
            name="country"
            :selected="old('country', $item?->country)"
        />
    </x-slot:input>
</x-form.row>

<x-form.row
    :label="trans('general.zip')"
    :$item
    name="zip"
    input_div_class="col-md-3"
/>
