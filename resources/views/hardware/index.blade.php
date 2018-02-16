@extends('layouts/default')

@section('title0')

  @if ((Input::get('company_id')) && ($company))
    {{ $company->name }}
  @endif



@if (Input::get('status'))
  @if (Input::get('status')=='Pending')
    {{ trans('general.pending') }}
  @elseif (Input::get('status')=='RTD')
    {{ trans('general.ready_to_deploy') }}
  @elseif (Input::get('status')=='Deployed')
    {{ trans('general.deployed') }}
  @elseif (Input::get('status')=='Undeployable')
    {{ trans('general.undeployable') }}
  @elseif (Input::get('status')=='Deployable')
    {{ trans('general.deployed') }}
  @elseif (Input::get('status')=='Requestable')
    {{ trans('admin/hardware/general.requestable') }}
  @elseif (Input::get('status')=='Archived')
    {{ trans('general.archived') }}
  @elseif (Input::get('status')=='Deleted')
    {{ trans('general.deleted') }}
  @endif
@else
{{ trans('general.all') }}
@endif
{{ trans('general.assets') }}

  @if (Input::has('order_number'))
    : Order #{{ Input::get('order_number') }}
  @endif
@stop

{{-- Page title --}}
@section('title')
@yield('title0')  @parent
@stop

@section('header_right')
  <a href="{{ route('reports/custom') }}" style="margin-right: 5px;" class="btn btn-default">
    Custom Export</a>
  <a href="{{ route('hardware.create') }}" class="btn btn-primary pull-right"></i> {{ trans('general.create') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        {{ Form::open([
          'method' => 'POST',
          'route' => ['hardware/bulkedit'],
          'class' => 'form-inline',
           'id' => 'bulkForm']) }}
          <div class="row">
            <div class="col-md-12">
              @if (Input::get('status')!='Deleted')
              <div id="toolbar">
                <select name="bulk_actions" class="form-control select2">
                  <option value="edit">Edit</option>
                  <option value="delete">Delete</option>
                  <option value="labels">Generate Labels</option>
                </select>
                <button class="btn btn-primary" id="bulkEdit" disabled>Go</button>
              </div>
              @endif

              <table
                data-advanced-search="true"
                data-click-to-select="true"
                data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                data-cookie-id-table="assetsListingTable"
                data-pagination="true"
                data-id-table="assetsListingTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                data-toolbar="#toolbar"
                id="assetsListingTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.assets.index',
                    array('status' => e(Input::get('status')),
                    'order_number'=>e(Input::get('order_number')),
                    'company_id'=>e(Input::get('company_id')),
                    'status_id'=>e(Input::get('status_id')))) }}"
                data-export-options='{
                "fileName": "export{{ (Input::has('status')) ? '-'.str_slug(Input::get('status')) : '' }}-assets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
              </table>

            </div><!-- /.col -->
          </div><!-- /.row -->
        {{ Form::close() }}
      </div><!-- ./box-body -->
    </div><!-- /.box -->
  </div>
</div>
@stop

@section('moar_scripts')
@include('partials.bootstrap-table')

@stop
