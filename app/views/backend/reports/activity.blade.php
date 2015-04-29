@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.license_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">

    <h3>@lang('general.activity_report')</h3>
</div>

<div class="row">

<div class="table-responsive">
<table id="example">
        <thead>
            <tr role="row">
            <th class="col-sm-1">Admin</th>
            <th class="col-sm-1">@lang('table.action')</th>
			<th class="col-sm-1"></th>
            <th class="col-sm-1">Type</th>
            <th class="col-sm-1">Item</th>
            <th class="col-sm-1">Date</th
        </tr>
    </thead>
    <tbody>

        @foreach ($log_actions as $log_action)
        <tr>
            <td><a href="../admin/users/{{ $log_action->adminlog->id }}/view">{{ $log_action->adminlog->fullName() }}</a></td>
            <td>{{{ $log_action->action_type }}}</td>
            <td>
	            @if ($log_action->userlog)
	            	<a href="../admin/users/{{ $log_action->userlog->id }}/view">{{ $log_action->userlog->fullName() }}</a>
	            @endif
            </td>
            <td>
	            @if ($log_action->assetlog)
	            	Asset
	            @elseif ($log_action->licenselog)
	            	License
	            @elseif ($log_action->accessorylog) 
	            	Accessory
	            @endif
	            
            </td>
            <td>
	            
	            @if ($log_action->assetlog)
	            	{{ $log_action->assetlog->name }}
	            @elseif ($log_action->licenselog)
	            	{{ $log_action->licenselog->name }}
	            @elseif ($log_action->accessorylog) 
	            	{{ $log_action->accessorylog->name }}
	            @endif

	            
            </td>
            <td>{{{ $log_action->created_at }}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

@stop
