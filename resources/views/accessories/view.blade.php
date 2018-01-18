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
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
              <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
            @if ($accessory->assigned_to != '')
              @can('checkin', \App\Models\Accessory::class)
              <li role="presentation">
                <a href="{{ route('checkin/accessory', $accessory->id) }}">{{ trans('admin/accessories/general.checkin') }}</a>
              </li>
              @endcan
            @else
              @can('checkout', \App\Models\Accessory::class)
              <li role="presentation">
                <a href="{{ route('checkout/accessory', $accessory->id)  }}">{{ trans('admin/accessories/general.checkout') }}</a>
              </li>
              @endcan
            @endif
            @can('update', \App\Models\Accessory::class)
            <li role="presentation">
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
            name="accessory_users"
            class="table table-striped snipe-table"
            id="table"
            data-url="{{ route('api.accessories.checkedout', $accessory->id) }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="accessoryUsersTable"
          >
            <thead>
              <tr>
                <th data-switchable="false" data-searchable="false" data-formatter="usersLinkFormatter" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" data-formatter="accessoriesInOutFormatter">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>


  <!-- side address column -->
  <div class="col-md-3">

    <h4>{{ trans('admin/accessories/general.about_accessories_title') }}</h4>
    <p>{{ trans('admin/accessories/general.about_accessories_text') }} </p>
    <div class="text-center">
      @can('checkout', \App\Models\Accessory::class)
        <a href="{{ route('checkout/accessory', $accessory->id) }}" style="margin-right:5px;" class="btn btn-info btn-sm" {{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
      @endcan
    </div>

  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'accessory' . $accessory->name . '-export', 'search' => false])
@stop
