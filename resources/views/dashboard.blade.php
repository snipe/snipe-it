@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.dashboard') }}
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- 2019-06-18 v1
@if ($snipeSettings->dashboard_message!='')
<div class="row">
    <div class="col-md-12">
        <div class="box">

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        {!!  Parsedown::instance()->text(e($snipeSettings->dashboard_message))  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
-->


<div class="row">

  <!-- panel -->
  <div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-teal">
      <div class="inner">
        <h3>{{ number_format($counts['asset']) }}</h3>
        <p>{{ trans('general.total_assets') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-barcode"></i>
      </div>
      @can('index', \App\Models\Asset::class)
        <a href="{{ route('hardware.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
      @endcan
    </div>
  </div>

  <!-- ./col -->


    <!-- small box small-box bg-maroon -->



  <!-- ./col -->



    <!-- small box -->



   <!-- ./col -->


  <div class="col-lg-6 col-xs-6">
    <!-- small box small-box bg-purple -->
    <div class="small-box bg-purple">
      <div class="inner">
        <h3> {{ number_format($counts['consumable']) }}</h3>
          <p>{{ trans('general.total_consumables') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-tint"></i>
      </div>
      @can('index', \App\Models\Consumable::class)
        <a href="{{ route('consumables.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->



</div>

@if ($counts['grand_total'] == 0)

    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Complete (warning)</span>
                                </div>
                            </div>


                            <p><strong>It looks like you haven't added anything yet, so we don't have anything awesome to display. Get started by adding some assets, accessories, consumables, or licenses now!</strong></p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            @can('create', \App\Models\Asset::class)
                            <a class="btn bg-teal" style="width: 100%" href="{{ route('hardware.create') }}">New Asset</a>
                            @endcan
                        </div>
                        <div class="col-md-3">
                            @can('create', \App\Models\License::class)
                                <a class="btn bg-maroon" style="width: 100%" href="{{ route('licenses.create') }}">New License</a>
                            @endcan
                        </div>
                        <div class="col-md-3">
                            @can('create', \App\Models\Accessory::class)
                                <a class="btn bg-orange" style="width: 100%" href="{{ route('accessories.create') }}">New Accessory</a>
                            @endcan
                        </div>
                        <div class="col-md-3">
                            @can('create', \App\Models\Consumable::class)
                                <a class="btn bg-purple" style="width: 100%" href="{{ route('consumables.create') }}">New Consumable</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@else

<!-- recent activity -->
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('general.recent_activity') }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">

                <table
                    data-cookie-id-table="dashActivityReport"
                    data-height="400"
                    data-side-pagination="server"
                    data-sort-order="desc"
                    data-sort-name="created_at"
                    id="dashActivityReport"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.activity.index', ['limit' => 25]) }}">
                    <thead>
                    <tr>
                        <th data-field="icon" data-visible="true" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"></th>
                        <th class="col-sm-3" data-visible="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                        <th class="col-sm-3" data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                        <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                    </tr>
                    </thead>
                </table>



            </div><!-- /.responsive -->
          </div><!-- /.col -->
          <div class="col-md-12 text-center" style="padding-top: 10px;">
            <a href="{{ route('reports.activity') }}" class="btn btn-primary btn-sm" style="width: 100%">View All</a>
          </div>
        </div><!-- /.row -->
      </div><!-- ./box-body -->
    </div><!-- /.box -->
  </div>

</div> <!--/row-->
<div class="row">





            <!-- /.box-header -->
             <!-- ./chart-responsive -->
                     <!-- /.col -->
                  <!-- /.row -->
             <!-- /.box-body -->
         <!-- /.box -->



        <!-- Categories -->

            <!-- /.box-header -->


                      <!-- /.col -->

                  <!-- /.row -->
 <!-- /.box-body -->
          <!-- /.box -->



@endif


@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['simple_view' => true, 'nopages' => true])

@if ($snipeSettings->load_remote=='1')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
@else
    <script src="{{ asset('js/plugins/chartjs/Chart.min.js') }}"></script>
@endif


<script nonce="{{ csrf_token() }}">




        /* ChartJS
         * -------
         */

        // -----------------------
        // - LINE CHART -
        // -----------------------



        //var ctx = document.getElementById('salesChart').getContext("2d")
        //var myChart = new Chart(ctx, {
         //   type: 'line'
        //});


        //$.ajax({
        //    type: 'GET',
        //    url: '{{  route('api.statuslabels.assets.bytype') }}',
        //    headers: {
        //        "X-Requested-With": 'XMLHttpRequest',
        //        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        //    },

        //    dataType: 'json',
        //   success: function (data) {
        //       var ctx = new Chart(ctx,{
        //          type: 'line',
        //            data: data,
        //            options: lineOptions
        //        });
        //    },
        //    error: function (data) {
       //         window.location.reload(true);
       //     }
       // });





  // ---------------------------
  // - END MONTHLY SALES CHART -
  // ---------------------------


    var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var ctx = document.getElementById("statusPieChart");



    $.ajax({
        type: 'GET',
        url: '{{  route('api.statuslabels.assets.bytype') }}',
        headers: {
            "X-Requested-With": 'XMLHttpRequest',
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },

        dataType: 'json',
        success: function (data) {
            var myPieChart = new Chart(ctx,{

                type: 'doughnut',
                data: data,
                options: pieOptions
            });
        },
        error: function (data) {
           // window.location.reload(true);
        }
    });


</script>


@stop
