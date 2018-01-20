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
          <h3 class="box-title"> {{ trans('general.assets') }}</h3>
        </div>
      </div><!-- /.box-header -->

      <div class="box-body">
        <!-- checked out suppliers table -->
        <div class="table-responsive">
          <table
                  name="suppliers_assets"
                  id="table-users"
                  class="table table-striped snipe-table"
                  data-url="{{route('api.assets.index', ['supplier_id' => $supplier->id])}}"
                  data-cookie="true"
                  data-click-to-select="true"
                  data-search="true"
                  data-cookie-id-table="assets_by_supplierTable">
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
              <th data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="hardwareInOutFormatter">Checkin/Checkout</th>
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
              <h3 class="box-title"> {{ trans('general.accessories') }}</h3>
            </div>
          </div><!-- /.box-header -->

          <div class="box-body">
            <div class="table-responsive">

              <table
                      name="suppliers_accessories"
                      id="table-users"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.accessories.index', ['supplier_id' => $supplier->id])}}"
                      data-search="true"
                      data-cookie="true"
                      data-click-to-select="true"
                      data-cookie-id-table="accessories_by_supplierTable">
                <thead>
                <tr>
                  <th data-searchable="false" data-visible="false" data-sortable="true" data-field="id">{{ trans('general.id') }}</th>
                  <th data-searchable="false" data-sortable="true" data-formatter="accessoriesLinkFormatter" data-field="name">{{ trans('general.name') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="model_number">{{ trans('admin/models/table.modelnumber') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="asset_tag">{{ trans('admin/hardware/form.tag') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="serial">{{ trans('admin/hardware/form.serial') }}</th>
                  <th data-searchable="false" data-visible="false" data-sortable="true" data-field="category" data-formatter="categoriesLinkObjFormatter">{{ trans('general.category') }}</th>
                  <th data-field="purchase_cost" data-footer-formatter="sumFormatter">{{ trans('general.purchase_cost') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="actions" data-formatter="accessoriesActionsFormatter">{{ trans('table.actions') }}</th>
                </tr>
                </thead>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->



          <div class="box box-default">

            @if ($supplier->id)
              <div class="box-header with-border">
                <div class="box-heading">
                  <h3 class="box-title"> {{ trans('general.licenses') }}</h3>
                </div>
              </div><!-- /.box-header -->
            @endif

            <div class="box-body">
              <div class="table-responsive">
              <table
                      name="suppliers_licenses"
                      id="table-users"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.licenses.index', ['supplier_id' => $supplier->id])}}"
                      data-cookie="true"
                      data-search="true"
                      data-click-to-select="true"
                      data-cookie-id-table="licenses_by_supplierTable">
                <thead>
                <tr>
                  <th data-searchable="false" data-visible="false" data-sortable="true" data-field="id">{{ trans('general.id') }}</th>
                  <th data-searchable="true" data-sortable="true" data-formatter="licensesLinkFormatter" data-field="name">{{ trans('general.name') }}</th>
                  <th data-searchable="true" data-sortable="true" data-formatter="licensesLinkFormatter" data-field="product_key">{{ trans('admin/licenses/form.license_key') }}</th>
                  <th data-searchable="true" data-sortable="true" data-formatter="licensesLinkFormatter" data-field="license_email">{{ trans('admin/licenses/form.to_email') }}</th>
                  <th data-searchable="true" data-sortable="false" data-field="seats">{{ trans('admin/licenses/form.seats') }}</th>
                  <th data-searchable="true" data-sortable="false" data-field="free_seats_count">{{ trans('admin/accessories/general.remaining') }}</th>
                  <th data-field="purchase_cost" data-footer-formatter="sumFormatter">{{ trans('general.purchase_cost') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="actions" data-formatter="licensesActionsFormatter">{{ trans('table.actions') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="licensesActionsFormatter">{{ trans('table.actions') }}</th>
                </tr>
                </thead>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.box-body -->
        </div> <!--/.box-->



        <div class="box box-default">

          @if ($supplier->id)
            <div class="box-header with-border">
              <div class="box-heading">
                <h3 class="box-title"> Improvements</h3>
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
                      <td>{{ sprintf( $snipeSettings->default_currency. '%01.2f', $improvement->cost) }}</td>
                        <?php $totalCost += $improvement->cost; ?>
                      <td><a href="{{ route('maintenances.edit', $improvement->id) }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i></a>
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
                <td>{{sprintf($snipeSettings->default_currency . '%01.2f', $totalCost)}}</td>
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
        <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($supplier->city.','.$supplier->city.' '.$supplier->state.' '.$supplier->country.' '.$supplier->zip) }}&size=500x300&maptype=roadmap&key={{ config('services.google.maps_api_key') }}" class="img-responsive img-thumbnail" alt="Map">
      </div>
    @endif


    <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px; padding-top: 20px;">
      @if ($supplier->contact)
      <li><i class="fa fa-user"></i> {{ $supplier->contact }}</li>
      @endif
      @if ($supplier->phone)
      <li><i class="fa fa-phone"></i>
        <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
      </li>
      @endif
      @if ($supplier->fax)
      <li><i class="fa fa-print"></i> {{ $supplier->fax }}</li>
      @endif

      @if ($supplier->email)
      <li>
        <i class="fa fa-envelope-o"></i>
        <a href="mailto:{{ $supplier->email }}">
        {{ $supplier->email }}
        </a>
      </li>
      @endif

      @if ($supplier->url)
      <li>
        <i class="fa fa-globe"></i>
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
          <img src="{{ app('suppliers_upload_url') }}/{{ $supplier->image }}" class="img-responsive img-thumbnail" alt="{{ $supplier->name }}">
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
