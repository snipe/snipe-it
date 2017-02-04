@extends('layouts/default')

{{-- Page title --}}
@section('title')
View Assets for  {{ $user->present()->fullName() }}
@parent
@stop

{{-- Account page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">

        @if ($user->id)
          <div class="box-header with-border">
            <div class="box-heading">
              <h3 class="box-title"> {{ trans('admin/users/general.assets_user', array('name' => $user->first_name)) }}</h3>
            </div>
          </div><!-- /.box-header -->
        @endif

      <div class="box-body">
        <!-- checked out assets table -->
        @if (count($user->assets) > 0)
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="col-md-4">{{ trans('admin/hardware/table.asset_model') }}</th>
                  <th class="col-md-2">{{ trans('admin/hardware/table.asset_tag') }}</th>
                  <th class="col-md-3">{{ trans('general.name') }}</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user->assets as $asset)
                <tr>
                  <td>
                    @if ($asset->physical=='1')
                    {{ $asset->model->name }}
                    @endif
                  </td>
                  <td>{{ $asset->asset_tag }}</td>
                  <td>{{ $asset->name }}</td>
                  <td>
                    @if (($asset->image) && ($asset->image!=''))
                      <img src="{{ url('/') }}/uploads/assets/{{ $asset->image }}" height="50" width="50">

                    @elseif (($asset->model) && ($asset->model->image!=''))
                      <img src="{{ url('/') }}/uploads/models/{{ $asset->model->image }}" height="50" width="50">
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> <!-- .table-responsive-->
        @else

        <div class="col-md-12">
          <div class="alert alert-info alert-block">
            <i class="fa fa-info-circle"></i>
            {{ trans('general.no_results') }}
          </div>
        </div>
        @endif
      </div> <!-- .box-body-->
    </div><!--.box.box-default-->
  </div> <!-- .col-md-12-->
</div> <!-- .row-->

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      @if ($user->id)
        <div class="box-header with-border">
          <div class="box-heading">
            <h3 class="box-title"> {{ trans('admin/users/general.software_user', array('name' => $user->first_name)) }}</h3>
          </div>
        </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <!-- checked out licenses table -->
        @if (count($user->licenses) > 0)
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="col-md-5">{{ trans('general.name') }}</th>
                <th class="col-md-4">{{ trans('admin/hardware/form.serial') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user->licenses as $license)
              <tr>
                <td>{{ $license->name }}</td>
                <td>
                  @can('viewKeys', $license)
                  {{ mb_strimwidth($license->serial, 0, 50, "...") }}
                  @else
                  ---
                  @endcan
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> <!-- .table-responsive-->
        @else
        <div class="col-md-12">
          <div class="alert alert-info alert-block">
            <i class="fa fa-info-circle"></i>
            {{ trans('general.no_results') }}
          </div>
        </div>
        @endif
      </div> <!-- .box-body-->
    </div><!--.box.box-default-->
  </div> <!-- .col-md-12-->
</div> <!-- .row-->

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      @if ($user->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title"> {{ trans('general.consumables') }} </h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <!-- checked out consumables table -->
        @if (count($user->consumables) > 0)
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="col-md-12">{{ trans('general.name') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user->consumables as $consumable)
              <tr>
                <td>{{ $consumable->name }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="col-md-12">
            <div class="alert alert-info alert-block">
                <i class="fa fa-info-circle"></i>
                {{ trans('general.no_results') }}
            </div>
        </div>
        @endif

      </div> <!-- .box-body-->
    </div><!--.box.box-default-->
  </div> <!-- .col-md-12-->
</div> <!-- .row-->

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">

      @if ($user->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title"> {{ trans('general.accessories') }}</h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <!-- checked out licenses table -->
        @if (count($user->accessories) > 0)
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="col-md-12">Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($user->accessories as $accessory)
              <tr>
                <td>{{ $accessory->name }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="col-md-12">
          <div class="alert alert-info alert-block">
            <i class="fa fa-info-circle"></i>
            {{ trans('general.no_results') }}
          </div>
        </div>
        @endif
       </div> <!-- .box-body-->
    </div><!--.box.box-default-->
  </div> <!-- .col-md-12-->
</div> <!-- .row-->

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      @if ($user->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title"> History</h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        @if (count($userlog) > 0)
        <div class="table-responsive">
          <table class="table table-striped" id="example">
            <thead>
              <tr>
                <th class="col-md-1"></th>
                <th class="col-md-2"><span class="line"></span>{{ trans('table.action') }}</th>
                <th class="col-md-4"><span class="line"></span>{{ trans('general.asset') }}</th>
                <th class="col-md-2"><span class="line"></span>{{ trans('table.by') }}</th>
                <th class="col-md-3">{{ trans('general.date') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($userlog as $log)
              @php $result = $log->present()->forDataTable();
              @endphp
              <tr>
                <td class="text-center">
                  {!! $result['icon'] !!}
                </td>
                <td>
                  {{ $result['action_type'] }}
                </td>
                <td>
                  {!! $result['item'] !!}
                </td>
                <td>
                  {!! $result['admin'] !!}
                </td>
                <td>{{ $result['created_at'] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> <!--.table-responsive-->

        @else
        <div class="col-md-12">
            <div class="alert alert-info alert-block">
                <i class="fa fa-info-circle"></i>
                {{ trans('general.no_results') }}
            </div>
        </div>
        @endif
      </div> <!-- .box-body-->
    </div><!--.box.box-default-->
  </div> <!-- .col-md-12-->
</div> <!-- .row-->

@stop
