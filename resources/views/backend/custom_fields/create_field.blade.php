@extends('backend/layouts/default')
{{-- Page title --}}
@section('title')
  @lang('admin/custom_fields/general.create_field')
@parent
@stop

@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('admin.custom_fields.index') }}" class="btn-flat gray pull-right">
          <i class="fa fa-arrow-left icon-white"></i>
          @lang('general.back')</a>
        <h3>
        @lang('admin/custom_fields/general.create_field')
        </h3>
    </div>
</div>
<div class="row form-wrapper">

{{ Form::open(['route' => 'admin.custom_fields.store-field', 'class'=>'form-horizontal']) }}


  <!-- Name -->
  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name" class="col-md-4 control-label">@lang('admin/custom_fields/general.field_name')
       <i class='fa fa-asterisk'></i></label>
       </label>
          <div class="col-md-6">
            <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" />
            {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
          </div>
  </div>

  <!-- Type -->
  <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}">
      <label for="element" class="col-md-4 control-label">@lang('admin/custom_fields/general.field_element')
       <i class='fa fa-asterisk'></i></label>
       </label>
          <div class="col-md-6">
            {{ Form::select("element",["text" => "Text Box"])}}
            {{ $errors->first('element', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
          </div>
  </div>

  <!-- Format -->
  <div class="form-group {{ $errors->has('format') ? ' has-error' : '' }}">
      <label for="format" class="col-md-4 control-label">@lang('admin/custom_fields/general.field_format')
       <i class='fa fa-asterisk'></i></label>
       </label>
          <div class="col-md-6">
            {{ Form::select("format",predefined_formats(),"ANY", array('class'=>'form-control')) }}
            {{ $errors->first('format', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
          </div>
  </div>

  <!-- Custom Format -->
  <div class="form-group {{ $errors->has('custom_format') ? ' has-error' : '' }}">
      <label for="custom_format" class="col-md-4 control-label">@lang('admin/custom_fields/general.field_custom_format')
      </label>
       </label>
          <div class="col-md-6">
            <input class="form-control" type="text" name="custom_format" id="custom_format" value="{{{ Input::old('custom_format') }}}" />
            {{ $errors->first('custom_format', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
          </div>
  </div>


  <!-- Form actions -->
  <div class="form-group">
  <label class="col-md-4 control-label"></label>
      <div class="col-md-7">
          <a class="btn btn-link" href="{{ route('admin.custom_fields.index') }}">@lang('button.cancel')</a>
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
      </div>
  </div>

{{ Form::close() }}

</div>

@stop
