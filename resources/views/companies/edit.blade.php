@extends('layouts/edit-form', [
    'createText' => trans('admin/companies/table.create') ,
    'updateText' => trans('admin/companies/table.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.companies'),
    'formAction' => (isset($item->id)) ? route('companies.update', ['company' => $item->id]) : route('companies.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/companies/table.name')])
@include ('partials.forms.edit.phone')
@include ('partials.forms.edit.fax')
@include ('partials.forms.edit.image-upload', ['image_path' => app('companies_upload_path')])

@stop
