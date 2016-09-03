@extends('layouts/default')

@section('title0')
  {{ trans('admin/hardware/general.requestable') }}
  {{ trans('general.assets') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row">
    <div class="col-md-12">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#assets" data-toggle="tab" title="{{ trans('general.assets') }}">{{ trans('general.assets') }}</a>
                </li>
                <li>
                    <a href="#models" data-toggle="tab" title="{{ trans('general.asset_models') }}">{{ trans('general.asset_models') }}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="assets">

                    @if ($assets->count() > 0)

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr role="row">
                                    <th class="col-md-3" bSortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                    <th class="col-md-3" bSortable="true">{{ trans('admin/hardware/table.serial') }}</th>
                                    <th class="col-md-2" bSortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                    <th class="col-md-2" bSortable="true">{{ trans('admin/hardware/table.status') }}</th>
                                    <th class="col-md-2" bSortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                                    <th class="col-md-1 actions" bSortable="false">{{ trans('table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assets as $asset)
                                <tr>
                                    <td>{{ $asset->model->name }}</td>

                                    @if (\App\Models\Setting::getSettings()->display_asset_name)
                                        <td>{{ $asset->name }}</td>
                                    @endif

                                    <td>{{ $asset->serial }}</td>

                                    <td>
                                        @if ($asset->assigneduser && $asset->assetloc)
                                                {{ $asset->assetloc->name }}
                                        @elseif ($asset->defaultLoc)
                                                {{ $asset->defaultLoc->name }}

                                        @endif

                                    </td>
                                     @if ($asset->assigned_to != '' && $asset->assigned_to > 0)
                                        <td>Checked out</td>
                                    @else
                                    <td>{{ trans('admin/hardware/general.requestable') }}</td>
                                    @endif

                                    <td>{{ $asset->expected_checkin }}</td>


                                    <td>
                                        @if ($asset->isRequestedBy(Auth::user()))
                                            <a href="{{ route('account/request-asset', $asset->id)}}" class="btn btn-danger btn-sm" title="{{ trans('button.cancel') }}">
                                                {{ trans('button.cancel') }}
                                            </a>
                                        @else
                                            <a
                                                href="{{ route('account/request-asset', $asset->id) }}"
                                                class="btn btn-info btn-sm"
                                                title="{{ trans('button.request') }}"
                                            >
                                            {{ trans('button.request') }}
                                            </a>
                                        @endif
                                    </td>

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
                </div>

                <div class="tab-pane fade" id="models">

                    @if ($models->count() > 0)
                    <h4>Requestable Models</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr role="row">
                                <th class="col-md-6" bSortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                <th class="col-md-5" bSortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                <th class="col-md-1 actions" bSortable="false">{{ trans('table.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($models as $requestableModel)
                                <tr>
                                    <td>{{$requestableModel->name}}</td>
                                    <td>{{$requestableModel->assets()->where('requestable', '1')->count()}}</td>
                                    <td>
                                        <a href="{{ route('account/request-asset', $requestableModel->id) }}" class="btn btn-info btn-sm" title="{{ trans('button.request') }}">{{ trans('button.request') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                    <div class="col-md-12">
                        <div class="alert alert-info alert-block">
                            <i class="fa fa-info-circle"></i>
                            {{ trans('general.no_results') }}
                        </div>
                    </div>
                    @endif
                </div>

            </div> <!-- .tab-content-->
        </div> <!-- .nav-tabs-custom -->
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->



@stop
