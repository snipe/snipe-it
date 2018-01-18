@extends('layouts.default')

{{-- Page title --}}
@section('title')
  {{ trans('admin/custom_fields/general.create_fieldset') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-9">

  {{ Form::open(['route' => 'fieldsets.store', 'class'=>'form-horizontal']) }}
    <!-- Horizontal Form -->
    <div class="box box-default">
      <div class="box-body">

          <!-- Name -->
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
          <label for="name" class="col-md-4 control-label">
            {{ trans('admin/custom_fields/general.fieldset_name') }}
            <i class='fa fa-asterisk'></i>
          </label>
          <div class="col-md-6">
            <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name') }}" />
            {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>

      </div> <!-- /.box-body-->
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>

    </div> <!-- /.box.box-default-->
    {{ Form::close() }}
  </div>
  <div class="col-md-3">
    <h4>关于字段集</h4>
    <p>字段集是用户创建的自定义字段的容器。为了方便用户查看一系列的属性。 </p>
  </div>
</div>
@stop
