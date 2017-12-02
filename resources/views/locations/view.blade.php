@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ trans('general.location') }}:
 {{ $location->name }}
 
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
                    <th data-searchable="false" data-visible="false" data-sortable="true" data-field="id">{{ trans('general.id') }}</th>
                    <th data-searchable="false" data-sortable="false"  data-formatter="imageFormatter" data-field="avatar">Avatar</th>
                    <th data-searchable="true" data-sortable="true" data-formatter="usersLinkFormatter" data-field="name">{{ trans('general.user') }}</th>
                    <th data-searchable="true" data-sortable="true"  data-formatter="usersLinkFormatter" data-field="jobtitle">{{ trans('admin/users/table.title') }}</th>
                    <th data-searchable="true" data-sortable="true"  data-formatter="emailFormatter" data-field="email">{{ trans('admin/users/table.email') }}</th>
                    <th data-searchable="true" data-visible="false" data-sortable="true" data-field="phone">{{ trans('admin/users/table.phone') }}</th>
                    <th data-searchable="true" data-visible="false" data-sortable="true" data-formatter="usersLinkObjFormatter" data-field="manager">{{ trans('admin/users/table.manager') }}</th>
                    <th data-searchable="true" data-sortable="true" data-field="assets_count"><span class="hidden-md hidden-lg">Assets</span><span class="hidden-xs"><i class="fa fa-barcode fa-lg"></i></span></th>
                    <th data-searchable="true" data-sortable="true" data-field="licenses_count"><span class="hidden-md hidden-lg">Licenses</span><span class="hidden-xs"><i class="fa fa-floppy-o fa-lg"></i></span></th>
                    <th data-searchable="true" data-sortable="true" data-field="consumables_count"><span class="hidden-md hidden-lg">Consumables</span><span class="hidden-xs"><i class="fa fa-tint fa-lg"></i></span></th>
                    <th data-searchable="true" data-sortable="true" data-field="accessories_count"><span class="hidden-md hidden-lg">Accessories</span><span class="hidden-xs"><i class="fa fa-keyboard-o fa-lg"></i></span></th>
                    <th data-searchable="true" data-sortable="true"  data-formatter="departmentsLinkObjFormatter" data-field="department">{{ trans('general.department') }}</th>
                    <th data-searchable="true" data-sortable="true"  data-formatter="usersActionsFormatter" data-field="actions">{{ trans('table.actions') }}</th>
                  </tr>
                </thead>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->

      <div class="box box-default">
        <div class="box-header with-border">
          <div class="box-heading">
            <h3 class="box-title">{{ trans('general.assets') }}</h3>
          </div>
        </div>
        <div class="box-body">
              <div class="table table-responsive">
                <table
                        name="location_assets"
                        id="table-assets"
                        data-url="{{route('api.assets.index', ['location_id' => $location->id]) }}"
                        class="table table-striped snipe-table"
                        data-cookie="true"
                        data-show-footer="true"
                        data-click-to-select="true"
                        data-cookie-id-table="location_assetsDetailTable">
                  <thead>
                  <tr>
                    <th data-searchable="false" data-visible="false" data-sortable="true" data-field="id">{{ trans('general.id') }}</th>
                    <th data-searchable="false" data-visible="true" data-sortable="false" data-formatter="imageFormatter" data-field="image">{{ trans('admin/hardware/table.image') }}</th>
                    <th data-searchable="true" data-sortable="true" data-formatter="hardwareLinkFormatter" data-field="name">{{ trans('general.name') }}</th>
                    <th data-searchable="true" data-formatter="modelsLinkObjFormatter" data-sortable="true" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
                    <th data-searchable="true" data-sortable="true" data-field="asset_tag" data-formatter="hardwareLinkFormatter">{{ trans('admin/hardware/form.tag') }}</th>
                    <th data-searchable="true" data-sortable="true" data-field="serial">{{ trans('admin/hardware/form.serial') }}</th>
                    <th data-searchable="true" data-visible="false" data-sortable="true" data-field="category" data-formatter="categoriesLinkObjFormatter">{{ trans('general.category') }}</th>
                    <th data-field="purchase_cost" data-searchable="true" data-sortable="true" data-footer-formatter="sumFormatter">{{ trans('general.purchase_cost') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="hardwareInOutFormatter">Checkin/Checkout</th>
                    <th data-searchable="false" data-sortable="false" data-field="actions" data-formatter="hardwareActionsFormatter">{{ trans('table.actions') }}</th>
                  </tr>
                  </thead>
                </table>
              </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
          </div> <!--/.box-->

  </div><!--/.col-md-9-->

  <div class="col-md-3">

    @if ($location->image!='')
      <div class="col-md-12 text-center" style="padding-bottom: 20px;">
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
            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($location->city.','.$location->city.' '.$location->state.' '.$location->country.' '.$location->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
          </div>
        @endif


      </div>


  </div>
</div>




</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'locations-export', 'search' => true])

@stop
