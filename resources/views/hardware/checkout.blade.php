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
            <!-- Asset name -->
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
                <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" />
                {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>

            <!-- User -->
            <div id="assigned_user" class="form-group{{ $errors->has('assigned_to') ? ' has-error' : '' }}">
              {{ Form::label('assigned_user', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-7 required">
                {{ Form::select('assigned_user', $users_list , Input::old('assigned_user', $asset->assigned_type == 'App\Models\User' ? $asset->assigned_to : 0), array('class'=>'select2', 'id'=>'assigned_user_select', 'style'=>'width:100%')) }}

                {!! $errors->first('assigned_user', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
              <div class="col-md-1 col-sm-1 text-left">
                  @can('create', \App\Models\User::class)
                    <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_user_select' class="btn btn-sm btn-default">New</a>
                  @endcan
              </div>
            </div>
            @if (!$asset->requireAcceptance())
                <!-- Assets -->
                <div id="assigned_asset" class="form-group{{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                  {{ Form::label('assigned_asset', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-7 required">
                    {{ Form::select('assigned_asset', $assets_list , Input::old('assigned_asset', $asset->assigned_type == 'App\Models\Asset' ? $asset->assigned_to : 0), array('class'=>'select2', 'id'=>'assigned_asset', 'style'=>'width:100%')) }}
                    {!! $errors->first('assigned_asset', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
                </div>

                <!-- Locations -->
                <div id="assigned_location" class="form-group{{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                  {{ Form::label('assigned_location', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-7 required">
                    {{ Form::select('assigned_location', $locations_list , Input::old('assigned_location', $asset->assigned_type == 'App\Models\Asset' ? $asset->assigned_to : 0), array('class'=>'select2', 'id'=>'assigned_location', 'style'=>'width:100%')) }}
                    {!! $errors->first('assigned_location', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
                </div>
            @endif
            <!-- Checkout/Checkin Date -->
            <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
              {{ Form::label('name', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}
              <div class="col-md-8">
                  <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd">
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
                  <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd">
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

            @if ($asset->requireAcceptance())
            <div class="form-group">
              <div class="col-md-8 col-md-offset-3">
                <p class="text-yellow">
                  <i class="fa fa-warning"></i>
                  {{ trans('admin/categories/general.required_acceptance') }}
                </p>
              </div>
            </div>
            @endif

            @if ($asset->getEula())
            <div class="form-group">
              <div class="col-md-8 col-md-offset-3">
                <p class="text-yellow"><i class="fa fa-warning"></i> {{ trans('admin/categories/general.required_eula') }}</p>
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
<script nonce="{{ csrf_token() }}">
$(function() {
  $('#assigned_user').on("change",function () {
    var userid = $('#assigned_user option:selected').val();
    if(userid=='') {
      console.warn('no user selected');
      $('#current_assets_box').fadeOut();
      $('#current_assets_content').html("");
    } else {

        $.ajax({
            type: 'GET',
            url: '{{url('/') }}/api/v1/users/' + userid + '/assets',
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },

            dataType: 'json',
            success: function (data) {
                $('#current_assets_box').fadeIn();

                var table_html = '<div class="row"><div class="col-md-12"><table class="table table-striped"><thead><tr><td>{{ trans('admin/hardware/form.name') }}</td><td>{{ trans('admin/hardware/form.tag') }}</td></tr></thead><tbody>';

                $('#current_assets_content').append('');

                for (var i in data) {
                    var asset = data[i];
                    table_html += '<tr><td class="col-md-8"><a href="{{ url('/') }}/hardware/' + asset.id + '">' + asset.name;
                    if (asset.model.name!='') {
                        table_html += " (" + asset.model.name + ")";

                    }
                    table_html += "</a></td><td class=\"col-md-4\">" + asset.asset_tag + "</td></tr>";
                }

                $('#current_assets_content').html(table_html + '</tbody></table></div></div>');

            },
            error: function (data) {
                $('#current_assets_box').fadeOut();
            }
        });
    }
  });
});
</script>
@stop
