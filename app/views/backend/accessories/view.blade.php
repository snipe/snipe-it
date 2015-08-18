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
           <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>        </div>
        <h3>
            {{{ $accessory->name }}}
 @lang('general.accessory')

        </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
            @if ($accessory->users->count() > 0)
                <table name="accessory_users" id="table" data-url="{{route('api.accessories.view', $accessory->id)}}">
                    <thead>
                        <tr>
                            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name">{{Lang::get('general.user')}}</th>
                            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{Lang::get('table.actions')}}</th>
                        </tr>
                    </thead>
                </table>
            @else
                <div class="col-md-9">
                    <div class="alert alert-info alert-block">
                        <i class="fa fa-info-circle"></i>
                        @lang('general.no_results')
                    </div>
                </div>
            @endif
        </div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br /><br />
    <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
    <p>@lang('admin/accessories/general.about_accessories_text') </p>

</div>

<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-hover table-no-bordered',
        undefinedText: 'undefined',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: false,
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
