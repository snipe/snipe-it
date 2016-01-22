@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $consumable->name }}}
 @lang('general.consumable') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>        </div>
        <h3>
            {{{ $consumable->name }}}
 @lang('general.consumable')

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

        @if ($consumable->purchase_date)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>@lang('admin/consumables/general.date'): </strong>
            {{{ $consumable->purchase_date }}} </div>
        @endif

        @if ($consumable->purchase_cost)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>@lang('admin/consumables/general.cost'):</strong>
            {{{ Setting::first()->default_currency }}}

            {{{ number_format($consumable->purchase_cost,2) }}} </div>
        @endif

        @if ($consumable->order_number)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>@lang('admin/consumables/general.order'):</strong>
            {{{ $consumable->order_number }}} </div>
        @endif
        <br />

        <table
        name="consumable_users"
        id="table"
        data-url="{{route('api.consumables.view', $consumable->id)}}"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="consumableDetailTable-{{ Config::get('version.hash_version') }}">
            <thead>
                <tr>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name">{{Lang::get('general.user')}}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="created_at">{{Lang::get('general.date')}}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="admin">{{Lang::get('general.admin')}}</th>
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
        search: false,
        pageSize: {{{ Setting::getSettings()->per_page }}},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
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
