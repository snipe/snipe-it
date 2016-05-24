@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/licenses/general.software_licenses') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/licenses') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> Create New</a>
        <h3>@lang('admin/licenses/general.software_licenses')</h3>
    </div>
</div>

<div class="row form-wrapper">
    <table
    name="licenses"
    id="table"
    data-url="{{route('api.licenses.list')}}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="licenseTable">
        <thead>
            <tr>
                <th data-sortable="true" data-field="id" data-visible="false">@lang('general.id')</th>
                <th data-field="companyName" data-sortable="false" data-switchable="true">@lang('general.company')</th>
                <th data-field="name" data-sortable="true">{{Lang::get('admin/licenses/table.title')}}</th>
                <th data-field="serial" data-sortable="true">{{Lang::get('admin/licenses/table.serial')}}</th>
                <th data-field="totalSeats">{{Lang::get('admin/licenses/form.seats')}}</th>
                <th data-field="remaining">{{Lang::get('admin/licenses/form.remaining_seats')}}</th>
                <th data-field="purchase_date">{{Lang::get('admin/licenses/table.purchase_date')}}</th>
                <th data-field="actions">{{Lang::get('table.actions')}}</th>
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
