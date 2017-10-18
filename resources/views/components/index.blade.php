@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.components') }}
@parent
@stop

@section('header_right')
  @can('create', \App\Models\Component::class)
    <a href="{{ route('components.create') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        {{ Form::open([
             'method' => 'POST',
             'route' => ['component/bulk-form'],
             'class' => 'form-inline' ]) }}

        <div id="toolbar">
        </div>

        <table
          data-toolbar="#toolbar"
          name="components"
          class="table table-striped snipe-table"
          id="table"
          data-url="{{route('api.components.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="componentsTable-{{ config('version.hash_version') }}">
        </table>
        {{ Form::close() }}
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'components-export', 'search' => true, 'showFooter' => true, 'columns' => \App\Presenters\ComponentPresenter::dataTableLayout()])



@stop
