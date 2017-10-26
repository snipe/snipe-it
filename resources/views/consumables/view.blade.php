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
                name="consumable_users"
                class="table table-striped snipe-table"
                id="table"
                data-url="{{route('api.consumables.showUsers', $consumable->id)}}"
                data-cookie="true"
                data-click-to-select="true"
                data-cookie-id-table="consumableDetailTable-{{ config('version.hash_version') }}"
              >
                <thead>
                  <tr>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="created_at">{{ trans('general.date') }}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="admin">{{ trans('general.admin') }}</th>
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
