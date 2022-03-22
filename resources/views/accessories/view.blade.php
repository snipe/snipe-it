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


<div class="row">
  <div class="col-md-9">

    <div class="box box-default">
      <div class="box-body">
        <div class="table table-responsive">

            <table
                    data-cookie-id-table="usersTable"
                    data-pagination="true"
                    data-id-table="usersTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
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
        </div>
      </div>
    </div>
  </div>


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
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
