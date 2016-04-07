@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.checkout') }}
@parent
@stop


{{-- Page content --}}
@section('content')


<div class="row">

    <!-- left column -->
    <div class="col-md-7">

          <div class="box box-default">
              <div class="box-header with-border">
                  <h3 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h3>
              </div>
              <div class="box-body">
                <form class="form-horizontal" method="post" action="" autocomplete="off">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />



                  @if ($asset->model->name)
                  <!-- Asset name -->
                  <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('name', trans('admin/hardware/form.model')) }}
                    </div>
                    <div class="col-md-9">
                      <p class="form-control-static">{{ $asset->model->name }}</p>
                    </div>
                  </div>
                  @endif

                  <!-- Asset Name -->
                  <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('name', trans('admin/hardware/form.name')) }}
                    </div>
                    <div class="col-md-9">
                      <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" />
                      {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>

                  <!-- User -->
                  <div class="form-group {{ $errors->has('assigned_to') ? 'error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('assigned_to', trans('admin/hardware/form.checkout_to')) }}
                    </div>
                    <div class="col-md-9">
                      {{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $asset->assigned_to), array('id'=>'checkout_to_user','class'=>'select2', 'style'=>'min-width:350px')) }}
                      {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>


                  <!-- Checkout/Checkin Date -->
                  <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('checkout_at', trans('admin/hardware/form.checkout_date')) }}
                    </div>
                    <div class="col-md-4">
                      <div class="right-inner-addon">
                        <i class="fa fa-calendar"></i>
                        <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Checkout Date" name="checkout_at" id="checkout_at" value="{{ Input::old('checkout_at', date('Y-m-d')) }}">
                      </div>

                      {!! $errors->first('checkout_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>

                  <!-- Expected Checkin Date -->
                  <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('expected_checkin', trans('admin/hardware/form.expected_checkin')) }}
                    </div>
                    <div class="col-md-4">
                      <div class="right-inner-addon">
                        <i class="fa fa-calendar"></i>
                        <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Expected Checkin Date" name="expected_checkin" id="expected_checkin" value="{{ Input::old('expected_checkin') }}">
                      </div>
                      {!! $errors->first('expected_checkin', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>


                  <!-- Note -->
                  <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                    <div class="col-md-3">
                      {{ Form::label('note', trans('admin/hardware/form.notes')) }}
                    </div>
                    <div class="col-md-9">
                      <textarea class="col-md-6 form-control" id="note" name="note">
                        {{ Input::old('note', $asset->note) }}
                      </textarea>
                      {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>



                    @if ($asset->requireAcceptance())

                    <div class="form-group">
                      <div class="col-md-9 col-md-offset-3">
                        <p class="text-yellow"><i class="fa fa-warning"></i> {{ trans('admin/categories/general.required_acceptance') }}</p>
                      </div>
                    </div>
                    @endif


                    @if ($asset->getEula())
                    <div class="form-group">
                      <div class="col-md-9 col-md-offset-3">
                        <p class="text-yellow"><i class="fa fa-warning"></i> {{ trans('admin/categories/general.required_eula') }}</p>
                      </div>
                    </div>
                    @endif

              </div>
              <div class="box-footer">
                <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
              </div>
          </div>
    </form>
    </div>

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

@section('moar_scripts')

<!-- Ajax call to retrieve user assets -->
<script>

$(function() {
  $('#checkout_to_user').on("change",function () {
    // console.warn("Model Id has changed!");
    var userid=$('#checkout_to_user').val();
    if(userid=='') {
      console.warn('no user selected');
      $('#current_assets_box').fadeOut();
      $('#current_assets_content').html("");
    } else {

      $.get("{{config('app.url') }}/api/users/"+userid+"/assets",{_token: "{{ csrf_token() }}"},function (data) {
        console.warn("Ajax call came back okay for user " + userid + "! " + data.length + " Data is: "+data);
        if (data.length > 0) {
            $('#current_assets_box').fadeIn();

            var table_html = '<div class="row"><div class="col-md-12"><table class="table table-striped"><thead><tr><td>{{ trans('admin/hardware/form.name') }}</td><td>{{ trans('admin/hardware/form.tag') }}</td></tr></thead><tbody>';

            $('#current_assets_content').append('');

            for (var i in data) {
                var asset = data[i];
                table_html += "<tr><td class=\"col-md-8\"><a href=\"{{ config('app.url') }}/hardware/" + asset.id + "/view\">" + asset.name + "</a></td><td class=\"col-md-4\">" + asset.asset_tag + "</td></tr>";
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

@stop
