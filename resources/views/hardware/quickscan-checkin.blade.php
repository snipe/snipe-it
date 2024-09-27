@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.quickscan_checkin') }}
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
    {{ Form::open(['method' => 'POST', 'class' => ['form-horizontal','checkin-form'], 'role' => 'form', 'id' => 'checkinout-form' ]) }}
        <!-- left column -->
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('admin/hardware/general.bulk_checkin') }} </h2>
                </div>
                <div class="box-body">
                    {{csrf_field()}}

                    <!-- Asset Tag -->
                    @include ('partials.forms.edit.asset-select', [
                        'translated_name' => trans('general.asset_tag'),
                        // Fieldname is empty so not included in the form
                        'fieldname' => '',
                        'multiple' => true,
                        'asset_status_type' => 'Deployed',
                        'select_id' => 'bulk_assets_select',
                        'required' => true
                    ])
                    {!! $errors->first('asset_tag', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}

                    <!-- Status -->
                    <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
                        <label for="status_id" class="col-md-3 control-label">
                            {{ trans('admin/hardware/form.status') }}
                        </label>
                        <div class="col-md-7">
                            {{ Form::select('status_id', $statusLabel_list, '', array('class'=>'select2', 'style'=>'width:100%','', 'aria-label'=>'status_id')) }}
                            {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

                    <!-- Locations -->
                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                    <!-- Checkout/Checkin Date -->
                    <div class="form-group{{ $errors->has('checkin_at') ? ' has-error' : '' }}">
                        <label for="checkin_at" class="col-sm-3 control-label">
                            {{ trans('admin/hardware/form.checkin_date') }}
                        </label>

                        <div class="col-md-8">
                            <div class="input-group col-md-5 required">
                                <div class="input-group date" data-provide="datepicker"
                                     data-date-format="yyyy-mm-dd" data-autoclose="true">
                                    <input type="text" class="form-control"
                                           placeholder="{{ trans('general.select_date') }}"
                                           name="checkin_at" id="checkin_at"
                                           value="{{ old('checkin_at', date('Y-m-d')) }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                {!! $errors->first('checkin_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note') }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('general.back') }}</a>
                    <button type="submit" id="checkinout_button" class="btn btn-success pull-right"><x-icon type="checkmark" /> {{ trans('general.checkin') }}</button>
                </div>

            </div>



            {{Form::close()}}
        </div> <!--/.col-md-6-->

        <div class="col-md-6">
            <div class="box box-default" id="checkedinout-div">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('general.quickscan_checkin_status') }} (<span id="checkinout-counter">0</span> {{ trans('general.assets_checked_in_count') }}) </h2>
                </div>
                <div class="box-body">
    
                    <table id="checkedinout" class="table table-striped snipe-table">
                        <thead>
                        <tr>
                            <th>{{ trans('general.asset_tag') }}</th>
                            <th>{{ trans('general.asset_name') }}</th>
                            <th>{{ trans('general.asset_model') }}</th>
                            <th>{{ trans('general.model_no') }}</th>
                            <th>{{ trans('general.quickscan_checkin_status') }}</th>
                            <th></th>
                        </tr>
                        <tr id="checkinout-loader" style="display: none;">
                            <td colspan="3">
                                <x-icon type="spinner" />  {{ trans('general.processing') }}...
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
@stop
