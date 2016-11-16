@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($model->id)
        {{ trans('admin/models/table.update') }}
    @else
        {{ trans('admin/models/table.create') }}
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

      {{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal' ]) }}
      <!-- CSRF Token -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

      <div class="box box-default">

          @if ($model->id)
            <div class="box-header with-border">
              <div class="box-heading">
                <h3 class="box-title"> {{ $model->name }}</h3>
              </div>
            </div><!-- /.box-header -->
          @endif


        <div class="box-body">
          <!-- Model name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">{{ trans('admin/models/table.name') }}</label>
                <div class="col-md-7 required">
                  <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $model->name) }}" />
                  {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
          </div>

           <div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
            <label for="manufacturer_id" class="col-md-3 control-label">{{ trans('general.manufacturer') }}</label>
              <div class="col-md-7 required">
                {{ Form::select('manufacturer_id', $manufacturer_list , Input::old('manufacturer_id', $model->manufacturer_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                {!! $errors->first('manufacturer_id', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
              </div>
            </div>

          <!-- Category -->
                <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                    <label for="category_id" class="col-md-3 control-label">{{ trans('general.category') }}</label>
                        <div class="col-md-7 required">
                            {{ Form::select('category_id', $category_list , Input::old('category_id', $model->category_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                            {!! $errors->first('category_id', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>


                <!-- Model No. -->
                <div class="form-group {{ $errors->has('modelno') ? ' has-error' : '' }}">
                    <label for="modelno" class="col-md-3 control-label">{{ trans('general.model_no') }}</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="modelno" id="modelno" value="{{ Input::old('modelno', $model->modelno) }}" />
                            {!! $errors->first('modelno', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- Depreciation -->
                <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                    <label for="depreciation_id" class="col-md-3 control-label">{{ trans('general.depreciation') }}</label>
                        <div class="col-md-7">
                            {{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $model->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                            {!! $errors->first('depreciation_id', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>

                <!-- EOL -->

                <div class="form-group {{ $errors->has('eol') ? ' has-error' : '' }}">
                    <label for="eol" class="col-md-3 control-label">{{ trans('general.eol') }}</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input class="col-md-1 form-control" type="text" name="eol" id="eol" value="{{ Input::old('eol', isset($model->eol)) ? $model->eol : ''  }}" />
                            <span class="input-group-addon">
                                {{ trans('general.months') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-9 col-md-offset-3">
                        {!! $errors->first('eol', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                </div>

                <!-- Custom Fieldset -->
                <div class="form-group {{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
                  <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
                  <div class="col-md-7">
                      {{ Form::select('custom_fieldset', \App\Helpers\Helper::customFieldsetList(),Input::old('custom_fieldset', $model->fieldset_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                      {!! $errors->first('custom_fieldset', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
                </div>

                <!-- Notes -->
                <div class="form-group {{ $errors->has('note') ? ' has-error' : '' }}">
                    <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                    <div class="col-md-7 col-sm-12">
                        <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $model->note) }}</textarea>
                        <p class="help-block">{!! trans('general.markdown') !!} </p>

                        {!! $errors->first('note', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                </div>

            
               <!-- Requestable -->
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <label>
                            <input type="checkbox" value="1" name="requestable" id="requestable" class="minimal" {{ Input::old('requestable', $model->requestable) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/models/general.requestable') }}
                        </label>
                    </div>
                </div>

                <!-- Image -->
                @if ($model->image)
                    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
                        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
                        <div class="col-md-5">
                            {{ Form::checkbox('image_delete') }}
                            <img src="{{ config('app.url') }}/uploads/models/{{ $model->image }}" />
                            {!! $errors->first('image_delete', '<span class="alert-msg"><br>:message</span>') !!}
                        </div>
                    </div>
                @endif

                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
                    <div class="col-md-5">
                        {{ Form::file('image') }}
                        {!! $errors->first('image', '<span class="alert-msg"><br>:message</span>') !!}
                    </div>
                </div>


        </div>
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
        </div>
      </div>
    </div>

@stop
