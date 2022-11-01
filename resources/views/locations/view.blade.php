@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ trans('general.location') }}:
 {{ $location->name }}
 
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">

      <div class="nav-tabs-custom">
          <ul class="nav nav-tabs hidden-print">

              <li class="active">
                  <a href="#users" data-toggle="tab">
                        <span class="hidden-lg hidden-md">
                            <i class="fas fa-users fa-2x"></i>
                        </span>
                      <span class="hidden-xs hidden-sm">
                          {{ trans('general.users') }}
                          {!! (($location->users) && ($location->users->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->users->count()).'</badge>' : '' !!}

                      </span>
                  </a>
              </li>

              <li>
                  <a href="#assets" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
                    </span>
                    <span class="hidden-xs hidden-sm">
                          {{ trans('admin/locations/message.current_location') }}
                          {!! (($location->assets) && ($location->assets()->AssetsForShow()->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->assets()->AssetsForShow()->count()).'</badge>' : '' !!}
                    </span>
                  </a>
              </li>


              <li>
                  <a href="#rtd_assets" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
                    </span>
                      <span class="hidden-xs hidden-sm">
                          {{ trans('admin/hardware/form.default_location') }}
                          {!! (($location->rtd_assets) && ($location->rtd_assets()->AssetsForShow()->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->rtd_assets()->AssetsForShow()->count()).'</badge>' : '' !!}
                    </span>
                  </a>
              </li>

              <li>
                  <a href="#assets_assigned" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
                    </span>
                      <span class="hidden-xs hidden-sm">
                          {{ trans('admin/locations/message.assigned_assets') }}
                          {!! (($location->rtd_assets) && ($location->assignedAssets()->AssetsForShow()->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->assignedAssets()->AssetsForShow()->count()).'</badge>' : '' !!}
                    </span>
                  </a>
              </li>


              <li>
                  <a href="#accessories" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-keyboard fa-2x" aria-hidden="true"></i>
                    </span>
                      <span class="hidden-xs hidden-sm">
                          {{ trans('general.accessories') }}
                          {!! (($location->accessories) && ($location->accessories->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->accessories->count()).'</badge>' : '' !!}
                    </span>
                  </a>
              </li>

              <li>
                  <a href="#consumables" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-tint fa-2x" aria-hidden="true"></i>
                    </span>
                      <span class="hidden-xs hidden-sm">
                          {{ trans('general.consumables') }}
                          {!! (($location->consumables) && ($location->consumables->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->consumables->count()).'</badge>' : '' !!}
                    </span>
                  </a>
              </li>

              <li>
                  <a href="#components" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-hdd fa-2x" aria-hidden="true"></i>
                    </span>
                      <span class="hidden-xs hidden-sm">
                          {{ trans('general.components') }}
                          {!! (($location->components) && ($location->components->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($location->components->count()).'</badge>' : '' !!}
                    </span>
                  </a>
              </li>
          </ul>


          <div class="tab-content">
              <div class="tab-pane active" id="users">
                    <h2 class="box-title">{{ trans('general.users') }}</h2>
                      <div class="table table-responsive">
                          @include('partials.users-bulk-actions')
                          <table
                                  data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                                  data-cookie-id-table="usersTable"
                                  data-pagination="true"
                                  data-id-table="usersTable"
                                  data-search="true"
                                  data-side-pagination="server"
                                  data-show-columns="true"
                                  data-show-export="true"
                                  data-show-refresh="true"
                                  data-sort-order="asc"
                                  data-toolbar="#userBulkEditToolbar"
                                  data-bulk-button-id="#bulkUserEditButton"
                                  data-bulk-form-id="#usersBulkForm"
                                  data-click-to-select="true"
                                  id="usersTable"
                                  class="table table-striped snipe-table"
                                  data-url="{{route('api.users.index', ['location_id' => $location->id])}}"
                                  data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-users-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                          </table>
                      </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="assets">
                      <h2 class="box-title">{{ trans('admin/locations/message.current_location') }}</h2>

                      <div class="table table-responsive">
                          @include('partials.asset-bulk-actions')
                          <table
                                  data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                                  data-cookie-id-table="assetsListingTable"
                                  data-pagination="true"
                                  data-id-table="assetsListingTable"
                                  data-search="true"
                                  data-side-pagination="server"
                                  data-show-columns="true"
                                  data-show-export="true"
                                  data-show-refresh="true"
                                  data-sort-order="asc"
                                  data-toolbar="#assetsBulkEditToolbar"
                                  data-bulk-button-id="#bulkAssetEditButton"
                                  data-bulk-form-id="#assetsBulkForm"
                                  data-click-to-select="true"
                                  id="assetsListingTable"
                                  class="table table-striped snipe-table"
                                  data-url="{{route('api.assets.index', ['location_id' => $location->id]) }}"
                                  data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                          </table>

                      </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="assets_assigned">
                  <h2 class="box-title">
                      {{ trans('admin/locations/message.assigned_assets') }}
                  </h2>

                  <div class="table table-responsive">
                      @include('partials.asset-bulk-actions', ['id_divname' => 'AssignedAssetsBulkEditToolbar', 'id_formname' => 'assignedAssetsBulkForm', 'id_button' => 'AssignedbulkAssetEditButton'])
                      <table
                              data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                              data-cookie-id-table="assetsAssignedListingTable"
                              data-pagination="true"
                              data-id-table="assetsAssignedListingTable"
                              data-search="true"
                              data-side-pagination="server"
                              data-show-columns="true"
                              data-show-export="true"
                              data-show-refresh="true"
                              data-sort-order="asc"
                              data-toolbar="#AssignedAssetsBulkEditToolbar"
                              data-bulk-button-id="#AssignedbulkAssetEditButton"
                              data-bulk-form-id="#assignedAssetsBulkForm"
                              data-click-to-select="true"
                              id="assetsListingTable"
                              class="table table-striped snipe-table"
                              data-url="{{route('api.assets.index', ['assigned_to' => $location->id, 'assigned_type' => \App\Models\Location::class]) }}"
                              data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>

                  </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="rtd_assets">
                  <h2 class="box-title">{{ trans('admin/hardware/form.default_location') }}</h2>

                  <div class="table table-responsive">
                      @include('partials.asset-bulk-actions', ['id_divname' => 'RTDassetsBulkEditToolbar', 'id_formname' => 'RTDassets', 'id_button' => 'RTDbulkAssetEditButton'])
                      <table
                              data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                              data-cookie-id-table="RTDassetsListingTable"
                              data-pagination="true"
                              data-id-table="RTDassetsListingTable"
                              data-search="true"
                              data-side-pagination="server"
                              data-show-columns="true"
                              data-show-export="true"
                              data-show-refresh="true"
                              data-sort-order="asc"
                              data-toolbar="#RTDassetsBulkEditToolbar"
                              data-bulk-button-id="#RTDbulkAssetEditButton"
                              data-bulk-form-id="#RTDassetsBulkEditToolbar"
                              data-click-to-select="true"
                              id="RTDassetsListingTable"
                              class="table table-striped snipe-table"
                              data-url="{{route('api.assets.index', ['rtd_location_id' => $location->id]) }}"
                              data-export-options='{
                              "fileName": "export-rtd-locations-{{ str_slug($location->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>

                  </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->
              


              <div class="tab-pane" id="accessories">
                  <h2 class="box-title">{{ trans('general.accessories') }}</h2>
                  <div class="table table-responsive">
                      <table
                              data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}"
                              data-cookie-id-table="accessoriesListingTable"
                              data-pagination="true"
                              data-id-table="accessoriesListingTable"
                              data-search="true"
                              data-side-pagination="server"
                              data-show-columns="true"
                              data-show-export="true"
                              data-show-refresh="true"
                              data-sort-order="asc"
                              id="accessoriesListingTable"
                              class="table table-striped snipe-table"
                              data-url="{{route('api.accessories.index', ['location_id' => $location->id]) }}"
                              data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-accessories-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                      </table>
                  </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->


              <div class="tab-pane" id="consumables">
                  <h2 class="box-title">{{ trans('general.consumables') }}</h2>

                      <div class="table table-responsive">
                          <table
                                  data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                                  data-cookie-id-table="consumablesListingTable"
                                  data-pagination="true"
                                  data-id-table="consumablesListingTable"
                                  data-search="true"
                                  data-side-pagination="server"
                                  data-show-columns="true"
                                  data-show-export="true"
                                  data-show-refresh="true"
                                  data-sort-order="asc"
                                  id="consumablesListingTable"
                                  class="table table-striped snipe-table"
                                  data-url="{{route('api.consumables.index', ['location_id' => $location->id]) }}"
                                  data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-consumables-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                          </table>

                      </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="components">
                  <h2 class="box-title">{{ trans('general.components') }}</h2>
                      <div class="table table-responsive">

                          <table
                                  data-columns="{{ \App\Presenters\ComponentPresenter::dataTableLayout() }}"
                                  data-cookie-id-table="componentsTable"
                                  data-pagination="true"
                                  data-id-table="componentsTable"
                                  data-search="true"
                                  data-side-pagination="server"
                                  data-show-columns="true"
                                  data-show-export="true"
                                  data-show-refresh="true"
                                  data-sort-order="asc"
                                  id="componentsTable"
                                  class="table table-striped snipe-table"
                                  data-url="{{route('api.components.index', ['location_id' => $location->id])}}"
                                  data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-components-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                          </table>
                      </div><!-- /.table-responsive -->
              </div><!-- /.tab-pane -->

          </div><!--/.col-md-9-->
      </div><!--/.col-md-9-->
  </div><!--/.col-md-9-->

  <div class="col-md-3">

      <div class="col-md-12">
          <a href="{{ route('locations.edit', ['location' => $location->id]) }}" style="width: 100%;" class="btn btn-sm btn-primary pull-left">{{ trans('admin/locations/table.update') }} </a>
      </div>
      <div class="col-md-12" style="padding-top: 5px;">
          <a href="{{ route('locations.print_assigned', ['locationId' => $location->id]) }}" style="width: 100%;" class="btn btn-sm btn-default pull-left">{{ trans('admin/locations/table.print_assigned') }} </a>
      </div>
      <div class="col-md-12" style="padding-top: 5px; padding-bottom: 20px;">
          <a href="{{ route('locations.print_all_assigned', ['locationId' => $location->id]) }}" style="width: 100%;" class="btn btn-sm btn-default pull-left">{{ trans('admin/locations/table.print_all_assigned') }} </a>
      </div>


    @if ($location->image!='')
      <div class="col-md-12 text-center" style="padding-bottom: 20px;">
        <img src="{{ Storage::disk('public')->url('locations/'.e($location->image)) }}" class="img-responsive img-thumbnail" style="width:100%" alt="{{ $location->name }}">
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
            @if ($location->manager)
              <li>{{ trans('admin/users/table.manager') }}: {!! $location->manager->present()->nameUrl() !!}</li>
            @endif
            @if ($location->parent)
              <li>{{ trans('admin/locations/table.parent') }}: {!! $location->parent->present()->nameUrl() !!}</li>
            @endif
              @if ($location->ldap_ou)
                  <li>{{ trans('admin/locations/table.ldap_ou') }}: {{ $location->ldap_ou }}</li>
              @endif
        </ul>

        @if (($location->state!='') && ($location->country!='') && (config('services.google.maps_api_key')))
          <div class="col-md-12 text-center">
            <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($location->address.','.$location->city.' '.$location->state.' '.$location->country.' '.$location->zip) }}&size=700x500&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-thumbnail" style="width:100%" alt="Map">
          </div>
        @endif

      </div>


		
  </div>

  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', [
    'exportFile' => 'locations-export',
    'search' => true
 ])

@stop
