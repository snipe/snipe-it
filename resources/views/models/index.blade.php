@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/models/table.title') }}
@parent
@stop

{{-- Page title --}}
@section('header_right')
  @if(Input::get('status')=='Deleted')
      <a href="{{ URL::to('hardware/models') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  {{ trans('admin/models/general.view_models') }}</a>
  @else
      <a href="{{ route('create/model') }}" class="btn btn-primary pull-right">
      {{ trans('general.create') }}</a>
      <a href="{{ URL::to('hardware/models?status=Deleted') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  {{ trans('admin/models/general.view_deleted') }}</a>
  @endif
@stop


{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
        name="models"
        class="table table-striped"
        id="table"
        data-url="{{ route('api.models.list',array('status'=>e(Input::get('status')))) }}"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="modelsTable-{{ config('version.hash_version') }}">
          <thead>
            <tr>
              <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
              <th data-sortable="true" data-field="image"  data-visible="false">{{ trans('admin/hardware/table.image') }}</th>
              <th data-sortable="false" data-field="manufacturer">{{ trans('general.manufacturer') }}</th>
              <th data-sortable="true" data-field="name">{{ trans('admin/models/table.title') }}</th>
              <th data-sortable="true" data-field="modelnumber">{{ trans('admin/models/table.modelnumber') }}</th>
              <th data-sortable="false" data-field="numassets">{{ trans('admin/models/table.numassets') }}</th>
              <th data-sortable="false" data-field="depreciation">{{ trans('general.depreciation') }}</th>
              <th data-sortable="false" data-field="category">{{ trans('general.category') }}</th>
              <th data-sortable="true" data-field="eol">{{ trans('general.eol') }}</th>
              <th data-sortable="false" data-field="note">{{ trans('general.notes') }}</th>
              <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
            </tr>
          </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->


  </div>
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
        classes: 'table table-hover table-no-bordered',
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
            fileName: 'models-export-' + (new Date()).toISOString().slice(0,10),
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
