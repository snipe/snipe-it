@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/models/table.title') }}
@parent
@stop

{{-- Page title --}}
@section('header_right')
  @if(Input::get('status')=='Deleted')
      <a href="{{ URL::to('hardware/models') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  {{ trans('admin/models/general.view_models') }}</a>
  @else
      <a href="{{ route('create/model') }}" class="btn btn-primary pull-right">
      {{ trans('general.create') }}</a>
      <a href="{{ URL::to('hardware/models?status=Deleted') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  {{ trans('admin/models/general.view_deleted') }}</a>
  @endif
@stop


{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
        name="models"
        class="table table-striped snipe-table"
        id="table"
        data-url="{{ route('api.models.list',array('status'=>e(Input::get('status')))) }}"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="modelsTable-{{ config('version.hash_version') }}">
          <thead>
            <tr>
              <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
              <th data-sortable="true" data-field="image"  data-visible="false">{{ trans('admin/hardware/table.image') }}</th>
              <th data-sortable="false" data-field="manufacturer">{{ trans('general.manufacturer') }}</th>
              <th data-sortable="true" data-field="name">{{ trans('admin/models/table.title') }}</th>
              <th data-sortable="true" data-field="modelnumber">{{ trans('admin/models/table.modelnumber') }}</th>
              <th data-sortable="false" data-field="numassets">{{ trans('admin/models/table.numassets') }}</th>
              <th data-sortable="false" data-field="depreciation">{{ trans('general.depreciation') }}</th>
              <th data-sortable="false" data-field="category">{{ trans('general.category') }}</th>
              <th data-sortable="true" data-field="eol">{{ trans('general.eol') }}</th>
              <th data-sortable="false" data-field="fieldset">{{ trans('admin/models/general.fieldset') }}</th>
              <th data-sortable="false" data-field="note">{{ trans('general.notes') }}</th>
              <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
            </tr>
          </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->


  </div>
</div>

@stop
@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'models-export', 'search' => true])

@stop
