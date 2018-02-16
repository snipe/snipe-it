@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/suppliers/table.suppliers') }}
@parent
@stop

{{-- Page content --}}
@section('content')


@section('header_right')
  @can('create', \App\Models\Supplier::class)
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
      <div class="table-responsive">

        <table
            data-cookie-id-table="suppliersTable"
            data-pagination="true"
            data-id-table="suppliersTable"
            data-search="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-export="true"
            data-show-refresh="true"
            data-sort-order="asc"
            id="suppliersTable"
            class="table table-striped snipe-table"
            data-url="{{ route('api.suppliers.index') }}"
            data-export-options='{
            "fileName": "export-suppliers-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
        <thead>
          <tr>
            <th data-sortable="true" data-field="id" data-visible="false">{{ trans('admin/suppliers/table.id') }}</th>
            <th data-formatter="imageFormatter" data-sortable="true" data-field="image" data-visible="false"  data-searchable="false">{{ trans('general.image') }}</th>
            <th data-sortable="true" data-field="name" data-formatter="suppliersLinkFormatter">{{ trans('admin/suppliers/table.name') }}</th>
            <th data-sortable="true" data-field="address">{{ trans('admin/suppliers/table.address') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="contact">{{ trans('admin/suppliers/table.contact') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="email" data-formatter="emailFormatter">{{ trans('admin/suppliers/table.email') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="phone" data-formatter="phoneFormatter">{{ trans('admin/suppliers/table.phone') }}</th>
            <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">{{ trans('admin/suppliers/table.fax') }}</th>
            <th data-searchable="false" data-sortable="true" data-field="assets_count">{{ trans('admin/suppliers/table.assets') }}</th>
            <th data-searchable="false" data-sortable="true" data-field="accessories_count">{{ trans('general.accessories') }}</th>
            <th data-searchable="false" data-sortable="true" data-field="licenses_count">{{ trans('admin/suppliers/table.licenses') }}</th>
            <th data-switchable="false" data-formatter="suppliersActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
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
