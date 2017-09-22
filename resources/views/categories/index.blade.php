@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/categories/general.asset_categories') }}
@parent
@stop


@section('header_right')
<a href="{{ route('categories.create') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
            class="table table-striped snipe-table"
            name="categories"
            id="table"
            data-url="{{route('api.categories.index') }}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="categoriesTable-{{ config('version.hash_version') }}">

          </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table',
      ['exportFile' => 'category-export',
      'search' => true,
      'columns' => \App\Presenters\CategoryPresenter::dataTableLayout()
  ])
@stop

