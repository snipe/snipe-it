@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/asset_maintenances/general.asset_maintenances') }}
@parent
@stop


@section('header_right')
<a href="{{ route('create/asset_maintenances') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
@stop


{{-- Page content --}}
@section('content')



<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
        <div class="box-body">

          <table
          name="maintenances"
          id="table"
          class="table table-striped"
          data-url="{{route('api.asset_maintenances.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="maintenancesTable-{{ config('version.hash_version') }}">
            <thead>
              <tr>
              <th data-field="companyName" data-sortable="false" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
              <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
              <th data-sortable="false" data-field="asset_name">{{ trans('admin/asset_maintenances/table.asset_name') }}</th>
              <th data-sortable="false" data-field="supplier">{{ trans('admin/asset_maintenances/table.supplier_name') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_type">{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="title">{{ trans('admin/asset_maintenances/form.title') }}</th>
              <th data-searchable="true" data-sortable="false" data-field="start_date">{{ trans('admin/asset_maintenances/form.start_date') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="completion_date">{{ trans('admin/asset_maintenances/form.completion_date') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_time">{{ trans('admin/asset_maintenances/form.asset_maintenance_time') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="cost" class="text-right">{{ trans('admin/asset_maintenances/form.cost') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="user_id">{{ trans('general.admin') }}</th>
              <th data-searchable="true" data-sortable="true" data-field="notes" data-visible="false">{{ trans('admin/asset_maintenances/form.notes') }}</th>
              <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>

        </div>
    </div>
  </div>
@stop

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
          fileName: 'maintenances-export-' + (new Date()).toISOString().slice(0,10),
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
