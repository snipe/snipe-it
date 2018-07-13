@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $component->name }}
 {{ trans('general.component') }}
@parent
@stop

{{-- Right header --}}
@section('header_right')
  @can('manage', $component)
    <div class="dropdown pull-right">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
          <span class="caret"></span>
      </button>
      <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
        @if ($component->assigned_to != '')
          @can('checkin', $component)
          <li role="presentation"><a href="{{ route('checkin/component', $component->id) }}">{{ trans('admin/components/general.checkin') }}</a></li>
          @endcan
        @else
          @can('checkout', $component)
          <li role="presentation"><a href="{{ route('checkout/component', $component->id)  }}">{{ trans('admin/components/general.checkout') }}</a></li>
          @endcan
        @endif

        @can('update', $component)
        <li role="presentation"><a href="{{ route('components.edit', $component->id) }}">{{ trans('admin/components/general.edit') }}</a></li>
        @endcan
      </ul>
    </div>
  @endcan
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table table-responsive">

              <table
                      data-cookie-id-table="componentsCheckedoutTable"
                      data-pagination="true"
                      data-id-table="componentsCheckedoutTable"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-footer="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      data-sort-name="name"
                      id="componentsCheckedoutTable"
                      class="table table-striped snipe-table"
                      data-url="{{ route('api.components.assets', $component->id)}}"
                      data-export-options='{
                "fileName": "export-components-{{ str_slug($component->name) }}-checkedout-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                <thead>
                <tr>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name" data-formatter="hardwareLinkFormatter">{{ trans('general.asset') }}</th>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="qty">{{ trans('general.qty') }}</th>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="componentsInOutFormatter">{{ trans('general.checkin') }}/{{ trans('general.checkout') }}</th>
                </tr>
                </thead>
              </table>

            </div>
          </div> <!-- .col-md-12-->
        </div>
      </div>
    </div>
  </div> <!-- .col-md-9-->


  <!-- side address column -->
  <div class="col-md-3">
    @if ($component->image!='')
      <div class="col-md-12" style="padding-bottom: 5px;">
        <img src="{{ url('/') }}/uploads/components/{{ $component->image  }}">
      </div>
    @endif

    @if ($component->serial!='')
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.serial') }}: </strong>
    {{ $component->serial }} </div>
    @endif

    @if ($component->purchase_date)
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/components/general.date') }}: </strong>
    {{ $component->purchase_date }} </div>
    @endif

    @if ($component->purchase_cost)
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/components/general.cost') }}:</strong>
    {{ $snipeSettings->default_currency }}

    {{ \App\Helpers\Helper::formatCurrencyOutput($component->purchase_cost) }} </div>
    @endif

    @if ($component->order_number)
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('general.order_number') }}:</strong>
    {{ $component->order_number }} </div>
    @endif
  </div>
</div> <!-- .row-->

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'component' . $component->name . '-export', 'search' => false])
@stop
