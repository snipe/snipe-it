@extends('layouts/default')

{{-- Page title --}}
@section('title')

  {{ trans('admin/suppliers/table.view') }} -
  {{ $supplier->name }}

  @parent
@stop

@section('header_right')
    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-default pull-right">
        {{ trans('admin/suppliers/table.update') }}</a>

    <a href="{{ route('suppliers.index') }}" class="btn btn-primary text-right" style="margin-right: 10px;">{{ trans('general.back') }}</a>

@stop


{{-- Page content --}}
@section('content')

  <div class="row">
    <div class="col-md-9">

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs hidden-print">
          
          <li class="active">
            <a href="#assets" data-toggle="tab">

                <span class="hidden-lg hidden-md">
                    <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
                </span>
                <span class="hidden-xs hidden-sm">
                    {{ trans('general.assets') }}
                    {!! (($supplier->assets) && ($supplier->assets()->AssetsForShow()->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($supplier->assets()->AssetsForShow()->count()).'</badge>' : '' !!}
               </span>

            </a>
          </li>

          <li>
            <a href="#accessories" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="far fa-keyboard fa-2x" aria-hidden="true"></i>
                    </span>
              <span class="hidden-xs hidden-sm">
                          {{ trans('general.accessories') }}
                          {!! (($supplier->accessories) && ($supplier->accessories->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($supplier->accessories->count()).'</badge>' : '' !!}
                    </span>
            </a>
          </li>

          <li>
            <a href="#licenses" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="far fa-save fa-2x" aria-hidden="true"></i>
                    </span>
              <span class="hidden-xs hidden-sm">
                          {{ trans('general.licenses') }}
                          {!! (($supplier->licenses) && ($supplier->licenses->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($supplier->licenses->count()).'</badge>' : '' !!}
                    </span>
            </a>
          </li>

          <li>
            <a href="#maintenances" data-toggle="tab">
                    <span class="hidden-lg hidden-md">
                        <i class="fas fa-wrench fa-2x"></i>
                    </span>
              <span class="hidden-xs hidden-sm">
                        {{ trans('admin/asset_maintenances/general.asset_maintenances') }}
                        {!! (($supplier->asset_maintenances) && ($supplier->asset_maintenances->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($supplier->asset_maintenances->count()).'</badge>' : '' !!}
                    </span>
            </a>
          </li>
        </ul>


        <div class="tab-content">


          <div class="tab-pane active" id="assets">
            <h2 class="box-title">{{ trans('general.assets') }}</h2>

            <div class="table table-responsive">
              @include('partials.asset-bulk-actions')
              <table
                      data-cookie-id-table="suppliersAssetsTable"
                      data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                      data-pagination="true"
                      data-id-table="suppliersAssetsTable"
                      data-search="true"
                      data-show-footer="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-show-fullscreen="true"
                      data-sort-order="asc"
                      data-toolbar="#assetsBulkEditToolbar"
                      data-bulk-button-id="#bulkAssetEditButton"
                      data-bulk-form-id="#assetsBulkForm"
                      data-click-to-select="true"
                      id="suppliersAssetsTable"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.assets.index', ['supplier_id' => $supplier->id]) }}"
                      data-export-options='{
                              "fileName": "export-suppliers-{{ str_slug($supplier->name) }}-assets-{{ date('Y-m-d') }}",
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
                      data-show-fullscreen="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      id="accessoriesListingTable"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.accessories.index', ['supplier_id' => $supplier->id]) }}"
                      data-export-options='{
                              "fileName": "export-suppliers-{{ str_slug($supplier->name) }}-accessories-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.tab-pane -->


          <div class="tab-pane" id="licenses">
            <h2 class="box-title">{{ trans('general.licenses') }}</h2>

            <div class="table table-responsive">
              <table
                      data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
                      data-cookie-id-table="licensesListingTable"
                      data-pagination="true"
                      data-id-table="licensesListingTable"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-fullscreen="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      id="licensesListingTable"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.licenses.index', ['supplier_id' => $supplier->id]) }}"
                      data-export-options='{
                              "fileName": "export-suppliers-{{ str_slug($supplier->name) }}-licenses-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
              </table>

            </div><!-- /.table-responsive -->
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="maintenances">
            <h2 class="box-title">{{ trans('admin/asset_maintenances/general.asset_maintenances') }}</h2>
            <div class="table table-responsive">

              <table
                      data-columns="{{ \App\Presenters\AssetMaintenancesPresenter::dataTableLayout() }}"
                      data-cookie-id-table="maintenancesTable"
                      data-pagination="true"
                      data-id-table="maintenancesTable"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-fullscreen="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      id="maintenancesTable"
                      class="table table-striped snipe-table"
                      data-url="{{ route('api.maintenances.index', ['supplier_id' => $supplier->id])}}"
                      data-export-options='{
                              "fileName": "export-suppliers-{{ str_slug($supplier->name) }}-maintenances-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.tab-pane -->

        </div><!--/.col-md-9-->
      </div><!--/.col-md-9-->
    </div><!--/.col-md-9-->

      <!-- side address column -->
      <div class="col-md-3">


      @if (($supplier->address!='') && ($supplier->state!='') && ($supplier->country!='') && (config('services.google.maps_api_key')))
              <div class="col-md-12 text-center" style="padding-bottom: 20px;">
                  <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($supplier->address.','.$supplier->city.' '.$supplier->state.' '.$supplier->country.' '.$supplier->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
              </div>
          @endif


          <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px; padding-top: 20px;">
              @if ($supplier->contact!='')
                  <li><i class="fas fa-user" aria-hidden="true"></i> {{ $supplier->contact }}</li>
              @endif
              @if ($supplier->phone!='')
                  <li><i class="fas fa-phone"></i>
                      <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
                  </li>
              @endif
              @if ($supplier->fax!='')
                  <li><i class="fas fa-print"></i> {{ $supplier->fax }}</li>
              @endif

              @if ($supplier->email!='')
                  <li>
                      <i class="far fa-envelope"></i>
                      <a href="mailto:{{ $supplier->email }}">
                          {{ $supplier->email }}
                      </a>
                  </li>
              @endif

              @if ($supplier->url!='')
                  <li>
                      <i class="fas fa-globe-americas"></i>
                      <a href="{{ $supplier->url }}" target="_new">{{ $supplier->url }}</a>
                  </li>
              @endif

              @if ($supplier->address!='')
                  <li><br>
                      {{ $supplier->address }}

                      @if ($supplier->address2)
                          <br>
                          {{ $supplier->address2 }}
                      @endif
                      @if (($supplier->city) || ($supplier->state))
                          <br>
                          {{ $supplier->city }} {{ strtoupper($supplier->state) }} {{ $supplier->zip }} {{ strtoupper($supplier->country) }}
                      @endif
                  </li>
              @endif

              @if ($supplier->notes!='')
                  <li><i class="fa fa-comment"></i> {{ $supplier->notes }}</li>
              @endif

          </ul>
          @if ($supplier->image!='')
              <div class="col-md-12 text-center" style="padding-bottom: 20px;">
                  <img src="{{ Storage::disk('public')->url(app('suppliers_upload_url').e($supplier->image)) }}" class="img-responsive img-thumbnail" alt="{{ $supplier->name }}">
              </div>
          @endif

      </div> <!--/col-md-3-->

  </div>
  </div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table', [
      'exportFile' => 'locations-export',
      'search' => true
   ])

@stop
