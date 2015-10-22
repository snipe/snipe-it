@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/models/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/model') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
        @if(Input::get('status')=='Deleted')
            <a href="{{ URL::to('hardware/models') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  @lang('admin/models/general.view_models')</a>
        @else
            <a href="{{ URL::to('hardware/models?status=Deleted') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  @lang('admin/models/general.view_deleted')</a>
        @endif
        <h3>@lang('admin/models/table.title')</h3>
    </div>
</div>

<div class="row form-wrapper">

    <table name="models" id="table" data-url="{{route('api.models.list', Input::get('status'))}}">
        <thead>
            <tr>
                <th data-sortable="true" data-field="manufacturer">{{Lang::get('general.manufacturer')}}</th>
                <th data-sortable="true" data-field="name">{{Lang::get('admin/models/table.title')}}</th>
                <th data-sortable="true" data-field="modelnumber">{{Lang::get('admin/models/table.modelnumber')}}</th>
                <th data-sortable="true" data-field="numassets">{{Lang::get('admin/models/table.numassets')}}</th>
                <th data-sortable="true" data-field="depreciation">{{Lang::get('general.depreciation')}}</th>
                <th data-sortable="true" data-field="category">{{Lang::get('general.category')}}</th>
                <th data-sortable="true" data-field="eol">{{Lang::get('general.eol')}}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ Lang::get('table.actions') }}</th>
            </tr>
        </thead>
    </table>

@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>
<script src="//rawgit.com/kayalshri/tableExport.jquery.plugin/master/tableExport.js?v=1') }}"></script>
<script src="//rawgit.com/kayalshri/tableExport.jquery.plugin/master/jquery.base64.js?v=1') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-hover table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{{ Setting::getSettings()->per_page }}},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
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
