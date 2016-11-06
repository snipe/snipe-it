@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.consumables') }}
@parent
@stop

@section('header_right')
    @can('consumables.create')
        <a href="{{ route('create/consumable') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
        <div class="box-body">
          <table
          name="consumables"
          class="table table-striped snipe-table"
          id="table"
          data-url="{{route('api.consumables.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="consumablesTable-{{ config('version.hash_version') }}-{{ config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-switchable="true" data-searchable="true" data-sortable="true" data-field="companyName">{{ trans('admin/companies/table.title') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="name">{{ trans('admin/consumables/table.title') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="category">{{ trans('general.category') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="qty"> {{ trans('admin/consumables/general.total') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="numRemaining"> {{ trans('admin/consumables/general.remaining') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="true" data-field="min_amt"> {{ trans('general.min_amt') }}</th>
                <th data-sortable="true" data-field="manufacturer" data-visible="false">{{ trans('general.manufacturer') }}</th>
                <th data-sortable="true" data-field="model_number" data-visible="false">{{ trans('general.model_no') }}</th>
                <th data-sortable="true" data-field="item_no" data-visible="false">{{ trans('admin/consumables/general.item_no') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="order_number" data-visible="false">{{ trans('general.order_number') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="purchase_date" data-visible="false">{{ trans('general.purchase_date') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="purchase_cost" data-visible="false">{{ trans('general.purchase_cost') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions"> {{ trans('table.actions') }}</th>

              </tr>
            </thead>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

  </div>
</div>


@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'consumables-export', 'search' => true])


@stop

@stop
