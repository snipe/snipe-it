@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/suppliers/table.suppliers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/supplier') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('admin/suppliers/table.suppliers')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-12">
      <table
      name="suppliers"
      id="table"
      data-url="{{ route('api.suppliers.list') }}"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="suppliersTable-{{ Config::get('version.hash_version') }}">
          <thead>
              <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">@lang('admin/suppliers/table.id')</th>
                  <th data-sortable="true" data-field="name">@lang('admin/locations/table.name')</th>
                  <th data-sortable="true" data-field="address">@lang('admin/suppliers/table.address')</th>
                  <th data-searchable="true" data-sortable="true" data-field="contact">@lang('admin/suppliers/table.contact')</th>
                  <th data-searchable="true" data-sortable="true" data-field="email">@lang('admin/suppliers/table.email')</th>
                  <th data-searchable="true" data-sortable="true" data-field="phone">@lang('admin/suppliers/table.phone')</th>
                  <th data-searchable="true" data-sortable="true" data-field="fax" data-visible="false">@lang('admin/suppliers/table.fax')</th>
                  <th data-searchable="false" data-sortable="false" data-field="assets">@lang('admin/suppliers/table.assets')</th>
                  <th data-searchable="false" data-sortable="false" data-field="licenses">@lang('admin/suppliers/table.licenses')</th>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ Lang::get('table.actions') }}</th>
              </tr>
          </thead>
      </table>
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
