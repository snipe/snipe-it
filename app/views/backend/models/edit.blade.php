@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($model->id)
        @lang('base.model_update') ::
    @else
        @lang('base.model_create') ::
    @endif
@parent
@stop

{{-- Page content --}}

@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">
    
<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($model->id)
            @lang('base.model_update')
        @elseif(isset($clone_model))
            @lang('base.model_clone')
        @else
            @lang('base.model_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">


<div class="col-md-12 column">
    

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />



            <!-- Model name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.name')
                 <i class='icon-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $model->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
		<label for="manufacturer_id" class="col-md-2 control-label">@lang('base.manufacturer')
                    <i class='icon-asterisk'></i></label>
		<div class="col-md-7">
		{{ Form::select('manufacturer_id', $manufacturer_list , Input::old('manufacturer_id', $model->manufacturer_id), array('class'=>'select2', 'style'=>'width:350px')) }}
		{{ $errors->first('manufacturer_id', '&nbsp;<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Category -->
            <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                <label for="category_id" class="col-md-2 control-label">@lang('base.category')
                 <i class='icon-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        {{ Form::select('category_id', $category_list , Input::old('category_id', $model->category_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('category_id', '&nbsp;<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Model No. -->
            <div class="form-group {{ $errors->has('modelno') ? ' has-error' : '' }}">
                <label for="modelno" class="col-md-2 control-label">@lang('general.modelnumber')</label>
                <div class="col-md-3">
                        <input class="form-control" type="text" name="modelno" id="modelno" value="{{{ Input::old('modelno', $model->modelno) }}}" />
                        {{ $errors->first('modelno', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Depreciation -->
            <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                <label for="depreciation_id" class="col-md-2 control-label">@lang('base.depreciation')</label>
                    <div class="col-md-7">
                        {{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $model->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('depreciation_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- EOL -->
            
            <div class="form-group {{ $errors->has('eol') ? ' has-error' : '' }}">
                <label for="eol" class="col-md-2 control-label">@lang('general.eol')</label>
                <div class="col-md-2">
                    <div class="input-group">
                    <input class="col-md-1 form-control" type="text" name="eol" id="eol" value="{{{ Input::old('eol', isset($model->eol)) ? $model->eol : 0  }}}" /><span class="input-group-addon">
                    @lang('general.months')</span>
                    {{ $errors->first('eol', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('general.notes')</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" type="text" name="notes" id="notes">{{{ Input::old('notes', $model->notes) }}}</textarea>
                    {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Form actions -->
                <div class="form-group">
                    <br>
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
                    </div>
                </div>
            
</div>
</div>
    
</form>

@stop
