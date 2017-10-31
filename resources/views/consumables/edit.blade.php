@extends('layouts/edit-form', [
    'createText' => trans('admin/consumables/general.create') ,
    'updateText' => trans('admin/consumables/general.update'),
    'helpTitle' => trans('admin/consumables/general.about_consumables_title'),
    'helpText' => trans('admin/consumables/general.about_consumables_text'),
    'formAction' => ($item) ? route('consumables.update', ['accessory' => $item->id]) : route('consumables.store'),
])
{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/consumables/table.title')])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.item_number')
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
            <img src="{{ url('/') }}/uploads/consumables/{{ $item->image }}" />
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
        {{ Form::file('image') }}
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>
@stop
