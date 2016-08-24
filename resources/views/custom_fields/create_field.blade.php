@extends('layouts/default')
{{-- Page title --}}
@section('title')
  {{ trans('admin/custom_fields/general.create_field') }}
@parent
@stop

@section('content')

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
<div class="col-md-9">
  <!-- Horizontal Form -->
    <div class="box box-default">
      <div class="box-body">


        {{ Form::open(['route' => 'admin.custom_fields.store-field', 'class'=>'form-horizontal']) }}


          <!-- Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_name') }} </label>
               </label>
                  <div class="col-md-6 required">
                    <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name') }}" />
                    {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <!-- Type -->
          <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}">
              <label for="element" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_element') }}</label>
               </label>
                  <div class="col-md-6 required">

                      {!! Form::customfield_elements('customfield_element', Input::old('customfield_element'), 'select2 form-control') !!}

                    {!! $errors->first('element', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <!-- Format -->
          <div class="form-group {{ $errors->has('format') ? ' has-error' : '' }}">
              <label for="format" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_format') }}</label>
               </label>
                  <div class="col-md-6 required">
                    {{ Form::select("format",\App\Helpers\Helper::predefined_formats(),"ANY", array('class'=>'format select2 form-control')) }}
                    {!! $errors->first('format', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <!-- Custom Format -->
          <div class="form-group {{ $errors->has('custom_format') ? ' has-error' : '' }}" id="custom_regex" style="display:none;">
              <label for="custom_format" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_custom_format') }}
              </label>
               </label>
                  <div class="col-md-6">
                    <input class="form-control" type="text" name="custom_format" id="custom_format" value="{{ Input::old('custom_format') }}" />
                    {!! $errors->first('custom_format', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>


          <!-- Form actions -->
          <div class="form-group">
          <label class="col-md-4 control-label"></label>
              <div class="col-md-7">
                  <a class="btn btn-link" href="{{ route('admin.custom_fields.index') }}">{{ trans('button.cancel') }}</a>
                  <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
              </div>
          </div>

{{ Form::close() }}
  </div>
  </div>
</div>
<div class="col-md-3">
<h4>About Custom Fields</h4>
<p>Custom fields allow you to add arbitrary attributes to assets.</p>
</div>

@section('moar_scripts')
        <script>

            $(document).ready(function(){
                $(".format").change(function(){
                    $(this).find("option:selected").each(function(){
                        console.warn($(this).attr("value"));
                        if($(this).attr("value")=="custom"){
                            $("#custom_regex").show();
                        } else{
                            $("#custom_regex").hide();
                        }
                    });
                }).change();
            });
        </script>
@stop


@stop
