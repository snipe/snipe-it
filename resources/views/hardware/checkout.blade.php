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
            <h3 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h3>
        </div>
        <div class="box-body">
            {{csrf_field()}}
            @if ($asset->model->name)
            <!-- Model name -->
            <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                {{ Form::label('name', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                <p class="form-control-static">{{ $asset->model->name }}</p>
              </div>
            </div>
            @endif

            <!-- Asset Name -->
            <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
              {{ Form::label('name', trans('admin/hardware/form.name'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" tabindex="1">
                {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>
                @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true'])

                @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_user', 'required'=>'true'])

                <!-- We have to pass unselect here so that we don't default to the asset that's being checked out. We want that asset to be pre-selected everywhere else. -->
                @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])

                @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])



            <!-- Checkout/Checkin Date -->
            <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
              {{ Form::label('name', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                  <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d">
                      <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkout_at" id="checkout_at" value="{{ Input::old('checkout_at') }}">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                {!! $errors->first('checkout_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>

            <!-- Expected Checkin Date -->
            <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
              {{ Form::label('name', trans('admin/hardware/form.expected_checkin'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                  <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="0d">
                      <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ Input::old('expected_checkin') }}">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                {!! $errors->first('expected_checkin', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>

            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
              {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $asset->note) }}</textarea>
                {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>

                @if ($asset->requireAcceptance() || $asset->getEula() || ($snipeSettings->slack_endpoint!=''))
                    <div class="form-group notification-callout">
                        <div class="col-md-8 col-md-offset-3">
                            <div class="callout callout-info">

                                    @if ($asset->requireAcceptance())
                                        <i class="fa fa-envelope"></i>
                                    {{ trans('admin/categories/general.required_acceptance') }}
                                        <br>
                                    @endif

                                    @if ($asset->getEula())
                                        <i class="fa fa-envelope"></i>
                                       {{ trans('admin/categories/general.required_eula') }}
                                        <br>
                                    @endif

                                    @if ($snipeSettings->slack_endpoint!='')
                                        <i class="fa fa-slack"></i>
                                       A slack message will be sent
                                    @endif
                            </div>
                        </div>
                    </div>
                 @endif

        </div> <!--/.box-body-->
        <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
        </div>
      </form>
    </div>
  </div> <!--/.col-md-7-->

  <!-- right column -->
  <div class="col-md-5" id="current_assets_box" style="display:none;">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin/users/general.current_assets') }}</h3>
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
