@extends('layouts/edit-form', [
    'createText' => trans('admin/consumables/general.create') ,
    'updateText' => trans('admin/consumables/general.update'),
    'helpTitle' => trans('admin/consumables/general.about_consumables_title'),
    'helpText' => trans('admin/consumables/general.about_consumables_text'),
    'formAction' => ($item) ? route('consumables.update', ['accessory' => $item->id]) : route('consumables.store'),
])
{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.company')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/consumables/table.title')])
@include ('partials.forms.edit.category')
@include ('partials.forms.edit.manufacturer')
@include ('partials.forms.edit.location')
@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.item_number')
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.purchase_cost')
@include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')

@stop
