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
    <table name="licenses" id="table" data-url="{{route('api.licenses.list')}}">
        <thead>
            <tr>
                <th data-field="name">{{Lang::get('admin/licenses/table.title')}}</th>
                <th data-field="serial">{{Lang::get('admin/licenses/table.serial')}}</th>
                <th data-field="totalSeats">{{Lang::get('admin/licenses/form.seats')}}</th>
                <th data-field="remaining">{{Lang::get('admin/licenses/form.remaining_seats')}}</th>
                <th data-field="purchase_date">{{Lang::get('admin/licenses/table.purchase_date')}}</th>
                <th data-field="actions">{{Lang::get('table.actions')}}</th>
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-hover table-no-bordered',
        undefinedText: 'undefined',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{{ Setting::getSettings()->per_page }}},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: false,
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
