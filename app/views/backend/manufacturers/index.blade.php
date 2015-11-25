@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/manufacturers/table.asset_manufacturers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/manufacturer') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('admin/manufacturers/table.asset_manufacturers')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">


<div class="table-responsive">

    <table
    name="manufacturers"
    id="table"
    data-url="{{route('api.manufacturers.list')}}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="manufacturersTable-{{ Config::get('version.hash_version') }}">
        <thead>
            <tr>
                <th data-sortable="true" data-field="id" data-visible="false">@lang('general.id')</th>
                <th data-sortable="true" data-field="name">@lang('admin/manufacturers/table.name')</th>
                <th data-switchable="true" data-searchable="false" data-sortable="false" data-field="assets">@lang('general.assets')</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">@lang('table.actions')</th>
            </tr>
        </thead>
    </table>

</div>
</div>

    <!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
        <br /><br />
        <h6>Have Some Haiku</h6>
        <p>The Staples truck came.<br>
        Left thirteen cardboard boxes.<br>
        Honey stained maple.</p>

        <p>----------</p>

        <p>I'm sorry, there's – um -<br>
        insufficient – what's-it-called?<br>
        The term eludes me...</p>

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
