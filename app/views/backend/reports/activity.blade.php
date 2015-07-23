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
<table id="example">
        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('general.admin')</th>
            <th class="col-sm-1">@lang('general.action')</th>
			<th class="col-sm-1"></th>
            <th class="col-sm-1">@lang('general.type')</th>
            <th class="col-sm-1">@lang('general.item')</th>
            <th class="col-sm-1">@lang('general.date')</th
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
	            @if ($log_action->asset_type=="hardware")
	            	Asset
	            @elseif ($log_action->asset_type=="software")
	            	License
	            @elseif ($log_action->asset_type=="accessory") 
	            	Accessory
	            @endif	            
            </td>
            <td>
	            
        	@if (($log_action->assetlog) && ($log_action->asset_type=="hardware"))
	            {{ $log_action->assetlog->showAssetName() }}
            @elseif (($log_action->licenselog) && ($log_action->asset_type=="software"))
            	{{ $log_action->licenselog->name }}
            @elseif (($log_action->asset_type) && ($log_action->asset_type=="accessory"))
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
