@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.accessory') }}:
 {{ $accessory->name }}

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
                data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableCheckoutsLayout() }}"
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
            </table>
        </div>
      </div>
    </div>
  </div>


  <!-- side address column -->
  <div class="col-md-3">

    <div class="text-center">
        @can('checkout', \App\Models\Accessory::class)
            <a href="{{ route('checkout/accessory', $accessory->id) }}" style="margin-right:5px;" class="btn btn-info btn-sm" {{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
        @endcan
    </div>
    <br />

    @if ($accessory->image!='')
        <div class="col-md-12 text-center" style="padding-bottom: 15px;">
            <a href="{{ app('accessories_upload_url') }}{{ $accessory->image }}" data-toggle="lightbox"><img src="{{ app('accessories_upload_url') }}{{ $accessory->image }}" class="img-responsive img-thumbnail" alt="{{ $accessory->name }}"></a>
        </div>
    @endif



    <div class="col-md-12">
        <ul class="list-unstyled" style="line-height: 25px; padding-bottom: 20px;">
            @if ($accessory->model_number!='')
            <li>
                <strong>{{ trans('general.model_no') }}: </strong>
                {{ $accessory->model_number }}
            </li>
            @endif

            @if ($accessory->company)
            <li>
                <strong>{{ trans('general.company') }}: </strong>
                <a href="{{ route('companies.show', $accessory->company->id) }}">{{ $accessory->company->name }}</a>
            </li>
            @endif
            
            @if ($accessory->department)
            <li>
                <strong>{{ trans('general.department') }}: </strong>
                <a href="{{ route('departments.show', $accessory->department->id) }}">{{ $accessory->department->name }}</a>
            </li>
            @endif

            @if ($accessory->category)
            <li>
                <strong>{{ trans('general.category') }}: </strong>
                @can('view', \App\Models\Category::class)
                  <a href="{{ route('categories.show', $accessory->category->id) }}">{{ $accessory->category->name }}</a>
                @else
                  {{ $accessory->category->name }}
                @endcan
            </li>
            @endif

            @if ($accessory->location)
            <li><strong>{{ trans('general.location') }}: </strong>
                @can('superuser')
                    <a href="{{ route('locations.show', ['location' => $accessory->location->id]) }}">
                    {{ $accessory->location->name }}
                    </a>
                @else
                    {{ $accessory->location->name }}
                @endcan
            </li>
            @endif

            <br />
            <li>
                <strong>{{ trans('admin/accessories/general.total') }}: </strong>
                {{ $accessory->qty }}
            </li>
            <li>
                <strong>{{ trans('general.checkouts_count') }}: </strong>
                {{ $accessory->qty - $accessory->numRemaining() }}
            </li>
            <li>
                <strong>{{ trans('admin/accessories/general.remaining') }}: </strong>
                {{ $accessory->numRemaining() }}
            </li>
            <li>
                <strong>{{ trans('general.min_amt') }}: </strong>
                {{ $accessory->min_amt }}
            </li>


            @if ($accessory->supplier)
            <br />
            <li>
                <strong>{{ trans('general.supplier') }}</strong>
                <br />
                {{ $accessory->supplier->name }}
                <br />
                
                @if (($accessory->supplier->url))
                    <i class="fa fa-globe"></i> <a href="{{ $accessory->supplier->url }}">{{ $accessory->supplier->url }}</a>
                    <br />
                @endif

                @if (($accessory->supplier->contact))
                    <i class="fa fa-user"></i> <a href="{{ $accessory->supplier->contact }}">{{ $accessory->supplier->contact }}</a>
                    <br />
                @endif

                @if (($accessory->supplier->phone))
                    <i class="fa fa-phone"></i><a href="tel:{{ $accessory->supplier->phone }}">{{ $accessory->supplier->phone }}</a>
                    <br />
                @endif

                @if (($accessory->supplier->email))
                    <i class="fa fa-envelope"></i> <a href="mailto:{{ $accessory->supplier->email }}">{{ $accessory->supplier->email }}</a>
                    <br />
                @endif
            </li>
            @endif

            @if ($accessory->manufacturer)
            <br />
            <li>
                <strong>{{ trans('general.manufacturer') }}</strong>
                <br />
                {{ $accessory->manufacturer->name }}
                <br />
                @if (($accessory->manufacturer->url))
                    <i class="fa fa-globe"></i> <a href="{{ $accessory->manufacturer->url }}">{{ $accessory->manufacturer->url }}</a>
                    <br />
                @endif

                @if (($accessory->manufacturer->support_url))
                    <i class="fa fa-life-ring"></i> <a href="{{ $accessory->manufacturer->support_url }}">{{ $accessory->manufacturer->support_url }}</a>
                    <br />
                @endif

                @if (($accessory->manufacturer->support_phone))
                    <i class="fa fa-phone"></i><a href="tel:{{ $accessory->manufacturer->support_phone }}">{{ $accessory->manufacturer->support_phone }}</a>
                    <br />
                @endif

                @if (($accessory->manufacturer->support_email))
                    <i class="fa fa-envelope"></i> <a href="mailto:{{ $accessory->manufacturer->support_email }}">{{ $accessory->manufacturer->support_email }}</a>
                    <br />
                @endif
                </li>
            @endif








        </ul>
    </div>


    <h4>{{ trans('admin/accessories/general.about_accessories_title') }}</h4>
    <p>{{ trans('admin/accessories/general.about_accessories_text') }} </p>


  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
