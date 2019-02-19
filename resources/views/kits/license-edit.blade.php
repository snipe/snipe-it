@extends('layouts/edit-form', [
    'createText' => 'Append license',          // TODO: trans
    'updateText' => 'Update appended license', // TODO: trans
    'formAction' => ($item) ? route('kits.licenses.update', ['kit_id' => $kit->id, 'license_id' => $item->license_id]) : route('kits.licenses.store', ['kit_id' => $kit->id]),
])

{{-- Page content --}}
@section('inputFields')
{{--  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="license_id">{{ trans('general.license') }}:</label>
    <div class="col-md-8 col-xs-12 required">
        <select class="js-data-ajax select2" data-endpoint="licenses" name="license" style="width: 100%" id="license_id" value="{{ Input::old('name', $pivot->license_id) }}"  data-validation="required" />
            {{ Form::select('license_id', [] , Input::old('name',  $pivot->license_id), array('class'=>'select2', 'style'=>'width:100%')) }}
    </div>
</div>  --}}
{{--  At first, I tried to use partials.forms.edit.license-select. But, it required ValidatingTrait (rules method). Pivot class doesn't have it.    --}}
@include ('partials.forms.edit.license-select', ['translated_name' => trans('general.license'), 'fieldname' => 'license_id', 'required' => 'true'])
{{--  <div id="license_id" class="form-group{{ $errors->has('license_id') ? ' has-error' : '' }}">

        {{ Form::label('license_id', trans('general.license'), array('class' => 'col-md-3 control-label')) }}
    
        <div class="col-md-7 required">
            <select class="js-data-ajax" data-endpoint="licenses" data-placeholder="{{ trans('general.select_license') }}" name="license_id" style="width: 100%" id="license_select_id" data-validation="required">
                @if ($license_id = Input::old('license_id', (isset($item)) ? $item->license_id : ''))
                    <option value="{{ $license_id }}" selected="selected">
                        {{ (\App\Licenses\License::find($license_id)) ? \App\Licenses\License::find($license_id)->name : '' }}
                    </option>
                @else
                    <option value="">{{ trans('general.select_license') }}</option>
                @endif
    
            </select>
        </div>
        <div class="col-md-1 col-sm-1 text-left">
            @can('create', \App\Licenses\License::class)
                @if ((!isset($hide_new)) || ($hide_new!='true'))
                    <a href='{{ route('modal.license') }}' data-toggle="modal"  data-target="#createModal" data-select='license_select_id' class="btn btn-sm btn-default">New</a>
                    <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
                @endif
            @endcan
        </div>
    
        {!! $errors->first('license_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
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
