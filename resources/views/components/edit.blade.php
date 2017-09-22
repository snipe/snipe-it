@extends('layouts/edit-form', [
    'createText' => trans('admin/components/general.create') ,
    'updateText' => trans('admin/components/general.update'),
    'helpTitle' => trans('admin/components/general.about_components_title'),
    'helpText' => trans('admin/components/general.about_components_text'),
    'formAction' => ($item) ? route('components.update', ['component' => $item->id]) : route('components.store'),

])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/components/table.title')])
@include ('partials.forms.edit.category')
@include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')
@include ('partials.forms.edit.serial')
@include ('partials.forms.edit.company')
@include ('partials.forms.edit.location')
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.purchase_cost')

@stop
