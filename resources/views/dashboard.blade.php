@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.dashboard') }}
@parent
@stop


{{-- Page content --}}
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/morris.css') }}">
<div class="row">

      <!-- panel -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-teal">
          <div class="inner">
            <h3>{{ number_format(\App\Models\Asset::assetcount()) }}</h3>
            <p>{{ trans('general.total_assets') }}</p>
          </div>
          <div class="icon">
            <i class="fa fa-barcode"></i>
          </div>
            @can('assets.view')
                <a href="{{ route('hardware') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
             @endcan
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
          <div class="inner">
            <h3>{{ number_format(\App\Models\License::assetcount()) }}</h3>
            <p>{{ trans('general.total_licenses') }}</p>
          </div>
          <div class="icon">
            <i class="fa fa-floppy-o"></i>
          </div>
            @can('licenses.view')
                <a href="{{ route('licenses') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            @endcan
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
          <div class="inner">
            <h3> {{ number_format(\App\Models\Accessory::count()) }}</h3>
            <p>total accessories</p>
          </div>
          <div class="icon">
            <i class="fa fa-keyboard-o"></i>
          </div>
            @can('accessories.view')
                <a href="{{ route('accessories') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            @endcan
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3> {{ number_format(\App\Models\Consumable::count()) }}</h3>
            <p>total consumables</p>
          </div>
          <div class="icon">
            <i class="fa fa-tint"></i>
          </div>
            @can('consumables.view')
                <a href="{{ route('consumables') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            @endcan
        </div>
      </div><!-- ./col -->

</div>


<!-- recent activity -->
  <div class="row">
    <div class="col-md-9">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('general.recent_activity') }}</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
               <div class="table-responsive">
                <table class="table table-hover table-fixed break-word">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-md-2"><span class="line"></span>{{ trans('general.date') }}</th>
                        <th class="col-md-2"><span class="line"></span>{{ trans('general.admin') }}</th>
                        <th class="col-md-2"><span class="line"></span>{{ trans('table.actions') }}</th>
                        <th class="col-md-3"><span class="line"></span>{{ trans('table.item') }}</th>
                        <th class="col-md-3"><span class="line"></span>To</th>
                    </tr>
                </thead>
                <tbody>
                @if (count($recent_activity) > 0)
                  @foreach ($recent_activity as $activity)
                    <tr>
                        <td>
                            @if ($activity->itemType()=="asset")
                                <i class="fa fa-barcode"></i>
                            @elseif ($activity->itemType()=="accessory")
                                <i class="fa fa-keyboard-o"></i>
                            @elseif ($activity->itemType()=="consumable")
                                <i class="fa fa-tint"></i>
                            @elseif ($activity->itemType()=="license")
                                <i class="fa fa-floppy-o"></i>
                            @elseif ($activity->itemType()=="component")
                                <i class="fa fa-hdd-o"></i>
                            @else
                                <i class="fa fa-paperclip"></i>
                            @endif
                        </td>
                       <td>{{ date("M d, Y g:iA", strtotime($activity->created_at)) }}</td>
                       <td>
                                 @if (($activity->action_type!='requested') && ($activity->action_type!="request_canceled"))
                                     @if ($activity->user)
                                        <a href="{{ route('view/user', $activity->user_id) }}">{{ $activity->user->fullName() }}</a>
                                     @else
                                        Deleted Admin
                                     @endif
                                 @endif

                                 </td>
                        <td>
                            {{ strtolower(trans('general.'.str_replace(' ','_',$activity->action_type))) }}
                        </td>
                       <td>
                           @if (($activity->item) && ($activity->itemType()=="asset"))
                              <a href="{{ route('view/hardware', $activity->item_id) }}">{{ $activity->item->asset_tag }} - {{ $activity->item->showAssetName() }}</a>
                            @elseif ($activity->item)
                              <a href="{{ route('view/'. $activity->itemType(), $activity->item_id) }}">{{ $activity->item->name }}</a>
                            @endif

                            </td>

                       <td>
                        @if (($activity->userasassetlog) && ($activity->action_type=="uploaded") && ($activity->itemType()=="user"))
                            <a href="{{ route('view/user', $activity->target_id) }}">{{ $activity->userasassetlog->fullName() }}</a>
                        @elseif (($activity->item) && ($activity->target instanceof \App\Models\Asset))
                           <a href="{{ route('view/hardware', $activity->target_id) }}">{{ $activity->target->showAssetName() }}</a>
                        @elseif (($activity->item) && ($activity->target instanceof \App\Models\User))
                            <a href="{{route('view/user', $activity->target_id) }}"> {{ $activity->target->fullName() }}</a>
                        @elseif ($activity->action_type=='requested') <!--The user is who requested the item, not the target-->
                            <a href="{{ route('view/user', $activity->user_id) }}">{{ $activity->user->fullName() }}</a>
                       @endif

                      </td>


                    </tr>
                   @endforeach
                @endif
                </tbody>
                </table>
               </div><!-- /.responsive -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- ./box-body -->
        </div><!-- /.box -->
    </div>
      <div class="col-md-3">
          <div class="box box-default">
              <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('general.assets') }}</h3>

                  <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                  </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="chart-responsive">
                              <canvas id="statusPieChart" height="150"></canvas>
                          </div>
                          <!-- ./chart-responsive -->
                      </div>

                      <!-- /.col -->
                  </div>
                  <!-- /.row -->
              </div>
          </div>
          <!-- /.box -->
      </div>
    </div>


@section('moar_scripts')
<script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
<script>


    var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var ctx = document.getElementById("statusPieChart");


    $.get('{{  route('api.statuslabels.assets') }}', function (data) {
        var myPieChart = new Chart(ctx,{

            type: 'doughnut',
            data: data,
            options: pieOptions
        });
       // document.getElementById('my-doughnut-legend').innerHTML = myPieChart.generateLegend();
    });





</script>



@stop


@stop
