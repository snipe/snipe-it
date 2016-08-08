@extends('layouts/default')

{{-- Page title --}}
@section('title')

    @if ($location->id)
        {{ trans('admin/locations/table.update') }}
    @else
        {{ trans('admin/locations/table.create') }}
    @endif

@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')



<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="box box-default">
      @if ($location->id)
        <div class="box-header with-border">
          <h3 class="box-title">{{ $location->name }}</h3>
        </div><!-- /.box-header -->
      @endif


      <div class="box-body">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

          <!-- Location Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">{{ trans('admin/locations/table.name') }}
            </label>
            <div class="col-md-8{{  (\App\Helpers\Helper::checkIfRequired($location, 'name')) ? ' required' : '' }}">
                <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $location->name) }}" />
                {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>

          </div>

        <!-- Parent-->
        <div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }}">
            <label for="parent_id" class="col-md-3 control-label">
              {{ trans('admin/locations/table.parent') }}
            </label>
            <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($location, 'parent_id')) ? ' required' : '' }}">
              {!! Form::select('parent_id', $location_options , Input::old('parent_id', $location->parent_id), array('class'=>'select2 parent', 'style'=>'width:350px')) !!}
              {!! $errors->first('parent_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
        </div>

            <!-- Currency -->
            <div class="form-group {{ $errors->has('currency') ? ' has-error' : '' }}">
                <label for="currency" class="col-md-3 control-label">
                  {{ trans('admin/locations/table.currency') }}
                </label>
                      <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($location, 'currency')) ? ' required' : '' }}">
                        {{ Form::text('currency', Input::old('currency', $location->currency), array('class' => 'form-control','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
                        {!! $errors->first('currency', '<span class="alert-msg">:message</span>') !!}
                      </div>
            </div>

                <!-- Address -->
                <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                    <label for="address" class="col-md-3 control-label">
                      {{ trans('admin/locations/table.address') }}
                    </label>
                        <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($location, 'address')) ? ' required' : '' }}">
                            <input class="form-control" type="text" name="address" id="address" value="{{ Input::old('address', $location->address) }}" />
                            {!! $errors->first('address', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- Address -->
                <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
                    <label for="address2" class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" name="address2" id="address2" value="{{ Input::old('address2', $location->address2) }}" />
                        {!! $errors->first('address2', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- City -->
                <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                    <label for="city" class="col-md-3 control-label">{{ trans('admin/locations/table.city') }}</label>
                     </label>
                        <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($location, 'city')) ? ' required' : '' }}">
                            <input class="form-control" type="text" name="city" id="city" value="{{ Input::old('city', $location->city) }}" />
                        {!! $errors->first('city', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- City -->
                <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                    <label for="state" class="col-md-3 control-label">{{ trans('admin/locations/table.state') }}</label>
                        <div class="col-md-9">
                            <input class="form-control" type="text" name="state" id="state" value="{{ Input::old('state', $location->state) }}" />
                        {!! $errors->first('state', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- Zip -->
                <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                    <label for="zip" class="col-md-3 control-label">{{ trans('admin/locations/table.zip') }}</label>
                        <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($location, 'zip')) ? ' required' : '' }}">
                            <input class="form-control" type="text" name="zip" id="zip" value="{{ Input::old('zip', $location->zip) }}" />
                        {!! $errors->first('zip', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- Country -->
                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                    <label for="country" class="col-md-3 control-label">{{ trans('admin/locations/table.country') }}</label>
                     </label>
                        <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($location, 'country')) ? ' required' : '' }}">
                         {!! Form::countries('country', Input::old('country', $location->country), 'select2 country') !!}
                        {!! $errors->first('country', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>


      </div>
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
    </div>
      </div>
    </div>
  </form>



</div>
</div>
@if (!$location->id)
@section('moar_scripts')
<script>

	var $eventSelect = $(".parent");
	$eventSelect.on("change", function () { parent_details($eventSelect.val()); });
	$(function() {
        var parent_loc = $(".parent option:selected").val();
        if(parent_loc!=''){
            parent_details(parent_loc);
        }
	});

	function parent_details(id) {

    if (id) {
      //start ajax request
      $.ajax({
          type: 'GET',
          url: "{{config('app.url') }}/api/locations/"+id+"/check",
          //force to handle it as text
          dataType: "text",
          success: function(data) {
              var json = $.parseJSON(data);
              $("#city").val(json.city);
              $("#address").val(json.address);
              $("#address2").val(json.address2);
              $("#state").val(json.state);
              $("#zip").val(json.zip);
              $(".country").select2("val",json.country);
          }
      });
    } else {
      $("#city").val('');
      $("#address").val('');
      $("#address2").val('');
      $("#state").val('');
      $("#zip").val('');
      $(".country").select2("val",'');
    }



	};
</script>
@stop
@endif

@stop
