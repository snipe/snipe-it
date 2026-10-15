@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ trans('admin/components/general.update') }}
    @else
        {{ trans('admin/components/general.create') }}
    @endif
    @parent
@stop

{{-- Page content --}}
@section('content')

<x-container class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

    <x-form :$item route="{{ isset($item->id) ? route('components.update', ['component' => $item->id]) : route('components.store') }}">

        <x-box top_submit>
            @if ($item->id)
                <x-slot:header>{{ $item->name }}</x-slot:header>
            @endif

            <x-input.company-select
                :label="trans('general.company')"
                name="company_id"
                :selected="old('company_id', $item->company_id)"
            />

            <x-form.row
                :label="trans('admin/components/table.title')"
                :$item
                name="name"
            />

            <x-input.category-select
                :label="trans('general.category')"
                name="category_id"
                :selected="old('category_id', $item->category_id)"
                required
                categoryType="component"
            />

            <x-input.minimum-quantity :item="$item" />

            <x-form.row
                :label="trans('admin/hardware/form.serial')"
                :$item
                name="serial"
            />

            <x-input.manufacturer-select
                :label="trans('general.manufacturer')"
                name="manufacturer_id"
                :selected="old('manufacturer_id', $item->manufacturer_id)"
            />

            <x-form.row
                :label="trans('general.model_no')"
                :$item
                name="model_number"
            />

            <x-input.location-select
                :label="trans('general.location')"
                name="location_id"
                :selected="old('location_id', $item->location_id)"
            />

            {{-- Acquisition metadata + qty are all create-only. See
                 accessories/edit for the full rationale. Post-create
                 changes flow through the adjust-quantity modal and
                 land as Order + OrderItem rows. --}}
            @if (! $item->id)
                <x-input.supplier-select
                    :label="trans('general.supplier')"
                    name="supplier_id"
                    :selected="old('supplier_id', $item->supplier_id)"
                />

                <x-form.row
                    :label="trans('general.order_number')"
                    :$item
                    name="order_number"
                />

                <x-form.row
                    :label="trans('general.purchase_date')"
                    name="purchase_date"
                    type="datepicker"
                    :item="$item"
                    input_div_class="col-md-4"
                />

                <x-input.purchase-cost
                    :label="trans('general.unit_cost')"
                    :item="$item"
                    :currencyType="$item->location->currency ?? null"
                />

                <x-form.row
                    :label="trans('general.currency')"
                    name="currency"
                    input_div_class="col-md-3"
                    :help_text="trans('general.currency_prefilled_hint')"
                >
                    <x-slot:input>
                        <input
                            type="text"
                            class="form-control"
                            id="currency"
                            name="currency"
                            maxlength="10"
                            value="{{ old('currency', $item->location->currency ?? $snipeSettings->default_currency) }}"
                            aria-label="{{ trans('general.currency') }}"
                        />
                    </x-slot:input>
                </x-form.row>

                <x-input.quantity :item="$item" />
            @endif

            <x-input.supplier-select
                :label="trans('general.default_supplier')"
                name="default_supplier_id"
                :selected="old('default_supplier_id', $item->default_supplier_id)"
            />

            <x-form.row
                :label="trans('general.notes')"
                :$item
                name="notes"
                type="textarea"
            />

            <x-input.image-upload :item="$item" :imagePath="app('components_upload_path')" />

            <x-form.checkbox-row
                name="requestable"
                :label="trans('admin/hardware/general.requestable')"
                :item="$item"
            />

            <x-slot:customfooter>
                <x-redirect_submit_options
                    index_route="components.index"
                    :button_label="trans('general.save')"
                    :options="[
                        'back' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.previous_page')]),
                        'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'components']),
                        'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.component')]),
                    ]"
                />
            </x-slot:customfooter>

        </x-box>

    </x-form>

</x-container>

@stop
