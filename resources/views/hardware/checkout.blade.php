@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/general.checkout') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <style>

        .input-group {
            padding-left: 0px !important;
        }
    </style>

    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <div class="box box-default">
                <form class="form-horizontal" method="post" action="" autocomplete="off">
                    <div class="box-header with-border">
                        <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h2>
                    </div>
                    <div class="box-body">
                        {{csrf_field()}}
                        @if ($asset->company && $asset->company->name)
                            <div class="form-group">
                                <label for="company" class="col-md-3 control-label">
                                    {{ trans('general.company') }}
                                </label>
                                <div class="col-md-8">
                                    <p class="form-control-static">
                                        {{ $asset->company->name }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- AssetModel name -->
                        <div class="form-group">
                            <label for="model" class="col-md-3 control-label">
                                {{ trans('admin/hardware/form.model') }}
                            </label>
                            <div class="col-md-8">
                                <p class="form-control-static">
                                    @if (($asset->model) && ($asset->model->name))
                                        {{ $asset->model->name }}
                                    @else
                                        <span class="text-danger text-bold">
                                              <x-icon type="warning" />
                                              {{ trans('admin/hardware/general.model_invalid')}}
                                        </span>

                                        {{ trans('admin/hardware/general.model_invalid_fix')}}
                                        <a href="{{ route('hardware.edit', $asset->id) }}">
                                            <strong>{{ trans('admin/hardware/general.edit') }}</strong>
                                        </a>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Asset Name -->
                        <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                            <label for="name" class="col-md-3 control-label">
                                {{ trans('admin/hardware/form.name') }}
                            </label>

                            <div class="col-md-8">
                                <input class="form-control" type="text" name="name" id="name"
                                       value="{{ old('name', $asset->name) }}" tabindex="1">
                                {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
                            <label for="status_id" class="col-md-3 control-label">
                                {{ trans('admin/hardware/form.status') }}
                            </label>
                            <div class="col-md-7 required">
                                {{ Form::select('status_id', $statusLabel_list, $asset->status_id, array('class'=>'select2', 'style'=>'width:100%','', 'aria-label'=>'status_id')) }}
                                {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true'])

                        @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_user'])

                        <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                        @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;'])

                        @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;'])



                        <!-- Checkout/Checkin Date -->
                        <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                            <label for="checkout_at" class="col-md-3 control-label">
                                {{ trans('admin/hardware/form.checkout_date') }}
                            </label>
                            <div class="col-md-8">
                                <div class="input-group date col-md-7" data-provide="datepicker"
                                     data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                                    <input type="text" class="form-control"
                                           placeholder="{{ trans('general.select_date') }}" name="checkout_at"
                                           id="checkout_at" value="{{ old('checkout_at', date('Y-m-d')) }}">
                                    <span class="input-group-addon">
                                        <x-icon type="calendar" /></span>
                                </div>
                                {!! $errors->first('checkout_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Expected Checkin Date -->
                        <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                            <label for="expected_checkin" class="col-md-3 control-label">
                                {{ trans('admin/hardware/form.expected_checkin') }}
                            </label>

                            <div class="col-md-8">
                                <div class="input-group date col-md-7" data-provide="datepicker"
                                     data-date-format="yyyy-mm-dd" data-date-start-date="0d" data-date-clear-btn="true">
                                    <input type="text" class="form-control"
                                           placeholder="{{ trans('general.select_date') }}" name="expected_checkin"
                                           id="expected_checkin" value="{{ old('expected_checkin') }}">
                                    <span class="input-group-addon">
                                        <x-icon type="calendar" />
                                    </span>
                                </div>
                                {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Custom fields -->
                        @include("models/custom_fields_form", [
                                'model' => $asset->model,
                                'show_display_checkout_fields' => 'true'
                        ])

                        <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            <label for="note" class="col-md-3 control-label">
                                {{ trans('general.notes') }}
                            </label>

                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" @required($snipeSettings->require_checkinout_notes)
                                          name="note">{{ old('note', $asset->note) }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        @if ($asset->requireAcceptance() || $asset->getEula() || ($snipeSettings->webhook_endpoint!=''))
                            <div class="form-group notification-callout">
                                <div class="col-md-8 col-md-offset-3">
                                    <div class="callout callout-info">

                                        @if ($asset->requireAcceptance())
                                            <x-icon type="email" />
                                            {{ trans('admin/categories/general.required_acceptance') }}
                                            <br>
                                        @endif

                                        @if ($asset->getEula())
                                            <x-icon type="email" />
                                            {{ trans('admin/categories/general.required_eula') }}
                                            <br>
                                        @endif

                                        @if ($snipeSettings->webhook_endpoint!='')
                                            <i class="fab fa-slack" aria-hidden="true"></i>
                                            {{ trans('general.webhook_msg_note') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div> <!--/.box-body-->

                    <x-redirect_submit_options
                            index_route="hardware.index"
                            :button_label="trans('general.checkout')"
                            :disabled_select="!$asset->model"
                            :options="[
                                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => trans('general.assets')]),
                                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.asset')]),
                                'target' => trans('admin/hardware/form.redirect_to_checked_out_to'),

                               ]"
                    />

                </form>
            </div>
        </div> <!--/.col-md-7-->

        <!-- right column -->
        <div class="col-md-5" id="current_assets_box" style="display:none;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('admin/users/general.current_assets') }}</h2>
                </div>
                <div class="box-body">
                    <div id="current_assets_content">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('moar_scripts')
    @include('partials/assets-assigned')

    <script>
        //        $('#checkout_at').datepicker({
        //            clearBtn: true,
        //            todayHighlight: true,
        //            endDate: '0d',
        //            format: 'yyyy-mm-dd'
        //        });


    </script>
@stop
