@extends('layouts/edit-form', [
    'createText' => 'Append model',          // TODO: trans
    'updateText' => 'Update appended model', // TODO: trans
    'formAction' => ($item) ? route('kits.models.update', ['kit_id' => $kit->id, 'model_id' => $item->model_id]) : route('kits.models.store', ['kit_id' => $kit->id]),
])

{{-- Page content --}}
@section('inputFields')
{{--  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="model_id">{{ trans('general.asset_model') }}:</label>
    <div class="col-md-8 col-xs-12 required">
        <select class="js-data-ajax select2" data-endpoint="models" name="model" style="width: 100%" id="model_id" value="{{ Input::old('name', $pivot->model_id) }}"  data-validation="required" />
            {{ Form::select('model_id', [] , Input::old('name',  $pivot->model_id), array('class'=>'select2', 'style'=>'width:100%')) }}
    </div>
</div>  --}}
{{--  At first, I tried to use partials.forms.edit.model-select. But, it required ValidatingTrait (rules method). Pivot class doesn't have it.    --}}
@include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id', 'required' => 'true'])
{{--  <div id="model_id" class="form-group{{ $errors->has('model_id') ? ' has-error' : '' }}">

        {{ Form::label('model_id', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
    
        <div class="col-md-7 required">
            <select class="js-data-ajax" data-endpoint="models" data-placeholder="{{ trans('general.select_model') }}" name="model_id" style="width: 100%" id="model_select_id" data-validation="required">
                @if ($model_id = Input::old('model_id', (isset($item)) ? $item->model_id : ''))
                    <option value="{{ $model_id }}" selected="selected">
                        {{ (\App\Models\AssetModel::find($model_id)) ? \App\Models\AssetModel::find($model_id)->name : '' }}
                    </option>
                @else
                    <option value="">{{ trans('general.select_model') }}</option>
                @endif
    
            </select>
        </div>
        <div class="col-md-1 col-sm-1 text-left">
            @can('create', \App\Models\AssetModel::class)
                @if ((!isset($hide_new)) || ($hide_new!='true'))
                    <a href='{{ route('modal.model') }}' data-toggle="modal"  data-target="#createModal" data-select='model_select_id' class="btn btn-sm btn-default">New</a>
                    <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
                @endif
            @endcan
        </div>
    
        {!! $errors->first('model_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
    </div>  --}}
<div class="form-group {{ $errors->has('quantity') ? ' has-error' : '' }}">
    <label for="quantity" class="col-md-3 control-label">{{ trans('general.quantity') }}</label>
    <div class="col-md-7 required">
        <div class="col-md-2" style="padding-left:0px">
            <input class="form-control" type="text" name="quantity" id="quantity" value="{{ Input::old('quantity', $item->quantity) }}" />
        </div>
        {!! $errors->first('quantity', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<input type="hidden" name="pivot_id" value="{{$item->id}}">
{{-- <input class="form-control" type="text" name="quantity" id="quantity" value="{{ Input::old('quantity', $item->quantity) }}" /> --}}

@stop
