@extends('layouts/edit-form', [
    'createText' => trans('admin/companies/table.create') ,
    'updateText' => trans('admin/companies/table.update'),
    'helpTitle' => trans('admin/companies/general.about_companies_title'),
    'helpText' => trans('admin/companies/general.about_companies_text'),
    'formAction' => ($item) ? route('companies.update', ['company' => $item->id]) : route('companies.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/companies/table.name')])
@stop
