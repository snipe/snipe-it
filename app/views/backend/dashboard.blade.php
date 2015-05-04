@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.dashboard') ::
@parent
@stop

{{-- Page content --}}
@section('content')




<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib/morris.css') }}">

<!-- morrisjs -->
<script src="{{ asset('assets/js/raphael-min.js') }}"></script>
<script src="{{ asset('assets/js/morris.min.js') }}"></script>


<div class="row">

<!-- morris bar & donut charts -->

    <div class="col-md-12">
        <h4 class="title">@lang('general.dashboard')</h4>
        <br>
    </div>
    <div class="col-md-9 chart">
        <h5>@lang('general.recent_activity')</h5>
        
        <table class="table table-hover table-fixed break-word">
			<thead>
			    <tr>
			        <th class="col-md-1"><span class="line"></span>@lang('general.date')</th>
			        <th class="col-md-2"><span class="line"></span>@lang('general.admin')</th>
			        <th class="col-md-3"><span class="line"></span>@lang('table.item')</th>
			        <th class="col-md-2"><span class="line"></span>@lang('table.actions')</th>
			        <th class="col-md-3"><span class="line"></span>@lang('general.user')</th>
			    </tr>
			</thead>
			<tbody>
			@if (count($recent_activity) > 0)
				@foreach ($recent_activity as $activity)
			    <tr>
			       <td>{{{ date("M d", strtotime($activity->created_at)) }}}</td> 
			       <td>{{{ $activity->adminlog->fullName() }}}</td> 
			       
			       <td>
			           	@if (($activity->assetlog) && ($activity->asset_type=="hardware"))
			            	{{ $activity->assetlog->showAssetName() }}
			            @elseif (($activity->licenselog) && ($activity->asset_type=="software"))
			            	{{ $activity->licenselog->name }}
			            @elseif (($activity->asset_type) && ($activity->asset_type=="accessory"))
			            	{{ $activity->accessorylog->name }}
			            @endif
			           	
			           	</td> 
			       <td>  
				       {{ strtolower(Lang::get('general.'.str_replace(' ','_',$activity->action_type))) }}
			       </td> 
			       <td>
			           @if ($activity->userlog) 
			           		{{{ $activity->userlog->fullName() }}}
			           	@endif
			           	
			           </td> 
			       
			       
			    </tr>
			   @endforeach
			@endif
			</tbody>
			</table>


    </div>
    <div class="col-md-3 chart">
        <h5>@lang('general.asset') @lang('general.status')</h5>
        <div id="hero-assets" style="height: 250px;"></div>    
    </div>



</div>



<!-- build the charts -->
    <script type="text/javascript">


        // Morris Donut Chart
        Morris.Donut({
            element: 'hero-assets',
            data: [
	            {label: '@lang('general.ready_to_deploy')', value: {{ $asset_stats['rtd']['percent'] }} },
                {label: '@lang('general.deployed')', value: {{ $asset_stats['deployed']['percent'] }} },              
                {label: '@lang('general.pending')', value: {{ $asset_stats['pending']['percent'] }} },
                {label: '@lang('general.undeployable')', value: {{ $asset_stats['undeployable']['percent'] }} },
                {label: '@lang('general.archived')', value: {{ $asset_stats['archived']['percent'] }} },
            ],
            colors: ["#30a1ec", "#76bdee", "#c4dafe"],
            formatter: function (y) { return y + "%" }
        });

   
    </script>


@stop
