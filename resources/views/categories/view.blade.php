@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $category->name }}
 {{ ucwords($category_type_route) }}

@parent
@stop

@section('header_right')
<div class="btn-group pull-right">
  <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="{{ route('categories.edit', ['category' => $category->id]) }}">{{ trans('admin/categories/general.edit') }}</a></li>
    <li><a href="{{ route('categories.create') }}">{{ trans('general.create') }}</a></li>
  </ul>
</div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
          name="category_assets"
          class="snipe-table"
          id="table"
          data-url="{{ route('api.'.$category_type_route.'.index',['category_id'=> $category->id]) }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="category{{ $category_type_route }}Table">
      </table>

      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')

  @if ($category->category_type=='asset')
    @include ('partials.bootstrap-table',
    [
      'exportFile' => 'category-' . $category->name . '-export',
      'search' => true,
      'columns' => \App\Presenters\AssetPresenter::dataTableLayout()])
  @elseif ($category->category_type=='accessory')
    @include ('partials.bootstrap-table',
    [
      'exportFile' => 'category-' . $category->name . '-export',
      'search' => true,
      'columns' => \App\Presenters\AccessoryPresenter::dataTableLayout()])
  @elseif ($category->category_type=='consumable')
    @include ('partials.bootstrap-table',
    [
      'exportFile' => 'category-' . $category->name . '-export',
      'search' => true,
      'columns' => \App\Presenters\ConsumablePresenter::dataTableLayout()])
  @elseif ($category->category_type=='component')
    @include ('partials.bootstrap-table',
    [
      'exportFile' => 'category-' . $category->name . '-export',
      'search' => true,
      'columns' => \App\Presenters\ComponentPresenter::dataTableLayout()])
    @endif


@stop
