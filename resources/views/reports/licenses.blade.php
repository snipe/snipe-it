@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.license_report') }} 
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
                    name="licensesReport"
                    id="table"
                    class="table table-striped"
                    data-cookie="true"
                    data-click-to-select="true"
                    data-cookie-id-table="licensesReportTable">
                        <thead>
                            <tr role="row">
                                <th class="col-sm-1">{{ trans('admin/companies/table.title') }}</th>
                                <th class="col-sm-1">{{ trans('admin/licenses/table.title') }}</th>
                                <th class="col-sm-1">{{ trans('admin/licenses/form.license_key') }}</th>
                                <th class="col-sm-1">{{ trans('admin/licenses/form.seats') }}</th>
                                <th class="col-sm-1">{{ trans('admin/licenses/form.remaining_seats') }}</th>
                                <th class="col-sm-1">{{ trans('admin/licenses/form.expiration') }}</th>
                                <th class="col-sm-1">{{ trans('general.purchase_date') }}</th>
                                <th class="col-sm-1 text-right" class="col-sm-1">{{ trans('general.purchase_cost') }}</th>
                                <th class="col-sm-1">{{ trans('general.depreciation') }}</th>
                                <th class="col-sm-1 text-right">{{ trans('admin/hardware/table.book_value') }}</th>
                                <th class="col-sm-1 text-right">{{ trans('admin/hardware/table.diff') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($licenses as $license)
                            <tr>
                                <td>{{ is_null($license->company) ? '' : $license->company->name }}</td>
                                <td>{{ $license->name }}</td>
                                <td>{{ mb_strimwidth($license->serial, 0, 50, "...") }}</td>
                                <td>{{ $license->seats }}</td>
                                <td>{{ $license->remaincount() }}</td>
                                <td>{{ $license->expiration_date }}</td>
                                <td>{{ $license->purchase_date }}</td>
                                <td class="text-right">
                                    {{ $snipeSettings->default_currency }}{{ \App\Helpers\Helper::formatCurrencyOutput($license->purchase_cost) }}
                                </td>
                                <td>
                                    {{ ($license->depreciation) ? e($license->depreciation->name).' ('.$license->depreciation->months.' '.trans('general.months').')' : ''  }}
                                </td>
                                <td class="text-right">
                                    {{ $snipeSettings->default_currency }}{{ \App\Helpers\Helper::formatCurrencyOutput($license->getDepreciatedValue()) }}
                                </td>
                                <td class="text-right">
                                    -{{ $snipeSettings->default_currency }}{{ \App\Helpers\Helper::formatCurrencyOutput(($license->purchase_cost - $license->getDepreciatedValue())) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.table-responsive-->
            </div>
        </div>
    </div>
</div>

@stop

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
