@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.activity_report') }} 
@parent
@stop

{{-- Page content --}}
@section('content')



<div class="row">
  <div class="col-md-12">

  <div class="box box-default">
    <div class="box-body">

<<<<<<< HEAD
      <div class="table-responsive">
          <table
          name="activityReport"
          id="table"
          class="table table-striped"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="activityReportTable">

            <thead>
                <tr role="row">
                <th class="col-sm-1">{{ trans('general.admin') }}</th>
                <th class="col-sm-1"><span class="line"></span>{{ trans('general.action') }}</th>
                <th class="col-sm-1"><span class="line"></span>{{ trans('general.type') }}</th>
                <th class="col-sm-1"><span class="line"></span>{{ trans('general.item') }}</th>
                <th class="col-sm-1"><span class="line"></span>{{ trans('general.user') }}</th>
                <th class="col-sm-1"><span class="line"></span>{{ trans('general.date') }}</th
            </tr>
        </thead>
        <tbody>

            @foreach ($log_actions as $log_action)
            <tr>
                <td><a href="../admin/users/{{ $log_action->adminlog->id }}/view">{{ $log_action->adminlog->fullName() }}</a></td>
                <td>{{ $log_action->action_type }}</td>
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
                     {{ trans('general.bad_data') }}
                 @endif
                </td>
                <td>
    	            @if ($log_action->userlog)
    	            	<a href="../admin/users/{{ $log_action->userlog->id }}/view">{{ $log_action->userlog->fullName() }}</a>
    	            @endif
                </td>

                <td>{{ $log_action->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
=======
        <table
                name="activityReport"
                data-toolbar="#toolbar"
                class="table table-striped"
                id="table"
                data-url="{{ route('api.activity.list') }}"
                data-cookie="true"
                data-cookie-id-table="activityReportTable">
            <thead>
            <tr>
                <th class="col-sm-1" data-field="admin">{{ trans('general.admin') }}</th>
                <th class="col-sm-1" data-field="action_type">{{ trans('general.action') }}</th>
                <th class="col-sm-1" data-field="item_type">{{ trans('general.type') }}</th>
                <th class="col-sm-1" data-field="item">{{ trans('general.item') }}</th>
                <th class="col-sm-1" data-field="target">To</th>
                <th class="col-sm-1" data-field="created_at">{{ trans('general.date') }}</th>
                <th class="col-sm-1" data-field="note">{{ trans('general.notes') }}</th>
            </tr>
            </thead>

        </table>

>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

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
<<<<<<< HEAD
        pageSize: {{ \App\Models\Setting::getSettings()->per_page }},
        pagination: true,
        sidePagination: 'client',
        sortable: true,
        cookie: true,
=======
        pageSize: 100,
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        showMultiSort: true,
        cookie: true,
        cookieExpire: '2y',
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
<<<<<<< HEAD
        exportTypes: ['csv', 'txt','json', 'xml'],
=======
        exportTypes: ['csv', 'excel', 'txt','json', 'xml'],
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
<<<<<<< HEAD
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
=======
        pageList: ['10','25','50','100','150','200','500','1000'],
        exportOptions: {
            fileName: 'assets-export-' + (new Date()).toISOString().slice(0,10),
        },
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            sort: 'fa fa-sort-amount-desc',
            plus: 'fa fa-plus',
            minus: 'fa fa-minus',
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
<<<<<<< HEAD
=======

>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
</script>
@stop

@stop
