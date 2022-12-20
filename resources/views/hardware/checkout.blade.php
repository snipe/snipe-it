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
                    <!-- AssetModel name -->
                        <div class="form-group">
                            {{ Form::label('model', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <p class="form-control-static">
                                    @if (($asset->model) && ($asset->model->name))
                                        {{ $asset->model->name }}

                                    @else
                                        <span class="text-danger text-bold">
                  <i class="fas fa-exclamation-triangle"></i>This asset's model is invalid!
                  The asset <a href="{{ route('hardware.edit', $asset->id) }}">should be edited</a> to correct this before attempting to check it in or out.</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Asset Name -->
                        <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                            {{ Form::label('name', trans('admin/hardware/form.name'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" tabindex="1">
                                {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
                            {{ Form::label('status_id', trans('admin/hardware/form.status'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-7 required">
                                {{ Form::select('status_id', $statusLabel_list, $asset->status_id, array('class'=>'select2', 'style'=>'width:100%','', 'aria-label'=>'status_id')) }}
                                {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                    @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true'])

                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'id'=> 'assigned_user', 'fieldname' => 'assigned_user', 'required'=>'true'])

                    <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                    @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])

                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])



                    <!-- Checkout/Checkin Date -->
                        <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                            {{ Form::label('checkout_at', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <div class="input-group date col-md-7" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkout_at" id="checkout_at" value="{{ old('checkout_at', date('Y-m-d')) }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                {!! $errors->first('checkout_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Expected Checkin Date -->
                        <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                            {{ Form::label('expected_checkin', trans('admin/hardware/form.expected_checkin'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <div class="input-group date col-md-7" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="0d" data-date-clear-btn="true">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ old('expected_checkin') }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="form-group{{ $errors->has('note') ? ' error' : '' }}">
                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $asset->note) }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>


                        @if ($asset->requireAcceptance() || $asset->getEula() || ($snipeSettings->slack_endpoint!=''))

                            <div class="form-group{{ $errors->has('accept_in_person') ? ' has-error' : '' }}" id="acceptable">
                                <div class="col-md-8 col-md-offset-3">
                                    <label class="control-label text-left" style="text-align:left !important" for="accept_in_person">
                                        <input type="checkbox" value="1" name="accept_in_person" id="accept_in_person" class="minimal" {{ old('accept_in_person') == '1' ? ' checked="checked"' : '' }}>
                                        {!! $errors->first('accept_in_person', '<span class="alert-msg">:message</span>') !!}
                                        This user should be presented with an acceptance signature form on the next screen
                                    </label>
                                </div>
                            </div>


                            <div class="form-group" id="notification-callout">
                                <div class="col-md-8 col-md-offset-3">
                                    <div class="callout callout-info">

                                        @if ($asset->requireAcceptance())
                                            <div class="notification-callout notification-acceptance">
                                                <i class="far fa-envelope fa-fw" aria-hidden="true"></i>
                                                {{ trans('admin/categories/general.required_acceptance') }}
                                            </div>
                                        @endif

                                        @if ($asset->getEula())
                                            <div class="notification-callout">
                                                <i class="far fa-envelope fa-fw" aria-hidden="true"></i>
                                                {{ trans('admin/categories/general.required_eula') }}
                                            </div>

                                        @endif

                                        @if ($snipeSettings->slack_endpoint!='')
                                            <div>
                                                <i class="fab fa-slack fa-fw" aria-hidden="true"></i>
                                                {{ trans('general.slack_msg_note')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div> <!--/.box-body-->
                    <div class="box-footer">

                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-link pull-left" href="{{ URL::previous() }}">
                                    {{ trans('button.cancel') }}
                                </a>
                            </div>
                            <div class="col-md-8 text-right">
                                <span id="return-to">
                                    <span class="form-inline">Return to:</span>
                                    <select name="next_action" class="select2 select2-hide-search text-left" style="min-width: 150px;">
                                        <option class="text-left" value="listings" role="option">Listings</option>
                                        <option value="item" role="option">Asset</option>
                                    </select>
                                </span>

                                <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i>
                                    {{ trans('general.checkout') }}
                                </button>

                            </div>
                        </div>







                    </div>
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
        // We don't need a search here since the options are limited
        $(".select2-hide-search").select2({
            minimumResultsForSearch: Infinity,
        });


        // See if the cloaked radio buttons from the checkout selector is set to 'user'
        $('input[name="checkout_to_type"]').change(function() {

            // if it's not set to user, hide the accept_in_person and checkox (since only users get notified)
            if ($('input[name="checkout_to_type"]:checked').val()!='user') {
                $("#acceptable").hide('fast');
                $('#accept_in_person').iCheck('uncheck');
            } else {
                $("#acceptable").show();
                $('#accept_in_person').iCheck('uncheck');
            }

        });

        $('#accept_in_person').on('ifUnchecked', function(event){
            $(".notification-acceptance").show();
        });

        $('#accept_in_person').on('ifChecked', function(event) {
            $(".notification-acceptance").hide('fast');
        });





    </script>
@stop