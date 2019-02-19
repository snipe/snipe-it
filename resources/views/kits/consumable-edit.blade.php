@extends('layouts/edit-form', [
    'createText' => 'Append consumable',          // TODO: trans
    'updateText' => 'Update appended consumable', // TODO: trans
    'formAction' => ($item) ? route('kits.consumables.update', ['kit_id' => $kit->id, 'consumable_id' => $item->consumable_id]) : route('kits.consumables.store', ['kit_id' => $kit->id]),
])

{{-- Page content --}}
@section('inputFields')
{{--  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="consumable_id">{{ trans('general.consumable') }}:</label>
    <div class="col-md-8 col-xs-12 required">
        <select class="js-data-ajax select2" data-endpoint="consumables" name="consumable" style="width: 100%" id="consumable_id" value="{{ Input::old('name', $pivot->consumable_id) }}"  data-validation="required" />
            {{ Form::select('consumable_id', [] , Input::old('name',  $pivot->consumable_id), array('class'=>'select2', 'style'=>'width:100%')) }}
    </div>
</div>  --}}
{{--  At first, I tried to use partials.forms.edit.consumable-select. But, it required ValidatingTrait (rules method). Pivot class doesn't have it.    --}}
@include ('partials.forms.edit.consumable-select', ['translated_name' => trans('admin/hardware/form.consumable'), 'fieldname' => 'consumable_id', 'required' => 'true'])
{{--  <div id="consumable_id" class="form-group{{ $errors->has('consumable_id') ? ' has-error' : '' }}">

        {{ Form::label('consumable_id', trans('admin/hardware/form.consumable'), array('class' => 'col-md-3 control-label')) }}
    
        <div class="col-md-7 required">
            <select class="js-data-ajax" data-endpoint="consumables" data-placeholder="{{ trans('general.select_consumable') }}" name="consumable_id" style="width: 100%" id="consumable_select_id" data-validation="required">
                @if ($consumable_id = Input::old('consumable_id', (isset($item)) ? $item->consumable_id : ''))
                    <option value="{{ $consumable_id }}" selected="selected">
                        {{ (\App\Consumables\Consumable::find($consumable_id)) ? \App\Consumables\Consumable::find($consumable_id)->name : '' }}
                    </option>
                @else
                    <option value="">{{ trans('general.select_consumable') }}</option>
                @endif
    
            </select>
        </div>
        <div class="col-md-1 col-sm-1 text-left">
            @can('create', \App\Consumables\Consumable::class)
                @if ((!isset($hide_new)) || ($hide_new!='true'))
                    <a href='{{ route('modal.consumable') }}' data-toggle="modal"  data-target="#createModal" data-select='consumable_select_id' class="btn btn-sm btn-default">New</a>
                    <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
                @endif
            @endcan
        </div>
    
        {!! $errors->first('consumable_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
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
