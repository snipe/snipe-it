@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ trans('general.location') }}:
 {{ $location->name }}
 @if ($location->manager)
    <div class="h6"> {!! trans('admin/users/table.manager') . ': ' . $location->manager->present()->nameUrl() !!}</div>
 @endif
@parent
@stop

@section('header_right')
<a href="{{ route('locations.edit', ['location' => $location->id]) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/locations/table.update') }} </a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
    <div class="box-header with-border">
        <div class="box-heading">
            <h3 class="box-title">{{ trans('general.users') }}</h3>
        </div>
    </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table table-responsive">
              <table
              name="location_users"
              id="table-users"
              class="table table-striped snipe-table"
              data-url="{{route('api.users.index', ['location_id' => $location->id])}}"
              data-cookie="true"
              data-click-to-select="true"
              data-cookie-id-table="location_usersDetailTable">
                <thead>
                  <tr>
                    <th data-searchable="false" data-sortable="false"  data-formatter="usersLinkFormatter" data-field="name">{{ trans('general.user') }}</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">



    @if ($location->image!='')
      <div class="col-md-12 text-center">
        <img src="{{ app('locations_upload_url') }}/{{ $location->image }}" class="img-responsive img-thumbnail" alt="{{ $location->name }}">
      </div>
    @endif
      <div class="col-md-12">
        <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px;">
          @if ($location->address!='')
            <li>{{ $location->address }}</li>
           @endif
            @if ($location->address2!='')
              <li>{{ $location->address2 }}</li>
            @endif
            @if (($location->city!='') || ($location->state!='') || ($location->zip!=''))
              <li>{{ $location->city }} {{ $location->state }} {{ $location->zip }}</li>
            @endif
            @if (($location->manager))
              <li>{{ trans('admin/users/table.manager') }}: {!! $location->manager->present()->nameUrl() !!}</li>
            @endif
            @if (($location->parent))
              <li>{{ trans('admin/locations/table.parent') }}: {!! $location->parent->present()->nameUrl() !!}</li>
            @endif
        </ul>

        @if (($location->state!='') && ($location->country!='') && (config('services.google.maps_api_key')))
          <div class="col-md-12 text-center">
            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($location->city.','.$location->city.' '.$location->state.' '.$location->country.' '.$location->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail">
          </div>
        @endif


      </div>


  </div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
    <div class="box-header with-border">
    <div class="box-heading">
        <h3 class="box-title">{{ trans('general.assets') }}</h3>
    </div>
    </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table table-responsive">
              <table
              name="location_assets"
              id="table-assets"
              data-url="{{route('api.assets.index', ['location_id' => $location->id]) }}"
              class="table table-striped snipe-table"
              data-cookie="true"
              data-click-to-select="true"
              data-cookie-id-table="location_assetsDetailTable">
                <thead>
                  <tr>
                    <th data-searchable="false" data-sortable="false"  data-formatter="hardwareLinkFormatter" data-field="name">{{ trans('general.name') }}</th>
                    <th data-searchable="false" data-formatter="modelsLinkObjFormatter" data-sortable="false" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
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

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'locations-export', 'search' => true])

@stop
