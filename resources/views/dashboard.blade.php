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
          <a href="{{ route('hardware') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <i class="fa fa-certificate"></i>
          </div>
          <a href="{{ route('licenses') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
          <a href="{{ route('accessories') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
          <a href="{{ route('consumables') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->

</div>

<!-- morris bar & donut charts -->
  <div class="row">
    <div class="col-md-12">
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
                <table class="table table-hover table-fixed break-word">
                <thead>
                    <tr>
                        <th class="col-md-1"><span class="line"></span>{{ trans('general.date') }}</th>
                        <th class="col-md-2"><span class="line"></span>{{ trans('general.admin') }}</th>
                        <th class="col-md-3"><span class="line"></span>{{ trans('table.item') }}</th>
                        <th class="col-md-2"><span class="line"></span>{{ trans('table.actions') }}</th>
                        <th class="col-md-3"><span class="line"></span>{{ trans('general.user') }}</th>
                    </tr>
                </thead>
                <tbody>
                @if (count($recent_activity) > 0)
                  @foreach ($recent_activity as $activity)
                    <tr>
                       <td>{{ date("M d", strtotime($activity->created_at)) }}</td>
                       <td>
                                 @if ($activity->action_type!='requested')
                                      <a href="{{ route('view/user', $activity->user_id) }}">{{ $activity->adminlog->fullName() }}</a>
                                 @endif

                                 </td>

                       <td>
                            @if (($activity->assetlog) && ($activity->asset_type=="hardware"))
                              <a href="{{ route('view/hardware', $activity->asset_id) }}">{{ $activity->assetlog->showAssetName() }}</a>
                            @elseif (($activity->licenselog) && ($activity->asset_type=="software"))
                              <a href="{{ route('view/license', $activity->asset_id) }}">{{ $activity->licenselog->name }}</a>
                                  @elseif (($activity->consumablelog) && ($activity->asset_type=="consumable"))
                                <a href="{{ route('view/consumable', $activity->consumable_id) }}">{{ $activity->consumablelog->name }}</a>
                            @elseif (($activity->accessorylog) && ($activity->asset_type=="accessory"))
                              <a href="{{ route('view/accessory', $activity->accessory_id) }}">{{ $activity->accessorylog->name }}</a>
                                  @else
                                      {{ trans('general.bad_data') }}
                            @endif

                            </td>
                       <td>
                         {{ strtolower(Lang::get('general.'.str_replace(' ','_',$activity->action_type))) }}
                       </td>
                       <td>
                       @if ($activity->action_type=='requested')
                          <a href="{{ route('view/user', $activity->user_id) }}">{{ $activity->adminlog->fullName() }}</a>
                       @elseif ($activity->userlog)
                          <a href="{{ route('view/user', $activity->checkedout_to) }}">{{ $activity->userlog->fullName() }}</a>
                       @endif

                      </td>


                    </tr>
                   @endforeach
                @endif
                </tbody>
                </table>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- ./box-body -->
        </div><!-- /.box -->
    </div>
    </div>




@section('moar_scripts')

<!-- AdminLTE for demo purposes -->
<script src="/assets/js/demo.js"></script>



@stop
@stop
