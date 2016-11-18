@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.accessories') }}
@parent
@stop

@section('header_right')
    @can('accessories.create')
        <a href="{{ route('create/accessory') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
          name="accessories"
          class="table table-striped"
          id="table"
          data-url="{{route('api.accessories.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="accessoriesTable-{{ config('version.hash_version') }}">
            <thead>
                <tr>
                  <th data-switchable="true" data-searchable="true" data-sortable="true" data-field="companyName" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
                  <th data-sortable="true" data-searchable="true"  data-field="name">{{ trans('admin/accessories/table.title') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="category">{{ trans('admin/accessories/general.accessory_category') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="model_number">{{ trans('admin/models/table.modelnumber') }}</th>
                  <th data-field="manufacturer" data-searchable="true" data-sortable="true">{{ trans('general.manufacturer') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="qty">{{ trans('admin/accessories/general.total') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="purchase_date" data-visible="false">{{ trans('admin/accessories/general.date') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="purchase_cost">{{ trans('admin/accessories/general.cost') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="order_number" data-visible="false">{{ trans('admin/accessories/general.order') }}</th>
                  <th data-searchable="false" data-sortable="true" data-field="min_amt">{{ trans('general.min_amt') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="numRemaining">{{ trans('admin/accessories/general.remaining') }}</th>
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
            fileName: 'accessories-export-' + (new Date()).toISOString().slice(0,10),
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
