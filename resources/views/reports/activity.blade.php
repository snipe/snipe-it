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
                <td>
                    @if($log_action->user)
                    <a href="../admin/users/{{ $log_action->user->id }}/view">{{ $log_action->user->fullName() }}</a>
                    @endif
                </td>
                <td>{{ $log_action->action_type }}</td>
                <td>
    	            {{ title_case($log_action->itemType()) }}
                </td>

                <td>

                @if ($item = $log_action->item)
                    @if ($log_action->itemType()=="asset")
                        {{ $item->showAssetName() }}
                    @else
                        {{ $item->name }}
                    @endif
                @else
                    {{ trans('general.bad_data') }}
                @endif
                </td>
                <td>
    	            @if ($log_action->target)
                        @if ($log_action->target instanceof \App\Models\User)
                        <a href="../admin/users/{{ $log_action->target->id }}/view">{{ $log_action->target->fullName() }}</a>
                        @elseif ($log_action->target instanceof \App\Models\Asset)
    	            	<a href="../hardware/{{ $log_action->target->id }}/view">{{ $log_action->target->showAssetName() }}</a>
                        @endif

    	            @endif
                </td>

                <td>{{ $log_action->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

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
        sidePagination: 'client',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
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
