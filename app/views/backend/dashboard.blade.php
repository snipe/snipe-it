@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.dashboard') ::
@parent
@stop

{{-- Page content --}}
@section('content')
 <link href="/assets/css/lib/morris.css" type="text/css" rel="stylesheet" />
 <!-- morrisjs -->
<script src="/assets/js/raphael-min.js"></script>
<script src="/assets/js/morris.min.js"></script>

<div class="row">

            <!-- morris bar & donut charts -->
           
                <div class="col-md-12">
                    <h4 class="title">@lang('general.dashboard')</h4>
                    <br>
                </div>
                <div class="col-md-9 chart">
                    <h5>Recent Activity</h5>
                    
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
		               	@if ($activity->asset_type=="hardware") 
		               		{{{ $activity->assetlog->name }}}
		               	@elseif ($activity->asset_type=="software")
		               		@if ($activity->licenselog)
		               		{{{ $activity->licenselog->name }}}
		               		@endif
		               	@endif
		               	
		               	</td> 
		           <td>{{{ $activity->action_type }}}</td> 
	               <td>
		               @if ($activity->userlog) 
		               		{{{ $activity->userlog->fullName() }}}
		               	@endif
		               	
		               </td> 
	               
	               
                </tr>
               @endforeach
               
            @else
            bupkiss
            @endif
            </tbody>
        </table>


                </div>
                <div class="col-md-3 chart">
                    <h5>Asset Status</h5>
                    <div id="hero-assets" style="height: 250px;"></div>    
                </div>
          


</div>



<!-- build the charts -->
    <script type="text/javascript">


        // Morris Donut Chart
        Morris.Donut({
            element: 'hero-assets',
            data: [
	            {label: 'Ready to Deploy', value: {{ $asset_stats['rtd']['percent'] }} },
                {label: 'Deployed', value: {{ $asset_stats['deployed']['percent'] }} },              
                {label: 'Pending', value: {{ $asset_stats['pending']['percent'] }} },
                {label: 'Undeployable', value: {{ $asset_stats['undeployable']['percent'] }} },
                {label: 'Archived', value: {{ $asset_stats['archived']['percent'] }} },
            ],
            colors: ["#30a1ec", "#76bdee", "#c4dafe"],
            formatter: function (y) { return y + "%" }
        });

   
    </script>


@stop
