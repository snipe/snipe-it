@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $accessory->name }}}
 @lang('general.accessory') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <a href="{{ URL::to('admin/accessories') }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>        </div>
        <h3>
            {{{ $accessory->name }}}
 @lang('general.accessory')

        </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
              <table
              name="accessory_users"
              id="table"
              data-url="{{ route('api.accessories.view', $accessory->id) }}"
              data-cookie="true"
              data-click-to-select="true"
              data-cookie-id-table="accessoryUsersTable">

                    <thead>
                        <tr>
                            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name">{{Lang::get('general.user')}}</th>
                            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{Lang::get('table.actions')}}</th>
                        </tr>
                    </thead>
                </table>
        </div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <div class="text-center">
        <a href="{{ route('checkout/accessory', $accessory->id) }}" style="margin-right:5px;" class="btn btn-info btn-sm" {{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>@lang('general.checkout')</a>
    </div>

    <br /><br />
    <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
    <p>@lang('admin/accessories/general.about_accessories_text') </p>

</div>

@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>
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
        columnsHidden: ['name'],
        showExport: true,
        exportLabel: 'Export',
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
