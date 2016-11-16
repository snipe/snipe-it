@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.locations') }}
@parent
@stop

@section('header_right')
<a href="{{ route('create/location') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop
{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
          name="locations"
          class="table table-striped"
          id="table"
          data-url="{{ route('api.locations.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="locationsTable-{{ config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name">{{ trans('admin/locations/table.name') }}</th>
                <th data-sortable="true" data-field="parent">{{ trans('admin/locations/table.parent') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="assets_default">{{ trans('admin/locations/table.assets_rtd') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="assets_checkedout">{{ trans('admin/locations/table.assets_checkedout') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="currency">{{ App\Models\Setting::first()->default_currency }}</th>
                <th data-searchable="true" data-sortable="true" data-field="address">{{ trans('admin/locations/table.address') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="city">{{ trans('admin/locations/table.city') }}
                </th>
                <th data-searchable="true" data-sortable="true" data-field="state">
                 {{ trans('admin/locations/table.state') }}
                </th>
                  <th data-searchable="true" data-sortable="true" data-field="zip">
                      {{ trans('admin/locations/table.zip') }}
                  </th>
                <th data-searchable="true" data-sortable="true" data-field="country">
                {{ trans('admin/locations/table.country') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
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
            fileName: 'locations-export-' + (new Date()).toISOString().slice(0,10),
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
