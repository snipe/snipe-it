@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.license_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">
    <h3>@lang('general.license_report')</h3>
</div>

<div class="row">

<div class="table-responsive">
      <table
      name="licensesReport"
      id="table"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="licensesReportTable">
        <thead>
        <tr role="row">
            <th class="col-sm-1">@lang('admin/companies/table.title')</th>
            <th class="col-sm-1">@lang('admin/licenses/table.title')</th>
            <th class="col-sm-1">@lang('admin/licenses/table.serial')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.seats')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.remaining_seats')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.expiration')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.date')</th>
            <th class="col-sm-1">@lang('admin/licenses/form.cost')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($licenses as $license)
        <tr>
            <td>{{{ is_null($license->company) ? '' : $license->company->name }}}</td>
            <td>{{{ $license->name }}}</td>
            <td>{{{ mb_strimwidth($license->serial, 0, 50, "...") }}}</td>
            <td>{{ $license->seats }}</td>
            <td>{{ $license->remaincount() }}</td>
            <td>{{ $license->expiration_date }}</td>
            <td>{{ $license->purchase_date }}</td>
            <td>
            {{{ Setting::first()->default_currency }}}
            {{{ number_format($license->purchase_cost) }}}</td>
        </tr>
        @endforeach
    </tbody>
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
        sidePagination: 'client',
        sortable: true,
        cookie: true,
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
