@extends('layouts/edit-form', [
    'createText' => 'Append accessory',          // TODO: trans
    'updateText' => 'Update appended accessory', // TODO: trans
    'formAction' => ($item) ? route('kits.accessories.update', ['kit_id' => $kit->id, 'accessory_id' => $item->accessory_id]) : route('kits.accessories.store', ['kit_id' => $kit->id]),
])

{{-- Page content --}}
@section('inputFields')
{{--  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="accessory_id">{{ trans('general.accessory') }}:</label>
    <div class="col-md-8 col-xs-12 required">
        <select class="js-data-ajax select2" data-endpoint="accessories" name="accessory" style="width: 100%" id="accessory_id" value="{{ Input::old('name', $pivot->accessory_id) }}"  data-validation="required" />
            {{ Form::select('accessory_id', [] , Input::old('name',  $pivot->accessory_id), array('class'=>'select2', 'style'=>'width:100%')) }}
    </div>
</div>  --}}
{{--  At first, I tried to use partials.forms.edit.accessory-select. But, it required ValidatingTrait (rules method). Pivot class doesn't have it.    --}}
@include ('partials.forms.edit.accessory-select', ['translated_name' => trans('admin/hardware/form.accessory'), 'fieldname' => 'accessory_id', 'required' => 'true'])
{{--  <div id="accessory_id" class="form-group{{ $errors->has('accessory_id') ? ' has-error' : '' }}">

        {{ Form::label('accessory_id', trans('admin/hardware/form.accessory'), array('class' => 'col-md-3 control-label')) }}
    
        <div class="col-md-7 required">
            <select class="js-data-ajax" data-endpoint="accessories" data-placeholder="{{ trans('general.select_accessory') }}" name="accessory_id" style="width: 100%" id="accessory_select_id" data-validation="required">
                @if ($accessory_id = Input::old('accessory_id', (isset($item)) ? $item->accessory_id : ''))
                    <option value="{{ $accessory_id }}" selected="selected">
                        {{ (\App\Accessories\Accessory::find($accessory_id)) ? \App\Accessories\Accessory::find($accessory_id)->name : '' }}
                    </option>
                @else
                    <option value="">{{ trans('general.select_accessory') }}</option>
                @endif
    
            </select>
        </div>
        <div class="col-md-1 col-sm-1 text-left">
            @can('create', \App\Accessories\Accessory::class)
                @if ((!isset($hide_new)) || ($hide_new!='true'))
                    <a href='{{ route('modal.accessory') }}' data-toggle="modal"  data-target="#createModal" data-select='accessory_select_id' class="btn btn-sm btn-default">New</a>
                    <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
                @endif
            @endcan
        </div>
    
        {!! $errors->first('accessory_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
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
