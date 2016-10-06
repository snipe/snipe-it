@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.activity_report') }} 
@parent
@stop

{{-- Page content --}}
@section('content')



<div class="row">
  <div class="col-md-12">

  <div class="box box-default">
    <div class="box-body">

        <table
                name="activityReport"
                data-toolbar="#toolbar"
                class="table table-striped"
                id="table"
                data-url="{{ route('api.activity.list') }}"
                data-cookie="true"
                data-cookie-id-table="activityReportTable">
            <thead>
            <tr>
                <th class="col-sm-1" data-field="admin">{{ trans('general.admin') }}</th>
                <th class="col-sm-1" data-field="action_type">{{ trans('general.action') }}</th>
                <th class="col-sm-1" data-field="item_type">{{ trans('general.type') }}</th>
                <th class="col-sm-1" data-field="item">{{ trans('general.item') }}</th>
                <th class="col-sm-1" data-field="target">To</th>
                <th class="col-sm-1" data-field="created_at">{{ trans('general.date') }}</th>
                <th class="col-sm-1" data-field="note">{{ trans('general.notes') }}</th>
            </tr>
            </thead>

        </table>


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
