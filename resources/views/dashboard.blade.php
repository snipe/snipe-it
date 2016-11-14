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
                <a href="{{ route('hardware') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
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
                <a href="{{ route('licenses') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
            @endcan
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-orange">
          <div class="inner">
            <h3> {{ number_format(\App\Models\Accessory::count()) }}</h3>
<<<<<<< HEAD
            <p>total accessories</p>
=======
              <p>{{ trans('general.total_accessories') }}</p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
          </div>
          <div class="icon">
            <i class="fa fa-keyboard-o"></i>
          </div>
            @can('accessories.view')
                <a href="{{ route('accessories') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
            @endcan
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-purple">
          <div class="inner">
            <h3> {{ number_format(\App\Models\Consumable::count()) }}</h3>
<<<<<<< HEAD
            <p>total consumables</p>
=======
              <p>{{ trans('general.total_consumables') }}</p>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
          </div>
          <div class="icon">
            <i class="fa fa-tint"></i>
          </div>
            @can('consumables.view')
                <a href="{{ route('consumables') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
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
<<<<<<< HEAD
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
=======
                <a href="{{ route('reports/activity') }}"><i class="fa fa-ellipsis-h"></i></a>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
               <div class="table-responsive">
<<<<<<< HEAD
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
                            @if ($activity->asset_type=="hardware")
                                <i class="fa fa-barcode"></i>
                            @elseif ($activity->asset_type=="accessory")
                                <i class="fa fa-keyboard-o"></i>
                            @elseif ($activity->asset_type=="consumable")
                                <i class="fa fa-tint"></i>
                            @elseif ($activity->asset_type=="license")
                                <i class="fa fa-floppy-o"></i>
                            @elseif ($activity->asset_type=="component")
                                <i class="fa fa-hdd-o"></i>
                            @else
                                <i class="fa fa-paperclip"></i>
                            @endif
                        </td>
                       <td>{{ date("M d, Y g:iA", strtotime($activity->created_at)) }}</td>
                       <td>
                                 @if ($activity->action_type!='requested')
                                     @if ($activity->adminlog)
                                        <a href="{{ route('view/user', $activity->user_id) }}">{{ $activity->adminlog->fullName() }}</a>
                                     @else
                                        Deleted Admin
                                     @endif
                                 @endif

                                 </td>
                        <td>
                            {{ strtolower(trans('general.'.str_replace(' ','_',$activity->action_type))) }}
                        </td>
                       <td>
                           @if (($activity->assetlog) && ($activity->asset_type=="hardware"))
                              <a href="{{ route('view/hardware', $activity->asset_id) }}">{{ $activity->assetlog->asset_tag }} - {{ $activity->assetlog->showAssetName() }}</a>
                            @elseif (($activity->licenselog) && ($activity->asset_type=="software"))
                              <a href="{{ route('view/license', $activity->asset_id) }}">{{ $activity->licenselog->name }}</a>
                                  @elseif (($activity->consumablelog) && ($activity->asset_type=="consumable"))
                                <a href="{{ route('view/consumable', $activity->consumable_id) }}">{{ $activity->consumablelog->name }}</a>
                            @elseif (($activity->accessorylog) && ($activity->asset_type=="accessory"))
                              <a href="{{ route('view/accessory', $activity->accessory_id) }}">{{ $activity->accessorylog->name }}</a>
                            @elseif (($activity->componentlog) && ($activity->asset_type=="component"))
                               <a href="{{ route('view/component', $activity->component_id) }}">{{ $activity->componentlog->name }}</a>
                            @elseif (($activity->assetlog) && ($activity->action_type=="uploaded") && ($activity->asset_type=="hardware"))
                                   <a href="{{ route('view/hardware', $activity->asset_id) }}">{{ $activity->assetlog->showAssetName() }}</a>

                            @endif

                            </td>

                       <td>
                        @if (($activity->userasassetlog) && ($activity->action_type=="uploaded") && ($activity->asset_type=="user"))
                            <a href="{{ route('view/user', $activity->asset_id) }}">{{ $activity->userasassetlog->fullName() }}</a>
                        @elseif (($activity->componentlog) && ($activity->asset_type=="component"))
                           <a href="{{ route('view/hardware', $activity->asset_id) }}">{{ $activity->assetlog->showAssetName() }}</a>
                        @elseif($activity->action_type=='requested')
                            @if ($activity->adminlog)
                                <a href="{{ route('view/user', $activity->user_id) }}">{{ $activity->adminlog->fullName() }}</a>
                            @endif
                       @elseif ($activity->userlog)
                          <a href="{{ route('view/user', $activity->checkedout_to) }}">{{ $activity->userlog->fullName() }}</a>

                       @endif

                      </td>


                    </tr>
                   @endforeach
                @endif
                </tbody>
=======
                <table
                    class="table table-striped"
                    name="activityReport"
                    id="table"
                    data-url="{{route('api.activity.list', ['limit' => 20]) }}">
                <thead>
                    <tr>
                        <th data-field="icon" style="width: 40px;" class="hidden-xs"></th>
                        <th class="col-sm-2" data-field="created_at">{{ trans('general.date') }}</th>
                        <th class="col-sm-2" data-field="admin">{{ trans('general.admin') }}</th>
                        <th class="col-sm-2" data-field="action_type">{{ trans('general.action') }}</th>
                        <th class="col-sm-4" data-field="item">{{ trans('general.item') }}</th>
                        <th class="col-sm-2" data-field="target">To</th>
                    </tr>
                </thead>

>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
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

<<<<<<< HEAD


=======
    <script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
    <script type="text/javascript">
        $('#table').bootstrapTable({
            classes: 'table table-responsive table-no-bordered',
            undefinedText: '',
            iconsPrefix: 'fa',
            showRefresh: false,
            search: false,
            pagination: false,
            sidePagination: 'server',
            sortable: false,
            showMultiSort: false,
            cookie: false,
            mobileResponsive: true,
        });

    </script>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
@stop


@stop
