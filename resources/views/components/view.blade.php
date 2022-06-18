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
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        {{ trans('button.actions') }}
          <span class="caret"></span>
      </button>
      
      <ul class="dropdown-menu pull-right" role="menu22">
        @if ($component->assigned_to != '')
          @can('checkin', $component)
          <li role="menuitem">
            <a href="{{ route('checkin/component', $component->id) }}">
              {{ trans('admin/components/general.checkin') }}
            </a>
          </li>
          @endcan
        @else
          @can('checkout', $component)
          <li role="menuitem">
            <a href="{{ route('checkout/component', $component->id)  }}">
              {{ trans('admin/components/general.checkout') }}
            </a>
          </li>
          @endcan
        @endif

        @can('update', $component)
        <li role="menuitem">
          <a href="{{ route('components.edit', $component->id) }}">
            {{ trans('admin/components/general.edit') }}
          </a>
        </li>
        @endcan
      </ul>
    </div>
  @endcan
@stop


{{-- Page content --}}
@section('content')

  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">

    <ul class="nav nav-tabs hidden-print">

      <li class="active">
        <a href="#details" data-toggle="tab">
                  <span class="hidden-lg hidden-md">
                  <i class="fas fa-info-circle fa-2x"x></i>
                  </span>
          <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.info') }}</span>
        </a>
      </li>
      <li>
        <a href="#history" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-history fa-2x" aria-hidden="true"></i></span>
          <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span>
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade in active" id="details">
        <div class="row">
          <div class="col-md-9">
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
                <th data-searchable="false" data-sortable="false" data-field="name" data-formatter="hardwareLinkFormatter">
                  {{ trans('general.asset') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="qty">
                  {{ trans('general.qty') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">
                  {{ trans('general.date') }}
                </th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="componentsInOutFormatter">
                  {{ trans('general.checkin') }}/{{ trans('general.checkout') }}
                </th>
              </tr>
              </thead>
            </table>
          </div>
          <!-- side address column -->
          <div class="col-md-3">
            @if ($component->image!='')
              <div class="row">
                <div class="col-md-12 text-center" style="padding-bottom: 15px;">
                  <a href="{{ Storage::disk('public')->url('components/'.e($component->image)) }}" data-toggle="lightbox">
                    <img src="{{ Storage::disk('public')->url('components/'.e($component->image)) }}" class="img-responsive img-thumbnail" alt="{{ $component->name }}">
                  </a>
                </div>
              </div>
            @endif
            @if ($component->company)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.company')}}</strong>
                </div>
                <div class="col-md-8">
                  <a href="{{ route('companies.show', $component->company->id) }}">{{ $component->company->name }} </a>
                </div>
              </div>
            @endif

            @if ($component->category)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.category')}}</strong>
                </div>
                <div class="col-md-8">
                  <a href="{{ route('categories.show', $component->category->id) }}">{{ $component->category->name }} </a>
                </div>
              </div>
            @endif

            @if ($component->model_number)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.model_no') }}</strong>
                </div>
                <div class="col-md-8">
                  {{ $component->model_number }}
                </div>
              </div>
            @endif

            @if ($component->manufacturer)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.manufacturer') }}</strong>
                </div>
                <div class="col-md-8">
                  <a href="{{ route('manufacturers.show', $component->manufacturer->id) }}">{{ $component->manufacturer->name }}</a>
                </div>
              </div>
            @endif

            @if ($component->supplier_id)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.supplier') }}</strong>
                </div>
                <div class="col-md-8">
                  <a href="{{ route('suppliers.show', $component->supplier_id) }}">
                    {{ $component->supplier->name }}
                  </a>
                </div>
              </div>
            @endif
            @if ($component->order_number)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.order_number') }}</strong>
                </div>
                <div class="col-md-8">
                  {{ $component->order_number }}
                </div>
              </div>
            @endif
            @if ($component->purchase_date)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.purchase_date') }}</strong>
                </div>
                <div class="col-md-8">
                  {{ Helper::getFormattedDateObject($component->purchase_date, 'date', false) }}
                </div>
              </div>
            @endif

            @if ($component->purchase_cost)
              <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.purchase_cost') }}</strong>
                </div>
                <div class="col-md-8">
                  {{ $snipeSettings->default_currency }}
                  {{ Helper::formatCurrencyOutput($component->purchase_cost) }}
                </div>
              </div>
            @endif

            @if ($component->notes)
              <div class="row"  style="padding-bottom: 15px;">
                <div class="col-md-12">
                  <strong>
                    <strong>{{ trans('general.notes') }}</strong>
                  </strong>
                </div>
                <div class="col-md-12">
                  {!! nl2br(e($component->notes)) !!}
                </div>
              </div>
            @endif
            <div class="row">
              <div class="col-md-4">
                <strong>Number remaining</strong>
              </div>
              <div class="col-md-8">
                {{ $component->numRemaining() }}
              </div>
            </div>
            @can('checkout', \App\Models\Component::class)
              <div class="row">
                <div class="col-md-12 text-center" style="padding-top: 15px;">
                  <a href="{{ route('checkout/component', $component->id) }}" style="margin-right:5px;" class="btn btn-primary btn-sm" {{ (($component->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
                </div>
              </div>
            @endcan

            </div>
        </div>

      
      </div>
      <div class="tab-pane fade" id="history">
        <div class="row">
          <div class="col-md-12">
            <table
                    class="table table-striped snipe-table"
                    data-cookie-id-table="ComponentHistoryTable"
                    data-id-table="ComponentHistoryTable"
                    id="ComponentHistoryTable"
                    data-pagination="true"
                    data-show-columns="true"
                    data-side-pagination="server"
                    data-show-refresh="true"
                    data-show-export="true"
                    data-sort-order="desc"
                    data-export-options='{
                       "fileName": "export-{{ str_slug($component->name) }}-history-{{ date('Y-m-d') }}",
                       "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                     }'
                    data-url="{{ route('api.activity.index', ['item_id' => $component->id, 'item_type' => 'component']) }}">

              <thead>
              <tr>
                <th class="col-sm-2" data-visible="true" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.record_created') }}</th>
                <th class="col-sm-2" data-visible="true" data-sortable="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.user') }}</th>
                <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                <th class="col-sm-2" data-sortable="true" data-visible="true" data-field="note">{{ trans('general.notes') }}</th>
                @if  ($snipeSettings->require_accept_signature=='1')
                  <th class="col-md-3" data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">{{ trans('general.signature') }}</th>
                @endif
                <th class="col-sm-2" data-field="log_meta" data-visible="true" data-formatter="changeLogFormatter">{{ trans('general.changed')}}</th>
              </tr>
              </thead>
            </table>
          </div> <!-- /.col-md-12-->
        </div> <!-- /.row-->
      </div><!--tab history-->
    </div>
  </div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'component' . $component->name . '-export', 'search' => false])
@stop