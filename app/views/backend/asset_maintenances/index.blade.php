@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/asset_maintenances/general.improvements') ::
@parent
@stop

{{-- Page content --}}
@section('content')

    <link rel="stylesheet" href="https://demo.snipeitapp.com/assets/css/lib/jquery.dataTables.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="https://demo.snipeitapp.com/assets/css/compiled/dataTables.colVis.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="https://demo.snipeitapp.com/assets/css/compiled/dataTables.tableTools.css" type="text/css" media="screen" />

    <div class="row header">
        <div class="col-md-12">
            <a href="{{ route('create/asset_maintenances') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> Create New</a>
            <h3>@lang('admin/asset_maintenances/general.asset_maintenances')</h3>
        </div>
    </div>

    <div class="row form-wrapper">
          <table
         name="maintenances"
         id="table"
         data-url="{{route('api.asset_maintenances.list')}}"
         data-cookie="true"
         data-click-to-select="true"
         data-cookie-id-table="maintenancesTable-{{ Config::get('version.hash_version') }}">
            <thead>
                     <tr>
                     <th data-field="companyName" data-sortable="false" data-visible="false">@lang('admin/companies/table.title')</th>
                     <th data-sortable="true" data-field="id" data-visible="false">@lang('general.id')</th>
                         <th data-sortable="false" data-field="asset_name">@lang('admin/asset_maintenances/table.asset_name')</th>
                         <th data-sortable="false" data-field="supplier">@lang('admin/asset_maintenances/table.supplier_name')</th>
                         <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_type">@lang('admin/asset_maintenances/form.asset_maintenance_type')</th>
                         <th data-searchable="true" data-sortable="true" data-field="title">@lang('admin/asset_maintenances/form.title')</th>
                         <th data-searchable="true" data-sortable="false" data-field="start_date">@lang('admin/asset_maintenances/form.start_date')</th>
                         <th data-searchable="true" data-sortable="true" data-field="completion_date">@lang('admin/asset_maintenances/form.completion_date')</th>
                         <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_time">@lang('admin/asset_maintenances/form.asset_maintenance_time')</th>
                         <th data-searchable="true" data-sortable="true" data-field="cost" class="text-right">@lang('admin/asset_maintenances/form.cost')</th>
                         <th data-searchable="true" data-sortable="true" data-field="notes" data-visible="false">@lang('admin/asset_maintenances/form.notes')</th>
                         <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ Lang::get('table.actions') }}</th>
                     </tr>
                 </thead>
            </table>
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
      pageSize: {{{ Setting::getSettings()->per_page }}},
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
      maintainSelected: true,
      paginationFirstText: "@lang('general.first')",
      paginationLastText: "@lang('general.last')",
      paginationPreText: "@lang('general.previous')",
      paginationNextText: "@lang('general.next')",
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
