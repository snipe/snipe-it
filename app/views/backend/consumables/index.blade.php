@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.consumables') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/consumable') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@lang('general.consumables')</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
            <table
            name="consumables"
            id="table"
            data-url="{{route('api.consumables.list') }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="consumablesTable-{{ Config::get('version.hash_version') }}-{{ Config::get('version.hash_version') }}">
                <thead>
                    <tr>
                        <th data-sortable="true" data-field="id" data-visible="false">@lang('general.id')</th>
                        <th data-switchable="true" data-searchable="true" data-sortable="true" data-field="companyName">@lang('admin/companies/table.title')</th>
                        <th data-sortable="true" data-searchable="true" data-field="name">@lang('admin/consumables/table.title')</th>
                        <th data-searchable="true" data-sortable="true" data-field="location">@lang('general.location')</th>
                        <th data-searchable="true" data-sortable="true" data-field="category">@lang('general.category')</th>
                        <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="qty"> @lang('admin/consumables/general.total')</th>
                        <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="numRemaining"> @lang('admin/consumables/general.remaining')</th>
                        <th data-sortable="true" data-searchable="true" data-field="order_number" data-visible="false">@lang('admin/consumables/general.order')</th>
                        <th data-sortable="true" data-searchable="true" data-field="purchase_date" data-visible="false">@lang('admin/consumables/general.date')</th>
                        <th data-sortable="true" data-searchable="true" data-field="purchase_cost" data-visible="false">@lang('admin/consumables/general.cost')</th>
                        <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions"> @lang('table.actions')</th>

                    </tr>
                </thead>
            </table>
        </div>


        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br /><br />
            <h6>@lang('admin/consumables/general.about_consumables_title')</h6>
            <p>@lang('admin/consumables/general.about_consumables_text') </p>

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
