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
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />


                    <!-- User -->
                    <div id="assigned_user" class="form-group{{ $errors->has('assigned_to') ? ' has-error' : '' }}">

                            {{ Form::label('assigned_to', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}

                        <div class="col-md-7 required">
                            {{ Form::select('assigned_to', $users_list , Input::old('assigned_to'), array('class'=>'select2', 'id'=>'assigned_to', 'style'=>'width:100%')) }}

                            {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                        <div class="col-md-1 col-sm-1 text-left">
                            <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_to' class="btn btn-sm btn-default">New</a>
                        </div>
                    </div>

                    <!-- Checkout/Checkin Date -->
                  <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">

                      {{ Form::label('name', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}

                    <div class="col-md-8">
                      <div class="col-md-4 input-group required">
                      <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="checkout_at" id="checkout_at" value="{{ Input::old('checkout_at', date('Y-m-d')) }}">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                      {!! $errors->first('checkout_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                  </div>

                  <!-- Expected Checkin Date -->
                  <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">

                      {{ Form::label('name', trans('admin/hardware/form.expected_checkin'), array('class' => 'col-md-3 control-label')) }}

                    <div class="col-md-8">
                      <div class="col-md-4 input-group">
                      <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="expected_checkin" id="expected_checkin" value="{{ Input::old('expected_checkin') }}">
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

    {{-- Some room for the modals --}}
    <div class="modal fade" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-first_name">{{ trans('general.first_name') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='text' id='modal-first_name' class="form-control"></div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-last_name">{{ trans('general.last_name') }}:</label></div>
                        <div class="col-md-8 col-xs-12"><input type='text' id='modal-last_name' class="form-control"></div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-username">{{ trans('admin/users/table.username') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='text' id='modal-username' class="form-control"></div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-email">{{ trans('admin/users/table.email') }}:</label></div>
                        <div class="col-md-8 col-xs-12"><input type='email' id='modal-email' class="form-control"></div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-password">{{ trans('admin/users/table.password') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='password' id='modal-password' class="form-control"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
                    <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <!-- Ajax call to retrieve user assets -->

<script>
    $(function () {
        var model,select;
        $('#createModal').on("show.bs.modal",function (event) {
            console.warn('modal ran');
            var link = $(event.relatedTarget);
            model=link.data("dependency");
            select=link.data("select");
            var modal = $(this);
            modal.find('.modal-title').text('Add a new ' + model);
            $('.dynamic-form-row').hide();
            function show_er(selector) {
                $(selector).parent().parent().show();
            }
            show_er('#modal-name');
            switch(model) {
                case 'user':
                    $('.dynamic-form-row').hide(); //we don't want a generic "name"
                    show_er("#modal-first_name");
                    show_er("#modal-last_name");
                    show_er("#modal-username");
                    show_er("#modal-email");
                    show_er("#modal-password");
                    show_er("#modal-password_confirm");
                    break;
                    //do nothing, they just need 'name'
            }
            //console.warn("The Model is: "+model+" and the select is: "+select);
        });
        $('#modal-save').on('click',function () {
            var data={};
            //console.warn("We are about to SAVE!!! for model: "+model+" and select ID: "+select);
            $('.modal-body input:visible').each(function (index,elem) {
                //console.warn("["+index+"]: "+elem.id+" = "+$(elem).val());
                var bits=elem.id.split("-");
                if(bits[0]==="modal") {
                    data[bits[1]]=$(elem).val();
                }
            });
            $('.modal-body select:visible').each(function (index,elem) {
                var bits=elem.id.split("-");
                data[bits[1]]=$(elem).val();
            });
            data._token =  '{{ csrf_token() }}',
                 //   console.dir(data);
                $.post("{{config('app.url') }}/api/"+model+"s",data,function (result) {
                    var id=result.id;
                    var name=result.name || (result.first_name+" "+result.last_name);
                    $('.modal-body input:visible').val("");
                    $('#createModal').modal('hide');
                    //console.warn("The select ID thing we're going for is: "+select);
                    var selector=document.getElementById(select);
                    selector.options[selector.length] = new Option(name,id);
                    selector.selectedIndex=selector.length-1;
                    $(selector).trigger("change");
                }).fail(function (result) {
                    //console.dir(result.responseJSON);
                    msg=result.responseJSON.error.message || result.responseJSON.error;
                    window.alert("Unable to add new "+model+" - error: "+msg);
                });
        });
    });
</script>

<script>
$(function() {
  $('#assigned_to').on("change",function () {
    // console.warn("Model Id has changed!");
    var userid=$('#assigned_to').val();
    if(userid=='') {
      console.warn('no user selected');
      $('#current_assets_box').fadeOut();
      $('#current_assets_content').html("");
    } else {
      $.get("{{config('app.url') }}/api/users/"+userid+"/assets",{_token: "{{ csrf_token() }}"},function (data) {
        // console.warn("Ajax call came back okay for user " + userid + "! " + data.length + " Data is: "+data);
        if (data.length > 0) {
            $('#current_assets_box').fadeIn();
            var table_html = '<div class="row"><div class="col-md-12"><table class="table table-striped"><thead><tr><td>{{ trans('admin/hardware/form.name') }}</td><td>{{ trans('admin/hardware/form.tag') }}</td></tr></thead><tbody>';
            $('#current_assets_content').append('');
            for (var i in data) {
                var asset = data[i];
                table_html += "<tr><td class=\"col-md-8\"><a href=\"{{ config('app.url') }}/hardware/" + asset.id + "/view\">" + asset.name;
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

@stop