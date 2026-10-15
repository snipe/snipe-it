@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ trans('admin/licenses/form.update') }}
    @else
        {{ trans('admin/licenses/form.create') }}
    @endif
    @parent
@stop

{{-- Page content --}}
@section('content')

    <x-container class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

        <x-form :$item route="{{ ($item->id) ? route('licenses.update', ['license' => $item->id]) : route('licenses.store') }}">

            <x-box top_submit>
                @if ($item->id)
                    <x-slot:header></x-slot:header>
                @endif

                <x-input.company-select
                    :label="trans('general.company')"
                    name="company_id"
                    :selected="old('company_id', $item->company_id)"
                />

                <x-form.row
                    :label="trans('general.name')"
                    :$item
                    name="name"
                />

                <x-input.category-select
                    :label="trans('general.category')"
                    name="category_id"
                    :selected="old('category_id', $item->category_id)"
                    required
                    categoryType="license"
                />

                <x-form.row
                    :label="trans('admin/licenses/form.seats')"
                    :$item
                    name="seats"
                    type="number"
                    :min="0"
                    input_div_class="col-md-2"
                />

                <x-input.minimum-quantity :item="$item"/>

                @can('viewKeys', $item)
                    <x-form.row
                        :label="trans('admin/licenses/form.license_key')"
                        :$item
                        name="serial"
                        type="textarea"
                        :rows="5"
                        input_div_class="col-md-7"
                    />
                @endcan

                <x-input.manufacturer-select
                    :label="trans('general.manufacturer')"
                    name="manufacturer_id"
                    :selected="old('manufacturer_id', $item->manufacturer_id)"
                />

                <x-form.row
                    :label="trans('admin/licenses/form.to_name')"
                    :$item
                    name="license_name"
                    input_div_class="col-md-7"
                />

                <x-form.row
                    :label="trans('admin/licenses/form.to_email')"
                    :$item
                    name="license_email"
                    type="email"
                    input_div_class="col-md-7"
                />

                {{-- Reassignable defaults to CHECKED for new licenses (see the
                     old() fallback) since it's the most common use-case.
                     <x-form.checkbox-row>'s single-mode falls
                     back to `$item->{$name} ?? false`, which would default new
                     records to unchecked. Hand-authored here to preserve the
                      old behavior. --}}
                <div class="form-group {{ $errors->has('reassignable') ? ' has-error' : '' }}">
                    <div class="col-md-3 control-label">
                        <strong>{{ trans('admin/licenses/form.reassignable') }}</strong>
                    </div>
                    <div class="col-md-7">
                        <label class="form-control">
                            <input type="checkbox" name="reassignable" value="1" aria-label="reassignable" @checked(old('reassignable', $item->id ? $item->reassignable : '1'))>
                            {{ trans('general.yes') }}
                        </label>
                    </div>
                </div>

                <x-input.supplier-select
                    :label="trans('general.supplier')"
                    name="supplier_id"
                    :selected="old('supplier_id', $item->supplier_id)"
                />

                <x-form.row
                    :label="trans('general.order_number')"
                    :$item
                    name="order_number"
                    input_div_class="col-md-7 col-sm-12"
                />
                <x-input.purchase-cost :item="$item"/>

                <x-form.row
                    :label="trans('general.purchase_date')"
                    name="purchase_date"
                    type="datepicker"
                    :item="$item"
                    input_div_class="col-md-4"
                />

                <x-form.row
                    :label="trans('admin/licenses/form.expiration')"
                    name="expiration_date"
                    type="datepicker"
                    :item="$item"
                    input_div_class="col-md-4"
                />

                <x-form.row
                    :label="trans('admin/licenses/form.termination_date')"
                    name="termination_date"
                    type="datepicker"
                    :item="$item"
                    input_div_class="col-md-4"
                />

                <x-form.row
                    :label="trans('admin/licenses/form.purchase_order')"
                    :$item
                    name="purchase_order"
                    input_div_class="col-md-3"
                />

                <x-form.row
                    :label="trans('general.depreciation')"
                    name="depreciation_id"
                    input_div_class="col-md-7"
                >
                    <x-slot:input>
                        <x-input.select
                            name="depreciation_id"
                            id="depreciation_id"
                            :options="$depreciation_list"
                            :selected="old('depreciation_id', $item->depreciation_id)"
                            style="width:350px;"
                            aria-label="depreciation_id"
                        />
                    </x-slot:input>
                </x-form.row>

                <x-form.checkbox-row
                    name="maintained"
                    :label="trans('admin/licenses/form.maintained')"
                    :item="$item"
                />

                <x-form.checkbox-row
                    name="requestable"
                    :label="trans('admin/hardware/general.requestable')"
                    :item="$item"
                />

                <x-form.row
                    :label="trans('general.notes')"
                    :$item
                    name="notes"
                    type="textarea"
                    input_div_class="col-md-7 col-sm-12"
                />

                <x-slot:customfooter>
                    <x-redirect_submit_options
                        index_route="licenses.index"
                        :button_label="trans('general.save')"
                        :options="[
                            'back' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.previous_page')]),
                            'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'licenses']),
                            'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.license')]),
                        ]"
                    />
                </x-slot:customfooter>

            </x-box>

        </x-form>

    </x-container>

@stop
