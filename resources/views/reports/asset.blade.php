@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.asset_report') }}
@parent
@stop

@section('header_right')
<a href="{{ route('reports/export/assets') }}" class="btn btn-default"><i class="fa fa-download icon-white"></i>
{{ trans('admin/hardware/table.dl_csv') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

  <div class="box box-default">
    <div class="box-body">

      <div class="table-responsive">

      <table
                  name="assetsReport"
                  {{-- data-row-style="rowStyle" --}}
                  data-toolbar="#toolbar"
                  class="table table-striped"
                  id="table"
                  data-url="{{route('api.hardware.list', array(''=>e(Input::get('status')),'order_number'=>e(Input::get('order_number')), 'status_id'=>e(Input::get('status_id')), 'report'=>'true'))}}"
                  data-cookie="true"
                  data-click-to-select="true"
                  data-cookie-id-table="{{ e(Input::get('status')) }}assetTable-{{ config('version.hash_version') }}">
              <thead>
              <tr>
                  @if (Input::get('status')!='Deleted')
                      <th data-class="hidden-xs" data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkbox"><div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div></th>
                  @endif
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                  <th data-field="companyName" data-searchable="true" data-sortable="true" data-switchable="true" data-visible="false">{{ trans('general.company') }}</th>
                  <th data-sortable="true" data-field="name" data-visible="false">{{ trans('admin/hardware/form.name') }}</th>
                  <th data-sortable="true" data-field="asset_tag">{{ trans('admin/hardware/table.asset_tag') }}</th>
                  <th data-sortable="true" data-field="serial">{{ trans('admin/hardware/table.serial') }}</th>
                  <th data-sortable="true" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
                  <th data-sortable="true" data-field="model_number" data-visible="false">{{ trans('admin/models/table.modelnumber') }}</th>
                  <th data-sortable="true" data-field="status_label">{{ trans('admin/hardware/table.status') }}</th>
                  <th data-sortable="true" data-field="assigned_to">{{ trans('admin/hardware/form.checkedout_to') }}</th>
                  <th data-sortable="true" data-field="location" data-searchable="true">{{ trans('admin/hardware/table.location') }}</th>
                  <th data-sortable="true" data-field="category" data-searchable="true">{{ trans('general.category') }}</th>
                  <th data-sortable="true" data-field="manufacturer" data-searchable="true" data-visible="false">{{ trans('general.manufacturer') }}</th>
                  <th data-sortable="true" data-field="purchase_cost" data-searchable="true" data-visible="false">{{ trans('admin/hardware/form.cost') }}</th>
                  <th data-sortable="true" data-field="purchase_date" data-searchable="true" data-visible="false">{{ trans('admin/hardware/form.date') }}</th>
                  <th data-sortable="false" data-field="eol" data-searchable="true">{{ trans('general.eol') }}</th>
                  <th data-sortable="true" data-searchable="true" data-field="notes">{{ trans('general.notes') }}</th>
                  <th data-sortable="true" data-searchable="true"  data-field="order_number">{{ trans('admin/hardware/form.order') }}</th>
                  <th data-sortable="true" data-searchable="true" data-field="last_checkout">{{ trans('admin/hardware/table.checkout_date') }}</th>
                  <th data-sortable="true" data-field="expected_checkin" data-searchable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                  @foreach(\App\Models\CustomField::all() AS $field)


                      <th data-sortable="{{ ($field->field_encrypted=='1' ? 'false' : 'true') }}" data-visible="false" data-field="{{$field->db_column_name()}}">
                          @if ($field->field_encrypted=='1')
                              <i class="fa fa-lock"></i>
                          @endif

                          {{$field->name}}
                      </th>

                  @endforeach
                  <th data-sortable="true" data-field="created_at" data-searchable="true" data-visible="false">{{ trans('general.created_at') }}</th>

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
        pageSize: 100,
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        showMultiSort: true,
        cookie: true,
        cookieExpire: '2y',
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'excel', 'txt','json', 'xml'],
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200','500','1000'],
        exportOptions: {
            fileName: 'assets-export-' + (new Date()).toISOString().slice(0,10),
        },
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            sort: 'fa fa-sort-amount-desc',
            plus: 'fa fa-plus',
            minus: 'fa fa-minus',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });

</script>
@stop

@stop
