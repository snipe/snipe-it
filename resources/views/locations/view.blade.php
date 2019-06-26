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
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs hidden-print">

        <li class="active">
          <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fa fa-info-circle"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/locations/general.info') }}</span>
          </a>
        </li>

        <li>
          <a href="#asset_tab" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fa fa-barcode"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}</span>
          </a>
        </li>

        <li>
          <a href="#components_tab" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fa fa-hdd-o"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.components') }}</span>
          </a>
        </li>

        <li>
          <a href="#users_tab" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fa fa-users"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.users') }}</span>
          </a>
        </li>

        <li>
          <a href="#locations_tab" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fa fa-clock-o"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.locations') }}</span>
          </a>
        </li>
        
        <li class="dropdown pull-right">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-gear"></i> {{ trans('button.actions') }}
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            @can('update', $location)
              <li><a href="{{ route('locations.edit', $location->id) }}">{{ trans('admin/locations/general.edit') }}</a></li>
            @endcan
            @if (Input::get('include_child_locations')=='true')
              <li><a href="{{ route('locations.show', ['location' => $location->id]) }}">{{ trans('admin/locations/general.exclude_child_locations') }}</a></li>
            @else
              <li><a href="{{ route('locations.show', ['location' => $location->id, 'include_child_locations' => 'true']) }}">{{ trans('admin/locations/general.include_child_locations') }}</a></li>
            @endif
          </ul>
        </li>
      </ul>

      <div class="tab-content">
      	
      	<div class="tab-pane active" id="details">
          <div class="row">
				    @if ($location->image!='')
				      <div class="col-md-2 text-center">
				        <img src="{{ app('locations_upload_url') }}/{{ $location->image }}" class="img-responsive img-thumbnail" alt="{{ $location->name }}">
				      </div>
				    @endif
            
            
            <div class="col-md-6">
              <div class="table table-responsive">
                <table class="table table-striped">
			            
			            @if ($location->address!='' || $location->address!='')
				            <tr>
	                    <td class="text-nowrap">{{ trans('admin/locations/table.address') }}</td>
	                    <td>{{ $location->address }}<br />{{ $location->address2 }}</td>
	                  </tr>
			            @endif
			            
			            @if (($location->city!='') || ($location->state!='') || ($location->zip!=''))
				            <tr>
	                    <td class="text-nowrap">{{ trans('admin/locations/table.city') }}/{{ trans('admin/locations/table.state') }}/{{ trans('admin/locations/table.zip') }}</td>
	                    <td>{{ $location->city }} {{ $location->state }} {{ $location->zip }}</td>
	                  </tr>
			            @endif
			            
			            @if (($location->manager))
				            <tr>
	                    <td class="text-nowrap">{{ trans('admin/users/table.manager') }}</td>
	                    <td>{!! $location->manager->present()->nameUrl() !!}</td>
	                  </tr>
			            @endif
			            
			            @if (($location->parent))
				            <tr>
	                    <td class="text-nowrap">{{ trans('admin/locations/table.parent') }}</td>
				              <td>{!! $location->parent->present()->nameUrl() !!}</td>
	                  </tr>
			            @endif
			            
                </table> <!--/table table-striped-->
              </div> <!--/able table-responsive-->
            </div> <!--/col-md-8-->
            
            <div class="col-md-4">
            	
			        @if (($location->state!='') && ($location->country!='') && (config('services.google.maps_api_key')))
			          <div class="col-md-12 text-center">
			            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($location->city.','.$location->city.' '.$location->state.' '.$location->country.' '.$location->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
			          </div>
			        @endif
			        
            </div> <!--/col-md-4-->
            
          </div> <!--/.row-->
      	</div><!-- /.tab-pane -->

        <div class="tab-pane" id="asset_tab">
        	
              <div class="table table-responsive">

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
                          id="assetsListingTable"
                          class="table table-striped snipe-table"
                          data-url="{{route('api.assets.index', ['location_id' => $location->id, 'include_child_locations' => e(Input::get('include_child_locations'))]) }}"
                          data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
                  </table>

              </div><!-- /.table-responsive -->
        </div><!-- /asset_tab -->

      <div class="box box-default">
          <div class="box-header with-border">
              <div class="box-heading">
                  <h2 class="box-title">{{ trans('general.components') }}</h2>
              </div>
          </div>
          <div class="box-body">
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
                          data-url="{{route('api.components.index', ['location_id' => $location->id, 'include_child_locations' => e(Input::get('include_child_locations'))])}}"
                          data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-components-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                  </table>
              </div><!-- /.table-responsive -->
        </div><!-- /components_tab -->

        <div class="tab-pane" id="users_tab">
            <div class="table table-responsive">

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
                        id="usersTable"
                        class="table table-striped snipe-table"
                        data-url="{{route('api.users.index', ['location_id' => $location->id, 'include_child_locations' => e(Input::get('include_child_locations'))])}}"
                        data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-users-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /users_tab -->

        <div class="tab-pane" id="locations_tab">
              <div class="table table-responsive">

                  <table
                          data-columns="{{ \App\Presenters\LocationPresenter::dataTableLayout() }}"
                          data-cookie-id-table="locationsTable"
                          data-pagination="true"
                          data-id-table="locationsTable"
                          data-search="true"
                          data-side-pagination="server"
                          data-show-columns="true"
                          data-show-export="true"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          id="locationsTable"
                          class="table table-striped snipe-table"
                          data-url="{{route('api.locations.index', ['parent_id' => $location->id, 'include_child_locations' => e(Input::get('include_child_locations'))])}}"
                          data-export-options='{
                              "fileName": "export-locations-{{ str_slug($location->name) }}-locations-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                  </table>
              </div><!-- /.table-responsive -->
        </div><!-- /locations_tab -->
      	
      </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', [
    'exportFile' => 'locations-export',
    'search' => true
 ])

@stop
