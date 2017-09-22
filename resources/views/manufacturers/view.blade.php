@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $manufacturer->name }}
 {{ trans('general.manufacturer') }}
@parent
@stop

@section('header_right')
  <div class="btn-group pull-right">
     <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
     <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="{{ route('manufacturers.edit', $manufacturer->id) }}">{{ trans('admin/manufacturers/table.update') }}</a></li>
        <li><a href="{{ route('manufacturers.create') }}">{{ trans('admin/manufacturers/table.create') }}</a></li>
      </ul>
  </div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">

      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#assets" data-toggle="tab">Assets</a>
        </li>
        <li>
          <a href="#licenses" data-toggle="tab">Licenses</a>
        </li>
        <li>
          <a href="#accessories" data-toggle="tab">Accessories</a>
        </li>
        <li>
          <a href="#consumables" data-toggle="tab">Consumables</a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active" id="assets">
          <table
            name="manufacturer_assets"
            class="table table-striped bootstrap-table snipe-table"
            id="assets-table"
            data-url="{{ route('api.assets.index', ['manufacturer_id' => $manufacturer->id, 'itemtype' => 'assets']) }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="maufacturerAssetsTable-{{config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-searchable="false" data-sortable="false" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="company" data-visible="false" data-formatter="companiesLinkObjFormatter">
                    {{ trans('admin/companies/table.title') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="name" data-formatter="hardwareLinkFormatter">{{ trans('general.name') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="image" data-visible="false" data-formatter="imageFormatter">{{ trans('admin/hardware/table.image') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="model" data-formatter="modelsLinkObjFormatter">{{ trans('admin/hardware/form.model') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="asset_tag" data-formatter="hardwareLinkFormatter">{{ trans('general.asset_tag') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="serial" data-formatter="hardwareLinkFormatter">{{ trans('admin/hardware/form.serial') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="assigned_to" data-formatter="usersLinkObjFormatter">{{ trans('general.user') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="change"  data-switchable="false" data-formatter="hardwareInOutFormatter">{{ trans('admin/hardware/table.change') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="actions"  data-switchable="false" data-formatter="hardwareActionsFormatter">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div> <!-- /.tab-pane assets -->

        <div class="tab-pane fade" id="licenses">
          <table
            name="manufacturer_licenses"
            class="table table-striped bootstrap-table snipe-table"
            id="licenses-table"
            data-url="{{ route('api.licenses.index', ['manufacturer_id' => $manufacturer->id]) }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="maufacturerLicensesTable-{{config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-field="company" data-sortable="false" data-switchable="true" data-formatter="companiesLinkObjFormatter">{{ trans('general.company') }}</th>
                <th data-field="name" data-sortable="true" data-formatter="licensesLinkFormatter">{{ trans('admin/licenses/table.title') }}</th>
                <th data-field="manufacturer" data-sortable="true" data-formatter="manufacturersLinkObjFormatter">{{ trans('general.manufacturer') }}</th>
                <th data-field="product_key" data-sortable="true" >{{ trans('admin/licenses/table.serial') }}</th>
                <th data-field="license_name" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_name') }}</th>
                <th data-field="license_email" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_email') }}</th>
                <th data-field="total_seats" data-sortable="false">{{ trans('admin/licenses/form.seats') }}</th>
                <th data-field="remaining_qty" data-sortable="false">{{ trans('admin/licenses/form.remaining_seats') }}</th>
                <th data-field="purchase_date" data-sortable="true"  data-formatter="dateDisplayFormatter">{{ trans('admin/licenses/table.purchase_date') }}</th>
                <th data-field="purchase_cost" data-sortable="true">{{ trans('general.purchase_cost') }}</th>
                <th data-field="purchase_order" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.purchase_order') }}</th>
                <th data-field="expiration_date" data-sortable="true" data-visible="false"  data-formatter="dateDisplayFormatter">{{ trans('admin/licenses/form.expiration') }}</th>
                <th data-field="notes" data-sortable="true" data-visible="false">{{ trans('general.notes') }}</th>
                <th data-field="actions" data-formatter="licensesActionsFormatter">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div><!-- /.tab-pan licenses-->

        <div class="tab-pane fade" id="accessories">
          <table
            name="manufacturer_accessories"
            class="table table-striped bootstrap-table snipe-table"
            id="licenses-table"
            data-url="{{ route('api.accessories.index', ['manufacturer_id' => $manufacturer->id]) }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="manufacturerAccessoriesTable-{{config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-switchable="true" data-searchable="true" data-sortable="true" data-field="company" data-visible="false" data-formatter="companiesLinkObjFormatter">{{ trans('admin/companies/table.title') }}</th>
                <th data-sortable="true" data-searchable="true"  data-field="name" data-formatter="accessoriesLinkFormatter">{{ trans('admin/accessories/table.title') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="category" data-formatter="categoriesLinkObjFormatter">{{ trans('admin/accessories/general.accessory_category') }}</th>
                <th data-field="manufacturer" data-searchable="true" data-sortable="true" data-formatter="manufacturersLinkObjFormatter">{{ trans('general.manufacturer') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="location" data-formatter="locationsLinkObjFormatter">{{ trans('general.location') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="qty">{{ trans('admin/accessories/general.total') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="purchase_date" data-visible="false" data-formatter="dateDisplayFormatter">{{ trans('general.purchase_date') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="order_number" data-visible="false">{{ trans('general.order_number') }}</th>
                <th data-searchable="false" data-sortable="true" data-field="min_qty">{{ trans('general.min_amt') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="remaining_qty">{{ trans('admin/accessories/general.remaining') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" data-formatter="accessoriesActionsFormatter">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div> <!-- /.tab-pan accessories-->

        <div class="tab-pane fade" id="consumables">
          <table
            name="manufacturer_consumables"
            class="table table-striped bootstrap-table snipe-table"
            id="licenses-table"
            data-url="{{ route('api.consumables.index', ['manufacturer_id' => $manufacturer->id]) }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="maufacturerConsumablesTable-{{config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-switchable="true" data-searchable="true" data-sortable="true" data-field="company" data-formatter="companiesLinkObjFormatter">{{ trans('admin/companies/table.title') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="name" data-formatter="consumablesLinkFormatter">{{ trans('admin/consumables/table.title') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="location" data-formatter="locationsLinkObjFormatter">{{ trans('general.location') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="category" data-formatter="categoriesLinkObjFormatter">{{ trans('general.category') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="qty"> {{ trans('admin/consumables/general.total') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="remaining"> {{ trans('admin/consumables/general.remaining') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="true" data-field="min_amt"> {{ trans('general.min_amt') }}</th>
                <th data-sortable="true" data-field="manufacturer" data-visible="false" data-formatter="manufacturersLinkObjFormatter">{{ trans('general.manufacturer') }}</th>
                <th data-sortable="true" data-field="model_number" data-visible="false">{{ trans('general.model_no') }}</th>
                <th data-sortable="true" data-field="item_no" data-visible="false">{{ trans('admin/consumables/general.item_no') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="order_number" data-visible="false">{{ trans('general.order_number') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="purchase_date" data-visible="false" data-formatter="dateDisplayFormatter">{{ trans('general.purchase_date') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="purchase_cost" data-visible="false">{{ trans('general.purchase_cost') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" data-formatter="consumablesActionsFormatter"> {{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div> <!-- /.tab-pan consumables-->

      </div> <!-- /.tab-content -->
    </div>  <!-- /.nav-tabs-custom -->
  </div><!-- /. col-md-12 -->
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'manufacturer' . $manufacturer->name . '-export', 'search' => false])

@stop
