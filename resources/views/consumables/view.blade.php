@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{ $consumable->name }}
 {{ trans('general.consumable') }}
 @if ($consumable->model_number!='')
   ({{ $consumable->model_number }})
 @endif
@parent
@stop

{{-- Right header --}}
@section('header_right')
  @can('manage', \App\Models\Consumable::class)
    <div class="dropdown pull-right">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        {{ trans('button.actions') }}
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu pull-right" role="menu">
        @if ($consumable->assigned_to != '')

        @else
          @can('checkout', \App\Models\Consumable::class)
            <li role="menuitem">
              <a href="{{ route('checkout/consumable', $consumable->id)  }}">{{ trans('admin/consumables/general.checkout') }}</a>
            </li>
          @endcan
        @endif
        @can('update', \App\Models\Consumable::class)
          <li role="menuitem">
            <a href="{{ route('consumables.edit', $consumable->id) }}">{{ trans('admin/consumables/general.update') }}</a>
          </li>
        @endcan
      </ul>
    </div>
  @endcan
@stop

{{--@section('header_right')--}}
{{--<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">--}}
{{--  {{ trans('general.back') }}</a>--}}
{{--@stop--}}


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
          <!-- side address column -->

          <div class="col-md-3">
            @if ($consumable->image!='')
              <div class="row">
                <div class="col-md-12 text-center" style="padding-bottom: 15px;">
                  <a href="{{ Storage::disk('public')->url('consumables/'.e($consumable->image)) }}" data-toggle="lightbox">
                    <img src="{{ Storage::disk('public')->url('consumables/'.e($consumable->image)) }}" class="img-responsive img-thumbnail" alt="{{ $consumable->name }}">
                  </a>
                </div>
              </div>
            @endif
              @if ($consumable->company)
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.company')}}</strong>
                  </div>
                  <div class="col-md-8">
                    <a href="{{ route('companies.show', $consumable->company->id) }}">{{ $consumable->company->name }} </a>
                  </div>
                </div>
              @endif

              @if ($consumable->category)
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.category')}}</strong>
                  </div>
                  <div class="col-md-8">
                    <a href="{{ route('categories.show', $consumable->category->id) }}">{{ $consumable->category->name }} </a>
                  </div>
                </div>
              @endif

              @if ($consumable->item_no)
                        <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('admin/consumables/general.item_no') }}</strong>
                </div>
                <div class="col-md-8">
                  {{ $consumable->item_no }}
                </div>
                        </div>
              @endif

              @if ($consumable->model_number)
                            <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.model_no') }}</strong>
                </div>
                <div class="col-md-8">
                  {{ $consumable->model_number }}
                </div>
                            </div>
              @endif

              @if ($consumable->manufacturer)
                                <div class="row">
                <div class="col-md-4">
                  <strong>{{ trans('general.manufacturer') }}</strong>
                </div>
                <div class="col-md-8">
                  <a href="{{ route('manufacturers.show', $consumable->manufacturer->id) }}">{{ $consumable->manufacturer->name }}</a>
                </div>
                                </div>
              @endif

              @if ($consumable->supplier_id)
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.supplier') }}</strong>
                  </div>
                  <div class="col-md-8">
                    <a href="{{ route('suppliers.show', $consumable->supplier_id) }}">
                      {{ $consumable->supplier->name }}
                    </a>
                  </div>
                </div>
              @endif
              @if ($consumable->order_number)
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.order_number') }}</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $consumable->order_number }}
                  </div>
                </div>
              @endif
              @if ($consumable->purchase_date)
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.purchase_date') }}</strong>
                  </div>
                  <div class="col-md-8">
                    {{ Helper::getFormattedDateObject($consumable->purchase_date, 'date', false) }}
                  </div>
                </div>
              @endif

              @if ($consumable->purchase_cost)
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.purchase_cost') }}</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $snipeSettings->default_currency }}
                    {{ Helper::formatCurrencyOutput($consumable->purchase_cost) }}
                  </div>
                </div>
              @endif

              @if ($consumable->notes)
              <div class="row"  style="padding-bottom: 15px;">
                <div class="col-md-12">
                  <strong>
                    <strong>{{ trans('general.notes') }}</strong>
                  </strong>
                </div>
                <div class="col-md-12">
                  {!! nl2br(e($consumable->notes)) !!}
                </div>
              </div>
              @endif
              <div class="row">
                <div class="col-md-4">
                  <strong>Number remaining</strong>
                </div>
                <div class="col-md-8">
                  {{ $consumable->numRemaining() }}
                </div>
              </div>
              @can('checkout', \App\Models\Consumable::class)
                <div class="row">
                  <div class="col-md-12 text-center" style="padding-top: 15px;">
                    <a href="{{ route('checkout/consumable', $consumable->id) }}" style="margin-right:5px;" class="btn btn-primary btn-sm" {{ (($consumable->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
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
                    data-cookie-id-table="ConsumableHistoryTable"
                    data-id-table="ConsumableHistoryTable"
                    id="ConsumableHistoryTable"
                    data-pagination="true"
                    data-show-columns="true"
                    data-side-pagination="server"
                    data-show-refresh="true"
                    data-show-export="true"
                    data-sort-order="desc"
                    data-export-options='{
                       "fileName": "export-{{ str_slug($consumable->name) }}-history-{{ date('Y-m-d') }}",
                       "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                     }'
                    data-url="{{ route('api.activity.index', ['item_id' => $consumable->id, 'item_type' => 'consumable']) }}">

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
@include ('partials.bootstrap-table', ['exportFile' => 'consumable' . $consumable->name . '-export', 'search' => false])
@stop