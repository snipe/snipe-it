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
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">



    <!-- start tables -->

    <div class="box box-default">
      <div class="box-header with-border">
        <div class="box-heading">
          <h2 class="box-title"> {{ trans('general.assets') }}</h2>
        </div>
      </div><!-- /.box-header -->

      <div class="box-body">
        <!-- checked out suppliers table -->
        <div class="table-responsive">

          <table
              data-cookie-id-table="suppliersAssetsTable"
              data-pagination="true"
              data-id-table="suppliersAssetsTable"
              data-search="true"
              data-show-footer="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-refresh="true"
              data-sort-order="asc"
              id="suppliersAssetsTable"
              class="table table-striped snipe-table"
              data-url="{{route('api.assets.index', ['supplier_id' => $supplier->id])}}"
              data-export-options='{
              "fileName": "export-{{ str_slug($supplier->name) }}-assets-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>

            <thead>
            <tr>
              <th data-searchable="false" data-visible="false" data-sortable="true" data-field="id">{{ trans('general.id') }}</th>
              <th data-searchable="false" data-visible="true" data-sortable="true" data-formatter="imageFormatter" data-field="image">{{ trans('admin/hardware/table.image') }}</th>
              <th data-searchable="false" data-sortable="true" data-formatter="hardwareLinkFormatter" data-field="name">{{ trans('general.name') }}</th>
              <th data-searchable="false" data-formatter="modelsLinkObjFormatter" data-sortable="false" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="asset_tag" data-formatter="hardwareLinkFormatter">{{ trans('admin/hardware/form.tag') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="serial">{{ trans('admin/hardware/form.serial') }}</th>
              <th data-searchable="false" data-visible="false" data-sortable="true" data-field="category" data-formatter="categoriesLinkObjFormatter">{{ trans('general.category') }}</th>
              <th data-field="purchase_cost" data-footer-formatter="sumFormatter">{{ trans('general.purchase_cost') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="hardwareInOutFormatter">{{ trans('general.checkin') }}/{{ trans('general.checkout') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="actions" data-formatter="hardwareActionsFormatter">{{ trans('table.actions') }}</th>
            </tr>
            </thead>
          </table>
        </div><!-- /.table-responsive -->
      </div><!-- /.box-body -->
      </div> <!--/.box-->

        <div class="box box-default">

          <div class="box-header with-border">
            <div class="box-heading">
              <h2 class="box-title"> {{ trans('general.accessories') }}</h2>
            </div>
          </div><!-- /.box-header -->

          <div class="box-body">
            <div class="table-responsive">

              <table
                      data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}"
                      data-cookie-id-table="suppliersAccessoriesTable"
                      data-pagination="true"
                      data-id-table="suppliersAccessoriesTable"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      id="suppliersAccessoriesTable"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.accessories.index', ['supplier_id' => $supplier->id])}}"
                      data-export-options='{
              "fileName": "export-{{ str_slug($supplier->name) }}-accessories-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>

              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->



          <div class="box box-default">

            @if ($supplier->id)
              <div class="box-header with-border">
                <div class="box-heading">
                  <h2 class="box-title"> {{ trans('general.licenses') }}</h2>
                </div>
              </div><!-- /.box-header -->
            @endif

            <div class="box-body">
              <div class="table-responsive">


                <table
                        data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
                        data-cookie-id-table="suppliersLicensesTable"
                        data-pagination="true"
                        data-id-table="suppliersLicensesTable"
                        data-search="true"
                        data-show-footer="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        id="suppliersLicensesTable"
                        class="table table-striped snipe-table"
                        data-url="{{route('api.licenses.index', ['supplier_id' => $supplier->id])}}"
                        data-export-options='{
                    "fileName": "export-{{ str_slug($supplier->name) }}-licenses-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>


              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->



        <div class="box box-default">

          @if ($supplier->id)
            <div class="box-header with-border">
              <div class="box-heading">
                <h2 class="box-title"> {{ trans('general.improvements') }}</h2>
              </div>
            </div><!-- /.box-header -->
          @endif

          <div class="box-body">
            <div class="table-responsive">
            <table class="table table-hover">
              <thead>
              <tr>
                <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/table.asset_name') }}</th>
                <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</th>
                <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.start_date') }}</th>
                <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.completion_date') }}</th>
                <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/table.is_warranty') }}</th>
                <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.cost') }}</th>
                <th class="col-md-1"><span class="line"></span>{{ trans('table.actions') }}</th>
              </tr>
              </thead>
              <tbody>
              <?php $totalCost = 0; ?>
              @if ($supplier->asset_maintenances)
                @foreach ($supplier->asset_maintenances as $improvement)
                  @if (is_null($improvement->deleted_at))
                    <tr>
                      <td>
                        @if ($improvement->asset)
                          <a href="{{ route('hardware.show', $improvement->asset_id) }}">{{ $improvement->asset->name }}</a>
                        @else
                            (deleted asset)
                        @endif
                      </td>
                      <td>{{ $improvement->asset_maintenance_type }}</td>
                      <td>{{ $improvement->start_date }}</td>
                      <td>{{ $improvement->completion_date }}</td>
                      <td>{{ $improvement->is_warranty ? trans('admin/asset_maintenances/message.warranty') : trans('admin/asset_maintenances/message.not_warranty') }}</td>
                      <td>{{ $snipeSettings->default_currency. ' '. Helper::formatCurrencyOutput($improvement->cost) }}</td>
                        <?php $totalCost += $improvement->cost; ?>
                      <td><a href="{{ route('maintenances.edit', $improvement->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt icon-white" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                  @endif
                @endforeach
              @endif
              </tbody>
              <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $snipeSettings->default_currency . ' '.Helper::formatCurrencyOutput($totalCost) }}</td>
              </tr>
              </tfoot>
            </table>
          </div><!-- /.table-responsive -->
        </div><!-- /.box-body -->
     </div> <!--/.box-->

  </div> <!--/col-md-9-->

  <!-- side address column -->
  <div class="col-md-3">

    @if (($supplier->state!='') && ($supplier->country!='') && (config('services.google.maps_api_key')))
      <div class="col-md-12 text-center" style="padding-bottom: 20px;">
        <img src="https://maps.googleapis.com/maps/api/staticmap?markers={{ urlencode($supplier->address.','.$supplier->city.' '.$supplier->state.' '.$supplier->country.' '.$supplier->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
      </div>
    @endif


    <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px; padding-top: 20px;">
      @if ($supplier->contact)
      <li><i class="fas fa-user" aria-hidden="true"></i> {{ $supplier->contact }}</li>
      @endif
      @if ($supplier->phone)
      <li><i class="fas fa-phone"></i>
        <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
      </li>
      @endif
      @if ($supplier->fax)
      <li><i class="fas fa-print"></i> {{ $supplier->fax }}</li>
      @endif

      @if ($supplier->email)
      <li>
        <i class="far fa-envelope"></i>
        <a href="mailto:{{ $supplier->email }}">
        {{ $supplier->email }}
        </a>
      </li>
      @endif

      @if ($supplier->url)
      <li>
        <i class="fas fa-globe-americas"></i>
        <a href="{{ $supplier->url }}" target="_new">{{ $supplier->url }}</a>
      </li>
      @endif

      @if ($supplier->address)
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

      @if ($supplier->notes)
      <li><i class="fa fa-comment"></i> {{ $supplier->notes }}</li>
      @endif

    </ul>
      @if ($supplier->image!='')
        <div class="col-md-12 text-center" style="padding-bottom: 20px;">
          <img src="{{ Storage::disk('public')->url(app('suppliers_upload_url').e($supplier->image)) }}" class="img-responsive img-thumbnail" alt="{{ $supplier->name }}">
        </div>
      @endif

  </div> <!--/col-md-3-->
</div> <!--/row-->



@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table', [
      'showFooter' => true,
      ])
@stop
