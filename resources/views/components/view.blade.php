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

<div class="row">
  <div class="col-md-9">

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs hidden-print">
      <li class="active">
          <a href="#checkouthistory" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-info-circle fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.checkout_history') }}</span>
          </a>
        </li>


        <li>
          <a href="#replenishhistory" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.replenish_history') }}
              
            </span>
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="checkouthistory">
          <div class="tab-pane" id="checkouthistory">
            
         
          <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table table-responsive table-striped">
                      <h2 class="box-title"> Check Out History</h2>
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
                  </div> 
                </div>
              </div> 
          </div>    
          </div> <!-- .col-md-9--> <!--tabl pane-->
          <div class="tab-pane"  id="replenishhistory">   
            <!-- Replenishment list -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table table-responsive">
                  <h2 class="box-title">{{ trans('general.replenish_history') }}</h2>
                  <table
                          data-cookie-id-table="componentsReplenishmentTable"
                          data-pagination="true"
                          data-id-table="componentsReplenishmentTable"
                          data-search="true"
                          data-side-pagination="server"
                          data-show-columns="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-show-refresh="false"
                          data-sort-order="asc"
                          data-sort-name="name"
                          id="componentsReplenishmentTable"
                          class="table table-striped snipe-table"
                          data-url="{{route('api.components.showReplenishedUsers', $component->id)}}"
                          data-export-options='{
                    "fileName": "export-components-{{ str_slug($component->name) }}-replenish-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                    <thead>
                      <tr>
                        <th data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                        <th data-searchable="false" data-sortable="false" data-field="initial_qty">{{ trans('admin/components/general.initial_qty') }}</th>
                        <th data-searchable="false" data-sortable="false" data-field="total_replenish">{{ trans('admin/components/general.totalreplenish') }}</th>
                        <th data-searchable="false" data-sortable="false" data-field="order_number">{{ trans('general.order_number') }}</th>   
                        <th data-searchable="false" data-sortable="false" data-field="replenish_note">{{ trans('admin/components/general.replenish_note') }}</th>                    
                        <th data-searchable="true" data-sortable="false" data-field="admin">{{ trans('general.admin') }}</th>
                        <th data-searchable="false" data-sortable="false" data-field="file" class="text-center">{{ trans('general.documents') }}</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div> <!-- /.col-md-12-->

            </div> <!-- tab content -->
          </div> <!-- nav tabs custom -->
          </div>
        </div>
      </div> <!-- tab pane -->
    </div>
             
    <div class="tab-pane"  id="replenishhistory">            
     <!-- side address column -->
    <div class="col-md-3">
      <div class="box box-default">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
          @if ($component->image!='')
            <div class="col-md-12 text-center" style="padding-bottom: 15px;">
              <a href="{{ Storage::disk('public')->url('components/'.e($component->image)) }}" data-toggle="lightbox">
                <img src="{{ Storage::disk('public')->url('components/'.e($component->image)) }}" class="img-responsive img-thumbnail" alt="{{ $component->name }}"></a>
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

          {{ Helper::formatCurrencyOutput($component->purchase_cost) }} </div>
          @endif

          @if ($component->order_number)
          <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('general.order_number') }}:</strong>
          {{ $component->order_number }} </div>
          @endif

          @if ($component->notes)

            <div class="col-md-12">
              <strong>
                {{ trans('general.notes') }}
              </strong>
            </div>
            <div class="col-md-12">
              {!! nl2br(e($component->notes)) !!}
            </div>
          </div>
          @endif
            </div>
          </div>
      </div>
    </div>     
  </div>

</div> <!-- .row-->


</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'component' . $component->name . '-export', 'search' => false])
@stop

             
 