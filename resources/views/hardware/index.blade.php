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
  <a href="{{ route('reports.export.assets', ['status'=> e(Input::get('status'))]) }}" style="margin-right: 5px;" class="btn btn-default"><i class="fa fa-download icon-white"></i>
    {{ trans('admin/hardware/table.dl_csv') }}</a>
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
              name="assets"
              {{-- data-row-style="rowStyle" --}}
              data-toolbar="#toolbar"
              class="table table-striped snipe-table"
              id="table"
              data-advanced-search="true"
              data-id-table="advancedTable"
              data-url="{{ route('api.assets.index',
                  array('status' => e(Input::get('status')),
                  'order_number'=>e(Input::get('order_number')),
                  'company_id'=>e(Input::get('company_id')),
                  'status_id'=>e(Input::get('status_id'))))}}"
              data-click-to-select="true"
              data-cookie-id-table="{{ e(Input::get('status')) }}assetTable-{{ config('version.hash_version') }}">
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
@include ('partials.bootstrap-table', [
    'exportFile' => 'assets-export',
    'search' => true,
    'showFooter' => true,
    'columns' => \App\Presenters\AssetPresenter::dataTableLayout()
])

@stop
