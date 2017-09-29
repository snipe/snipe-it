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
  }
</style>


<div class="row">
  <!-- left column -->
  <div class="col-md-7">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title"> {{ trans('admin/hardware/form.tag') }} </h3>
      </div>
      <div class="box-body">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
          {{ csrf_field() }}

          <!-- User -->
          <div id="assigned_user" class="form-group{{ $errors->has('assigned_to') ? ' has-error' : '' }}">

            {{ Form::label('assigned_to', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
            <div class="col-md-7 required">
              {{ Form::select('assigned_to', $users_list , Input::old('assigned_to'), array('class'=>'select2', 'id'=>'assigned_to', 'style'=>'width:100%')) }}

              {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
            <div class="col-md-1 col-sm-1 text-left">
              <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_to' class="btn btn-sm btn-default">New</a>
            </div>
          </div>

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
              <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note') }}</textarea>
              {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>

          <div class="form-group{{ $errors->has('selected_asset') ? ' has-error' : '' }}">
            {{ Form::label('selected_asset', trans('general.assets'), array('class' => 'col-md-3 control-label')) }}
            <div class="col-md-8 required">
              {{ Form::select('selected_assets[]', $assets_list , Input::old('selected_asset'), array('class'=>'select2', 'id'=>'selected_asset', 'style'=>'width:100%', 'multiple'=>'multiple')) }}
              {!! $errors->first('selected_asset', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>

      </div> <!--./box-body-->
      <div class="box-footer">
        <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
      </div>
    </div>
      </form>
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
  $('#assigned_to').on("change",function () {
    // console.warn("Model Id has changed!");
    var userid=$('#assigned_to').val();
    if(userid=='') {
      console.warn('no user selected');
      $('#current_assets_box').fadeOut();
      $('#current_assets_content').html("");
    } else {
      $.get("{{url('/') }}/api/users/"+userid+"/assets",{_token: "{{ csrf_token() }}"},function (data) {
        // console.warn("Ajax call came back okay for user " + userid + "! " + data.length + " Data is: "+data);
        if (data.length > 0) {
            $('#current_assets_box').fadeIn();
            var table_html = '<div class="row"><div class="col-md-12"><table class="table table-striped"><thead><tr><td>{{ trans('admin/hardware/form.name') }}</td><td>{{ trans('admin/hardware/form.tag') }}</td></tr></thead><tbody>';
            $('#current_assets_content').append('');
            for (var i in data) {
                var asset = data[i];
                table_html += "<tr><td class=\"col-md-8\"><a href=\"{{ url('/') }}/hardware/" + asset.id + "/view\">" + asset.name;
                if (asset.model.name!='') {
                    table_html += " (" + asset.model.name + ")";
                }
                table_html += "</a></td><td class=\"col-md-4\">" + asset.asset_tag + "</td></tr>";
            }
            $('#current_assets_content').html(table_html + '</tbody></table></div></div>');
        } else {
            $('#current_assets_box').fadeOut();
        }
      });
    }
  });
});
</script>

@stop
