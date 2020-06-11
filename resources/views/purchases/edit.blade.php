@extends('layouts/edit-form', [
    'createText' => "Создать закупку" ,
    'updateText' => "Обновить закупку",
    'formAction' => ($item) ? route('purchases.update', ['purchase' => $item->id]) : route('purchases.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.invoice_number', ['translated_name' => "Номер счета"])

@include ('partials.forms.edit.final_price', ['translated_name' => "Цена"])

@include ('partials.forms.edit.comment', ['translated_name' => "Комментарий"])

@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

<!-- Image -->
{{--@if (($item->image) && ($item->image!=''))--}}
{{--    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">--}}
{{--        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>--}}
{{--        <div class="col-md-5">--}}
{{--            <label for="image_delete">--}}
{{--                {{ Form::checkbox('image_delete', '1', Input::old('image_delete'), array('class' => 'minimal', 'aria-label'=>'required')) }}--}}
{{--            </label>--}}
{{--            <br>--}}
{{--            <img src="{{ url('/') }}/uploads/locations/{{ $item->image }}" alt="Image for {{ $item->name }}">--}}
{{--            {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true"><br>:message</span>') !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}

@include ('partials.forms.edit.invoice_file')
@stop

@if (!$item->id)
@section('moar_scripts')
<script nonce="{{ csrf_token() }}">

</script>
@stop
@endif
