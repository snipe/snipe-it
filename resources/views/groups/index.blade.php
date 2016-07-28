@extends('layouts/default')

{{-- Web site Title --}}
@section('title')
{{ trans('admin/groups/titles.group_management') }}
@parent
@stop

@section('header_right')
<a href="{{ route('create/group') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
@stop


{{-- Content --}}
@section('content')

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-body">

        <div class="table-responsive">

          <table
          name="groups"
          class="table table-striped"
          id="table"
          data-toggle="table"
          data-url="{{ route('api.groups.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="userGroupDisplay-{{ config('version.hash_version') }}">
           <thead>
             <tr>
               <th data-switchable="true" data-sortable="false" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
               <th data-switchable="true" data-sortable="true" data-field="name" data-visible="true">{{ trans('admin/groups/table.name') }}</th>
               <th data-switchable="true" data-sortable="false" data-field="users" data-visible="true">{{ trans('admin/groups/table.users') }}</th>
               <th data-switchable="true" data-sortable="true" data-field="created_at" data-visible="true">{{ trans('general.created_at') }}</th>
               <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" >{{ trans('table.actions') }}</th>
             </tr>
           </thead>
       </table>
      </div>
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
        pageSize: {{ \App\Models\Setting::getSettings()->per_page }},
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
        exportOptions: {
            fileName: 'groups-export-' + (new Date()).toISOString().slice(0,10),
        },
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
