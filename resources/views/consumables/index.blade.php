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

<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
      <div class="box-body">
        <table
          name="consumables"
          class="table table-striped snipe-table"
          id="table"
          data-url="{{route('api.consumables.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="consumablesTable-{{ config('version.hash_version') }}-{{ config('version.hash_version') }}">

            </tr>
          </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->

  </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'consumables-export', 'search' => true,'showFooter' => true, 'columns' => \App\Presenters\ConsumablePresenter::dataTableLayout()])
@stop
