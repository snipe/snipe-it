@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/general.bulk_checkin') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <style>
        .input-group {
            padding-left: 0px !important;
        }
    </style>

    <x-container columns="2">

        <x-page-column class="col-md-7">
            <x-form :route="route('hardware.bulkcheckin.store')" data-disable-empty-on-submit>
                <x-box>
                    <x-slot:header>
                        {{ trans('admin/hardware/form.tag') }}
                    </x-slot:header>

                    <x-input.asset-select
                        :label="trans('general.assets')"
                        name="selected_assets"
                        :multiple="true"
                        :required="true"
                        assetStatusType="Deployed"
                        :selected="old('selected_assets')"
                    />

                    {{-- Status --}}
                    <x-form.row
                        :label="trans('admin/hardware/form.status')"
                        name="status_id"
                        input_div_class="col-md-7"
                    >
                        <x-slot:input>
                            <x-input.select
                                name="status_id"
                                :options="$statusLabel_list"
                                :selected="old('status_id', $status_id ?? null)"
                                style="width: 100%;"
                                aria-label="status_id"
                            />
                        </x-slot:input>
                    </x-form.row>

                    <x-input.location-select
                        :label="trans('general.location')"
                        name="location_id"
                        :selected="old('location_id')"
                    />

                    {{-- Update actual location --}}
                    <x-form.radio-row
                        name="update_default_location"
                        selected="1"
                        :options="[
                            '1' => trans('admin/hardware/form.asset_location'),
                            '0' => trans('admin/hardware/form.asset_location_update_default_current'),
                        ]"
                    />

                    {{-- Checkin date --}}
                    <x-form.row
                        :label="trans('admin/hardware/form.checkin_date')"
                        name="checkin_at"
                        label_class="col-sm-3"
                        input_div_class="col-md-8"
                    >
                        <x-slot:input>
                            <x-input.datetimepicker
                                id="checkin_at"
                                name="checkin_at"
                                :value="old('checkin_at')"
                                col_size_class="col-md-5"
                            />
                        </x-slot:input>
                    </x-form.row>

                    <x-form.row
                        :label="trans('general.notes')"
                        name="note"
                        type="textarea"
                        label_class="col-sm-3"
                        input_div_class="col-md-8"
                    />

                    {{-- Checkin associated license seats. The hidden
                         partner input ensures a "0" value submits when
                         the checkbox is unchecked (browsers omit
                         unchecked checkboxes entirely, so without the
                         hidden the controller can't distinguish
                         "unchecked" from "field not present"). --}}
                    <input type="hidden" name="checkin_licenses" value="0" />
                    <x-form.checkbox-row
                        name="checkin_licenses"
                        :label="trans('admin/hardware/form.checkin_licenses')"
                        :checked="old('checkin_licenses', '1') == '1'"
                    />

                    {{-- Checkin associated child assets. Same
                         hidden-partner pattern as above. --}}
                    <input type="hidden" name="checkin_child_assets" value="0" />
                    <x-form.checkbox-row
                        name="checkin_child_assets"
                        :label="trans('admin/hardware/form.checkin_child_assets')"
                        :checked="old('checkin_child_assets', '1') == '1'"
                    />

                    <x-slot:customfooter>
                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                            <x-button.submit class="btn-success pull-right" :label="trans('admin/hardware/general.checkin_assets')" />
                        </div>
                    </x-slot:customfooter>
                </x-box>
            </x-form>
        </x-page-column>

        <x-page-column class="col-md-5">
            <x-side-panel.removed-assets
                :items="$removed_assets"
                :message="trans('general.unassigned_assets_removed')"
            />
        </x-page-column>

    </x-container>

@stop
