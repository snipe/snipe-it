@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.consumables') }}
@parent
@stop

@section('header_right')
  @can('create', \App\Models\Consumable::class)
  <a href="{{ route('consumables.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop

{{-- Page content --}}
@section('content')

{{ Form::open([
   'method' => 'POST',
   'route' => ['consumables/bulkedit'],
   'class' => 'form-inline',
   'id' => 'bulkForm']) }}
<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <div id="toolbar">
          <label for="bulk_actions"><span class="sr-only">Bulk Actions</span></label>
          <select name="bulk_actions" class="form-control select2" style="width: 150px;" aria-label="bulk_actions">
            <option value="edit">Edit</option>
            <option value="delete">Delete</option>
            <option value="labels">Generate Labels</option>
          </select>
          <button class="btn btn-primary" id="bulkEdit" disabled>Go</button>
        </div>
        
        <table
                data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                data-cookie-id-table="consumablesTable"
                data-pagination="true"
                data-id-table="consumablesTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                data-toolbar="#toolbar"
                id="consumablesTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.consumables.index') }}"
                data-export-options='{
                "fileName": "export-consumables-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
        </table>

      </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
{{ Form::close() }}
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'consumables-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\ConsumablePresenter::dataTableLayout()])
@stop
