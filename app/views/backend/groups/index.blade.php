@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('admin/groups/titles.group_management') ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/group') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@lang('admin/groups/titles.group_management')</h3>
    </div>
</div>


<div class="row">

       <table
        name="groups"
        id="table"
        data-toggle="table"
        data-url="{{ route('api.groups.list') }}"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="userGroupDisplay-{{ Config::get('version.hash_version') }}">
           <thead>
               <tr>
                   <th data-switchable="true" data-sortable="false" data-field="id" data-visible="false">@lang('general.id')</th>
                   <th data-switchable="true" data-sortable="true" data-field="name" data-visible="true">@lang('admin/groups/table.name')</th>
                   <th data-switchable="true" data-sortable="false" data-field="users" data-visible="true">@lang('admin/groups/table.users')</th>
                   <th data-switchable="true" data-sortable="true" data-field="created_at" data-visible="true">@lang('general.created_at')</th>
                   <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" >{{ Lang::get('table.actions') }}</th>
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
