@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/statuslabels/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/statuslabel') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('admin/statuslabels/table.title')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

      <table
      name="statuslabels"
      id="table"
      data-url="{{ route('api.statuslabels.list') }}"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="statuslabelsTable-{{ Config::get('version.hash_version') }}">
          <thead>
              <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">@lang('general.id')</th>
                  <th data-sortable="true" data-field="name">@lang('admin/statuslabels/table.name')</th>
                  <th data-sortable="false" data-field="type">@lang('admin/statuslabels/table.status_type')</th>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ Lang::get('table.actions') }}</th>
              </tr>
          </thead>
      </table>
</div>

    <!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
        <br /><br />
        <h6>@lang('admin/statuslabels/table.about')</h6>
        <p>@lang('admin/statuslabels/table.info')</p>

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
