@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/suppliers/table.suppliers') }}
@parent
@stop

{{-- Page content --}}
@section('content')


@section('header_right')
<a href="{{ route('create/supplier') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
@stop



<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
      <div class="table-responsive">
      <table
      name="suppliers"
      id="table"
      class="table table-striped snipe-table"
      data-url="{{ route('api.suppliers.list') }}"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="suppliersTable-{{ config('version.hash_version') }}">
        <thead>
          <tr>
            <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/suppliers/table.id') }}</th>
            <th data-sortable="true" data-field="name">{{ trans('admin/suppliers/table.name') }}</th>
            <th data-sortable="true" data-field="address">{{ trans('admin/suppliers/table.address') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="contact">{{ trans('admin/suppliers/table.contact') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="email">{{ trans('admin/suppliers/table.email') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="phone">{{ trans('admin/suppliers/table.phone') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">{{ trans('admin/suppliers/table.fax') }}</th>
            <th data-searchable="false" data-sortable="false" data-field="assets">{{ trans('admin/suppliers/table.assets') }}</th>
            <th data-searchable="false" data-sortable="false" data-field="licenses">{{ trans('admin/suppliers/table.licenses') }}</th>
            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
          </tr>
        </thead>
      </table>
      </div>
    </div>
  </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'suppliers-export', 'search' => true])
@stop
