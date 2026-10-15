@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/general.bulk_audit') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <style>
        .input-group {
            padding-left: 0px !important;
        }
    </style>

    <x-container class="col-md-8 col-md-offset-2">
        <x-form :route="route('hardware.bulk-audit.store')" data-disable-empty-on-submit>
            <x-box>
                <x-slot:header>
                    {{ trans('admin/hardware/general.bulk_audit') }}
                </x-slot:header>

                <x-input.asset-select
                    :label="trans('general.assets')"
                    name="selected_assets"
                    :multiple="true"
                    :required="true"
                    :selected="old('selected_assets')"
                />

                {{-- Location controls: hidden entirely when the
                     selection spans multiple companies AND FMCS
                     location scoping is on, since a shared location
                     can't legitimately fit assets from different
                     companies under that mode. When one shared
                     company is detected, the picker is scoped so
                     only that company's locations show. Otherwise
                     the picker is unscoped, matching the pre-existing
                     behavior. All three cases are decided server-side
                     in BulkAssetsController::auditLocationVisibility. --}}
                @if ($hideLocationFields)
                    <p class="help-block col-md-8 col-md-offset-3">
                        {{ trans('admin/hardware/general.bulk_audit_location_hidden_mixed_companies') }}
                    </p>
                @else
                    <x-input.location-select
                        :label="trans('general.location')"
                        name="location_id"
                        :selected="old('location_id')"
                        :companyId="$sharedCompanyId"
                    />

                    {{-- When unchecked (default), the location above is
                         only recorded on each audit log entry (as
                         "where the audit happened"). When checked, the
                         assets' physical location_id is also
                         overwritten to that location. --}}
                    <x-form.checkbox-row
                        name="update_location"
                        :label="trans('admin/hardware/form.asset_location')"
                        help_html="{!! trans('help.audit_help') !!}"
                    />
                @endif

                {{-- Next audit date. Prefilled with today + audit_interval
                     from settings so users can accept the calculated
                     default or override for this batch. --}}
                <x-form.row
                    :label="trans('general.next_audit_date')"
                    name="next_audit_date"
                    type="datepicker"
                    :default="$next_audit_date"
                    input_div_class="col-md-4"
                />

                {{-- Shared note applied to every audit log entry. --}}
                <x-form.row
                    :label="trans('general.notes')"
                    name="note"
                    type="textarea"
                />

                {{-- Shared audit image. If uploaded, the same file is
                     saved per-asset (audit-{id}-...) and attached to
                     every audit log entry --}}
                <x-input.image-upload fieldname="file[0]" :helpText="trans('general.audit_images_help')" />

                <x-slot:customfooter>
                    <div class="box-footer">
                        <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                        <x-button.submit class="btn-success pull-right" :label="trans('admin/hardware/general.bulk_audit')" />
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>
@stop
