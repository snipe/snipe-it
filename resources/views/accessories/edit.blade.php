@extends('layouts/edit-form', [
    'createText' => trans('admin/accessories/general.create') ,
    'updateText' => trans('admin/accessories/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.accessories'),
    'formAction' => (isset($item->id)) ? route('accessories.update', ['accessory' => $item->id]) : route('accessories.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/accessories/general.accessory_name')])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id', 'required' => 'true','category_type' => 'accessory'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.purchase_cost')
@include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')


<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            {{ Form::checkbox('image_delete') }}
            <img src="{{  Storage::disk('public')->url('accessories/'.e($item->image)) }}" class="img-responsive" />
            {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
        </div>
    </div>
@endif

@include ('partials.forms.edit.notes')

@include ('partials.forms.edit.image-upload')

@stop
