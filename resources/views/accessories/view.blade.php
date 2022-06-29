@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $accessory->name }}
 {{ trans('general.accessory') }}
 @if ($accessory->model_number!='')
     ({{ $accessory->model_number }})
 @endif

@parent
@stop

{{-- Right header --}}
@section('header_right')
    @can('manage', \App\Models\Accessory::class)
        <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              {{ trans('button.actions') }}
              <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            @if ($accessory->assigned_to != '')
              @can('checkin', \App\Models\Accessory::class)
              <li role="menuitem">
                <a href="{{ route('checkin/accessory', $accessory->id) }}">{{ trans('admin/accessories/general.checkin') }}</a>
              </li>
              @endcan
            @else
              @can('checkout', \App\Models\Accessory::class)
              <li role="menuitem">
                <a href="{{ route('checkout/accessory', $accessory->id)  }}">{{ trans('admin/accessories/general.checkout') }}</a>
              </li>
              @endcan
            @endif
            @can('update', \App\Models\Accessory::class)
            <li role="menuitem">
              <a href="{{ route('accessories.edit', $accessory->id) }}">{{ trans('admin/accessories/general.edit') }}</a>
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
                    data-cookie-id-table="usersTable"
                    data-pagination="true"
                    data-id-table="usersTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-fullscreen="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="usersTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.accessories.checkedout', $accessory->id) }}"
                    data-export-options='{
                    "fileName": "export-accessories-{{ str_slug($accessory->name) }}-users-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                <thead>
                    <tr>
                    <th data-searchable="false" data-formatter="usersLinkFormatter" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="checkout_notes">{{ trans('general.notes') }}</th>
                    <th data-searchable="false" data-formatter="dateDisplayFormatter" data-sortable="false" data-field="last_checkout">{{ trans('admin/hardware/table.checkout_date') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="actions" data-formatter="accessoriesInOutFormatter">{{ trans('table.actions') }}</th>
                    </tr>
                </thead>

                </table>
            </div><!--col-md-9-->




<!-- side address column -->

<div class="col-md-3">

      @if ($accessory->image!='')
          <div class="row">
              <div class="col-md-12 text-center" style="padding-bottom: 15px;">
                  <a href="{{ Storage::disk('public')->url('accessories/'.e($accessory->image)) }}" data-toggle="lightbox"><img src="{{ Storage::disk('public')->url('accessories/'.e($accessory->image)) }}" class="img-responsive img-thumbnail" alt="{{ $accessory->name }}"></a>
              </div>
          </div>
      @endif

      @if ($accessory->company)
          <div class="row">
              <div class="col-md-4" style="padding-bottom: 15px;">
                  {{ trans('general.company')}}
              </div>
              <div class="col-md-8">
                  <a href="{{ route('companies.show', $accessory->company->id) }}">{{ $accessory->company->name }} </a>
              </div>
          </div>
      @endif


      @if ($accessory->category)
          <div class="row">
              <div class="col-md-4" style="padding-bottom: 15px;">
                  {{ trans('general.category')}}
              </div>
              <div class="col-md-8">
                  <a href="{{ route('categories.show', $accessory->category->id) }}">{{ $accessory->category->name }} </a>
              </div>
          </div>
      @endif


      @if ($accessory->notes)

          <div class="col-md-12">
              <strong>
                  {{ trans('general.notes') }}
              </strong>
          </div>
          <div class="col-md-12">
              {!! nl2br(e($accessory->notes)) !!}
          </div>

     @endif


      <div class="row">
          <div class="col-md-4" style="padding-bottom: 15px;">
              Number remaining
          </div>
          <div class="col-md-8">
              {{ $accessory->numRemaining() }}
          </div>
      </div>



          @can('checkout', \App\Models\Accessory::class)
              <div class="row">
                  <div class="col-md-12 text-center">
                      <a href="{{ route('checkout/accessory', $accessory->id) }}" style="margin-right:5px;" class="btn btn-primary btn-sm" {{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
                  </div>
              </div>
          @endcan

                    </div><!--col-md-3-->
                </div><!--row-->
            </div><!--tab-pane details-->

        <div class="tab-pane fade" id="history">
            <div class="row">
                <div class="col-md-12">
                    <table
                            class="table table-striped snipe-table"
                            data-cookie-id-table="AccessoryHistoryTable"
                            data-id-table="AccessoryHistoryTable"
                            id="AccessoryHistoryTable"
                            data-pagination="true"
                            data-show-columns="true"
                            data-side-pagination="server"
                            data-show-refresh="true"
                            data-show-export="true"
                            data-sort-order="desc"
                            data-export-options='{
                       "fileName": "export-{{ str_slug($accessory->name) }}-history-{{ date('Y-m-d') }}",
                       "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                     }'
                            data-url="{{ route('api.activity.index', ['item_id' => $accessory->id, 'item_type' => 'accessory']) }}">

                        <thead>
                        <tr>
                            <th class="col-sm-2" data-visible="false" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.record_created') }}</th>
                            <th class="col-sm-2"data-visible="true" data-sortable="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                            <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                            <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                            <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                            <th class="col-sm-2" data-sortable="true" data-visible="true" data-field="note">{{ trans('general.notes') }}</th>
                            <th class="col-sm-2" data-visible="true" data-field="action_date" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                            @if  ($snipeSettings->require_accept_signature=='1')
                                <th class="col-md-3" data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">{{ trans('general.signature') }}</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div> <!-- /.col-md-12-->
            </div> <!-- /.row-->
        </div><!--tab history-->
    </div><!--tab-content-->
</div><!--/.nav-tabs-custom-->
@stop










@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
