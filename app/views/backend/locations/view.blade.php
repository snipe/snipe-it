@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $location->name }}}
 @lang('general.locations') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <a href="{{ URL::previous() }}" class="btn-flat gray" style="margin-right: 10px;"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
           <a href="{{ route('update/location', $location->id) }}" class="btn-flat default">@lang('admin/locations/table.update') </a>
        </div>
        <h3>
            {{{ $location->name }}}
 @lang('general.locations')

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-12">

  <div class="col-md-12">

    <h3>@lang('general.users')</h3>

    <!--  locations users table -->
    <table
    name="location_users"
    id="table-users"
    data-url="{{route('api.locations.viewusers', $location->id)}}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="location_usersDetailTable">
        <thead>
            <tr>
                <th data-searchable="false" data-sortable="false" data-field="name">@lang('general.user')</th>
            </tr>
        </thead>
    </table>
  </div>


  <div class="col-md-12">
    <h3>@lang('general.assets')</h3>

    <!-- location assets table -->
    <table
    name="location_assets"
    id="table-assets"
    data-url="{{route('api.locations.viewassets', $location->id)}}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="location_assetsDetailTable">
        <thead>
            <tr>
                <th data-searchable="false" data-sortable="false" data-field="name">@lang('general.name')</th>
                <th data-searchable="false" data-sortable="false" data-field="model">@lang('admin/hardware/form.model')</th>
                <th data-searchable="false" data-sortable="false" data-field="asset_tag">@lang('admin/hardware/form.tag')</th>
                <th data-searchable="false" data-sortable="false" data-field="serial">@lang('admin/hardware/form.serial')</th>
            </tr>
        </thead>
    </table>
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
    $('#table-users').bootstrapTable({
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

<script type="text/javascript">
    $('#table-assets').bootstrapTable({
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
