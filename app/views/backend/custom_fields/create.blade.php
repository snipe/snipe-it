@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
  @lang('admin/custom_fields/general.create_fieldset')
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('admin.custom_fields.index') }}" class="btn-flat gray pull-right">
          <i class="fa fa-arrow-left icon-white"></i>
          @lang('general.back')</a>
        <h3>
        @lang('admin/custom_fields/general.create_fieldset')
        </h3>
    </div>
</div>
<div class="row form-wrapper">

{{ Form::open(['route' => 'admin.custom_fields.store', 'class'=>'form-horizontal']) }}

            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">@lang('admin/custom_fields/general.fieldset_name')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-6">
                      <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" />
                      {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
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
