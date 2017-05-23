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
      @can('index', \App\Models\Asset::class)
        <a href="{{ route('hardware.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
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
        @can('view', \App\Models\License::class)
          <a href="{{ route('licenses.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
        @endcan
    </div>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-orange">
      <div class="inner">
        <h3> {{ number_format(\App\Models\Accessory::count()) }}</h3>
          <p>{{ trans('general.total_accessories') }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-keyboard-o"></i>
      </div>
      @can('index', \App\Models\Accessory::class)
          <a href="{{ route('accessories.index') }}" class="small-box-footer">{{ trans('general.moreinfo') }} <i class="fa fa-arrow-circle-right"></i></a>
      @endcan
    </div>
  </div><!-- ./col -->

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-purple">
      <div class="inner">
        <h3> {{ number_format(\App\Models\Consumable::count()) }}</h3>
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

<!-- recent activity -->
<div class="row">
  <div class="col-md-9">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('general.recent_activity') }}</h3>
        <div class="box-tools pull-right">
          <a href="{{ route('reports/activity') }}"><i class="fa fa-ellipsis-h"></i></a>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">

              <table
                class="table table-striped snipe-table"
                name="activityReport"
                id="table"
                data-cookie="false"
                data-cookie-id-table="dashTable-{{ config('version.hash_version') }}"
                data-url="{{route('api.activity.list', ['limit' => 25]) }}">
                <thead>
                  <tr>
                    <th data-field="icon" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"></th>
                    <th class="col-sm-3" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                    <th class="col-sm-2" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                    <th class="col-sm-2" data-field="action_type">{{ trans('general.action') }}</th>
                    <th class="col-sm-3" data-field="item">{{ trans('general.item') }}</th>
                    <th class="col-sm-2" data-field="target">{{ trans('general.target') }}</th>
                  </tr>
                </thead>
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
                      </div> <!-- ./chart-responsive -->
                  </div> <!-- /.col -->
              </div> <!-- /.row -->
          </div><!-- /.box-body -->
      </div> <!-- /.box -->

    <!-- Categories -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Asset {{ trans('general.categories') }}</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
              <table
                      class="table table-striped snipe-table"
                      name="categorySummary"
                      id="table"
                      data-cookie="false"
                      data-cookie-id-table="categorySummary-{{ config('version.hash_version') }}"
                      data-url="{{ route('api.categories.index', ['limit' => 15]) }}">
                  <thead>
                  <tr>
                      <th class="col-sm-2" data-field="name" data-formatter="categoriesLinkFormatter">{{ trans('general.name') }}</th>
                      <th class="col-sm-2" data-field="assets_count"><i class="fa fa-barcode"></i></th>
                  </tr>
                  </thead>
              </table>
          </div> <!-- /.col -->
        </div> <!-- /.row -->
      </div><!-- /.box-body -->
    </div> <!-- /.box -->
  </div>
</div> <!--/row-->

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['simple_view' => true])


<script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
<script>
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
            window.location.reload(true);
        }
    });


</script>


@stop
