@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.accessory_report') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <div class="table-responsive">
                    <table
                    name="accessoriesReport"
                    id="table"
                    data-cookie="true"
                    data-click-to-select="true"
                    data-cookie-id-table="accessoriesReportTable">

                        <thead>
                            <tr role="row">
                                <th class="col-sm-1">{{ trans('admin/companies/table.title') }}</th>
                                <th class="col-sm-1">{{ trans('admin/accessories/table.title') }}</th>
                                <th class="col-sm-1">{{ trans('admin/accessories/general.total') }}</th>
                                <th class="col-sm-1">{{ trans('admin/accessories/general.remaining') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accessories as $accessory)
                            <tr>
                                <td>{{ is_null($accessory->company) ? '' : $accessory->company->name }}</td>
                                <td>{{ $accessory->name }}</td>
                                <td>{{ $accessory->qty }}</td>
                                <td>{{ $accessory->numRemaining() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@section('moar_scripts')
<script src="{{ asset('js/bootstrap-table.js') }}"></script>
<script src="{{ asset('js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{ $snipeSettings->per_page }},
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
