@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.activity_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">

    <h3>@lang('general.activity_report')</h3>
</div>


<div class="row">

<div class="table-responsive">
      <table
      name="activityReport"
      id="table"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="activityReportTable">

        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('general.admin')</th>
            <th class="col-sm-1"><span class="line"></span>@lang('general.action')</th>
            <th class="col-sm-1"><span class="line"></span>@lang('general.type')</th>
            <th class="col-sm-1"><span class="line"></span>@lang('general.item')</th>
            <th class="col-sm-1"><span class="line"></span>@lang('general.user')</th>
            <th class="col-sm-1"><span class="line"></span>@lang('general.date')</th
        </tr>
    </thead>
    <tbody>

        @foreach ($log_actions as $log_action)
        <tr>
            <td><a href="../admin/users/{{ $log_action->adminlog->id }}/view">{{{ $log_action->adminlog->fullName() }}}</a></td>
            <td>{{{ $log_action->action_type }}}</td>
            <td>
	            @if ($log_action->asset_type=="hardware")
	            	Asset
	            @elseif ($log_action->asset_type=="software")
	            	License
	            @elseif ($log_action->asset_type=="accessory")
	            	Accessory
                @elseif ($log_action->asset_type=="consumable")
    	            Consumable
	            @endif
            </td>

            <td>
            @if (($log_action->assetlog) && ($log_action->asset_type=="hardware"))
                 {{ $log_action->assetlog->showAssetName() }}
             @elseif (($log_action->licenselog) && ($log_action->asset_type=="software"))
                 {{ $log_action->licenselog->name }}
             @elseif (($log_action->consumablelog) && ($log_action->asset_type=="consumable"))
                 {{ $log_action->consumablelog->name }}
             @elseif (($log_action->accessorylog) && ($log_action->asset_type=="accessory"))
                 {{ $log_action->accessorylog->name }}
             @else
                 @lang('general.bad_data')
             @endif
            </td>
            <td>
	            @if ($log_action->userlog)
	            	<a href="../admin/users/{{ $log_action->userlog->id }}/view">{{{ $log_action->userlog->fullName() }}}</a>
	            @endif
            </td>

            <td>{{{ $log_action->created_at }}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

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
        sidePagination: 'client',
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
