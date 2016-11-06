@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $location->name }}
 {{ trans('general.location') }}
@parent
@stop

@section('header_right')
<a href="{{ route('update/location', $location->id) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/locations/table.update') }} </a>
@stop

{{-- Page content --}}
@section('content')

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table table-responsive">
                <table
                name="location_users"
                id="table-users"
                class="table table-striped snipe-table"
                data-url="{{route('api.locations.viewusers', $location->id)}}"
                data-cookie="true"
                data-click-to-select="true"
                data-cookie-id-table="location_usersDetailTable">
                    <thead>
                        <tr>
                            <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table table-responsive">
                <table
                name="location_assets"
                id="table-assets"
                data-url="{{route('api.locations.viewassets', $location->id)}}"
                class="table table-striped snipe-table"
                data-cookie="true"
                data-click-to-select="true"
                data-cookie-id-table="location_assetsDetailTable">
                    <thead>
                        <tr>
                            <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.name') }}</th>
                            <th data-searchable="false" data-sortable="false" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
                            <th data-searchable="false" data-sortable="false" data-field="asset_tag">{{ trans('admin/hardware/form.tag') }}</th>
                            <th data-searchable="false" data-sortable="false" data-field="serial">{{ trans('admin/hardware/form.serial') }}</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
>


@stop


@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'locations-export', 'search' => true])

@stop
