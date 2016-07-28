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
      class="table table-striped"
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

@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{ \App\Models\Setting::getSettings()->per_page }},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        cookieExpire: '2y',
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        exportOptions: {
            fileName: 'suppliers-export-' + (new Date()).toISOString().slice(0,10),
        },
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>
@stop

@stop
