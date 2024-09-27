@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.bulk_checkout') }}
@parent
@stop

{{-- Page content --}}
@section('content')

    <style>
        .input-group {
            padding-left: 0px !important;
            width: 100% !important;
        }
    </style>


    <div class="row">
    {{ Form::open(['method' => 'POST', 'class' => ['form-horizontal','checkout-form'], 'role' => 'form', 'id' => 'checkinout-form' ]) }}
        <!-- left column -->
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} </h2>
                </div>
                <div class="box-body">
                    {{csrf_field()}}
                    <!-- Checkout selector -->
                    @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true'])

                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_user', 'required'=>'true'])
                    @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset_select', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])
                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])

                    <!-- Checkout/Checkin Date -->
                    <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                        <label for="checkout_at" class="col-sm-3 control-label">
                            {{ trans('admin/hardware/form.checkout_date') }}
                        </label>
                        <div class="col-md-8">
                            <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                                <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkout_at" id="checkout_at" value="{{ old('checkout_at') }}">
                                <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                            </div>
                            {!! $errors->first('checkout_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <!-- Expected Checkin Date -->
                    <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                        <label for="expected_checkin" class="col-sm-3 control-label">
                            {{ trans('admin/hardware/form.expected_checkin') }}
                        </label>
                        <div class="col-md-8">
                            <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="0d" data-date-clear-btn="true">
                                <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ old('expected_checkin') }}">
                                <span class="input-group-addon"><x-icon type="calendar" /></span>
                            </div>
                            {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>


                    <!-- Note -->
                    <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                        <label for="note" class="col-sm-3 control-label">
                            {{ trans('general.notes') }}
                        </label>
                        <div class="col-md-8">
                            <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note') }}</textarea>
                            {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    @include ('partials.forms.edit.asset-select', [
                        'translated_name' => trans('general.assets'),
                        // Fieldname is empty so not included in the form
                        'fieldname' => '',
                        'multiple' => 'true',
                        'asset_status_type' => 'RTD',
                        'select_id' => 'bulk_assets_select',
                        'required' => true
                    ])

                </div> <!--./box-body-->
                <div class="box-footer">
                    <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('general.back') }}</a>
                    <button type="submit" id="checkinout_button" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
                </div>
            </div>
            {{Form::close()}}
        </div> <!--/.col-md-6-->

        <div class="col-md-6">
            <div class="box box-default" id="checkedinout-div" style="display: none">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('general.checkout_status') }} (<span id="checkinout-counter">0</span> {{ trans('general.assets_checked_out_count') }}) </h2>
                </div>
                <div class="box-body">

                    <table id="checkedinout" class="table table-striped snipe-table">
                        <thead>
                        <tr>
                            <th>{{ trans('general.asset_tag') }}</th>
                            <th>{{ trans('general.asset_name') }}</th>
                            <th>{{ trans('general.asset_model') }}</th>
                            <th>{{ trans('general.model_no') }}</th>
                            <th>{{ trans('general.checkout_status') }}</th>
                            <th></th>
                        </tr>
                        <tr id="checkinout-loader" style="display: none;">
                            <td colspan="3">
                                <i class="fas fa-spinner spin" aria-hidden="true"></i> {{ trans('general.processing') }}...
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('moar_scripts')
    @parent
    @include('partials/assets-checkinout')
    @include('partials/assets-assigned')
@stop
