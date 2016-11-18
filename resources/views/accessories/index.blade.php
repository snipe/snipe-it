@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.accessories') }}
@parent
@stop

@section('header_right')
    @can('accessories.create')
        <a href="{{ route('create/accessory') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
          name="accessories"
          class="table table-striped snipe-table"
          id="table"
          data-url="{{route('api.accessories.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="accessoriesTable-{{ config('version.hash_version') }}">
            <thead>
                <tr>
                  <th data-switchable="true" data-searchable="true" data-sortable="true" data-field="companyName" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
                  <th data-sortable="true" data-searchable="true"  data-field="name">{{ trans('admin/accessories/table.title') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="category">{{ trans('admin/accessories/general.accessory_category') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="model_number">{{ trans('admin/models/table.modelnumber') }}</th>
                  <th data-field="manufacturer" data-searchable="true" data-sortable="true">{{ trans('general.manufacturer') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="qty">{{ trans('admin/accessories/general.total') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="purchase_date" data-visible="false">{{ trans('general.purchase_date') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                  <th data-searchable="true" data-sortable="true" data-field="order_number" data-visible="false">{{ trans('general.order_number') }}</th>
                  <th data-searchable="false" data-sortable="true" data-field="min_amt">{{ trans('general.min_amt') }}</th>
                  <th data-searchable="false" data-sortable="false" data-field="numRemaining">{{ trans('admin/accessories/general.remaining') }}</th>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                </tr>
            </thead>
          </table>
        </div>
      </div>
  </div>
</div>


@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'accessories-export', 'search' => true])
@stop


@stop
