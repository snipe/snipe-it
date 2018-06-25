@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $insurance->name }}
 {{ trans('general.insurance') }}
@parent
@stop

@section('header_right')
  <div class="btn-group pull-right">
     <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
     <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="{{ route('insurance.edit', $insurance->id) }}">{{ trans('admin/insurance/table.update') }}</a></li>
        <li><a href="{{ route('insurance.create') }}">{{ trans('admin/insurance/table.create') }}</a></li>
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
          <a href="#info" data-toggle="tab">Info</a>
        </li>
        <li>
          <a href="#devices" data-toggle="tab">Insured Devices</a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active" id="info">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive" style="margin-top: 10px;">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>{{ trans('general.status') }}</td>
                                <td>
                                    <!-- -->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- /.tab-pane info -->

        <div class="tab-pane fade" id="devices">

          <table
                  data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                  data-cookie-id-table="licensesTable"
                  data-pagination="true"
                  data-id-table="licensesTable"
                  data-search="true"
                  data-show-footer="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="licensesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.assets.index', ['insurance' => $insurance->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($insurance->name) }}-licenses-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>


        </div><!-- /.tab-pan licenses-->

        <div class="tab-pane fade" id="accessories">

          <table
                  data-columns="{{ \App\Presenters\InsurancePresenter::dataTableLayout() }}"
                  data-cookie-id-table="accessoriesTable"
                  data-pagination="true"
                  data-id-table="accessoriesTable"
                  data-search="true"
                  data-show-footer="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="accessoriesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.accessories.index', ['manufacturer_id' => $insurance->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($insurance->name) }}-accessories-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>


        </div> <!-- /.tab-pan accessories-->

        <div class="tab-pane fade" id="consumables">

          <table
                  data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                  data-cookie-id-table="consumablesTable"
                  data-pagination="true"
                  data-id-table="consumablesTable"
                  data-search="true"
                  data-show-footer="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="consumablesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.consumables.index', ['manufacturer_id' => $insurance->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($insurance->name) }}-consumabled-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>



        </div> <!-- /.tab-pan consumables-->

      </div> <!-- /.tab-content -->
    </div>  <!-- /.nav-tabs-custom -->
  </div><!-- /. col-md-12 -->
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'manufacturer' . $insurance->name . '-export', 'search' => false])

@stop
