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

        <div class="box box-default">
            <div class="box-body">

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
                                <a href="{{ route('account/request-asset', $asset->id) }}" class="btn btn-info btn-sm" title="{{ trans('button.request') }}">{{ trans('button.request') }}</a>
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
        </div>
    </div>
</div>



@stop
