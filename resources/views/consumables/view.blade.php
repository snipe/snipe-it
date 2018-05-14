@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{ $consumable->name }}
 {{ trans('general.consumable') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      @if ($consumable->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title"> {{ $consumable->name }}</h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table table-responsive">

              <table
                      data-cookie-id-table="consumablesCheckedoutTable"
                      data-pagination="true"
                      data-id-table="consumablesCheckedoutTable"
                      data-search="false"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-footer="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      data-sort-name="name"
                      id="consumablesCheckedoutTable"
                      class="table table-striped snipe-table"
                      data-url="{{route('api.consumables.showUsers', $consumable->id)}}"
                      data-export-options='{
                "fileName": "export-consumables-{{ str_slug($consumable->name) }}-checkedout-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                <thead>
                  <tr>
                    <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="admin">{{ trans('general.admin') }}</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div> <!-- /.col-md-12-->

        </div>
      </div>
    </div> <!-- /.box.box-default-->
  </div> <!-- /.col-md-9-->
  <div class="col-md-3">

    @if ($consumable->image!='')
      <div class="col-md-12" style="padding-bottom: 5px;">
        <img src="{{ url('/') }}/uploads/consumables/{{ $consumable->image  }}">
      </div>
    @endif

    <h4>{{ trans('admin/consumables/general.about_consumables_title') }}</h4>
    <p>{{ trans('admin/consumables/general.about_consumables_text') }} </p>

    @if ($consumable->purchase_date)
      <div class="col-md-12" style="padding-bottom: 5px;">
        <strong>{{ trans('general.purchase_date') }}: </strong>
        {{ $consumable->purchase_date }}
      </div>
    @endif

    @if ($consumable->purchase_cost)
      <div class="col-md-12" style="padding-bottom: 5px;">
        <strong>{{ trans('general.purchase_cost') }}:</strong>
        {{ $snipeSettings->default_currency }}
        {{ \App\Helpers\Helper::formatCurrencyOutput($consumable->purchase_cost) }}
      </div>
    @endif

    @if ($consumable->item_no)
      <div class="col-md-12" style="padding-bottom: 5px;">
        <strong>{{ trans('admin/consumables/general.item_no') }}:</strong>
        {{ $consumable->item_no }}
      </div>
    @endif

    @if ($consumable->model_number)
      <div class="col-md-12" style="padding-bottom: 5px;">
        <strong>{{ trans('general.model_no') }}:</strong>
        {{ $consumable->model_number }}
      </div>
    @endif

    @if ($consumable->manufacturer)
      <div class="col-md-12" style="padding-bottom: 5px;">
        <strong>{{ trans('general.manufacturer') }}:</strong>
        {{ $consumable->manufacturer->name }}
      </div>
    @endif

    @if ($consumable->order_number)
      <div class="col-md-12" style="padding-bottom: 5px;">
        <strong>{{ trans('general.order_number') }}:</strong>
        {{ $consumable->order_number }}
      </div>
    @endif
  </div> <!-- /.col-md-3-->
</div> <!-- /.row-->

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'consumable' . $consumable->name . '-export', 'search' => false])
@stop
