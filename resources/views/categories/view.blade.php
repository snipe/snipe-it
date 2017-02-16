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
          data-url="{{ route('api.'.$category_type_route.'.index',['category_id'=> $category->id]) }}
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="category{{ $category_type_route }}Table">
          @if ($category->category_type!='asset')
          <thead>
            <tr>
              <th data-searchable="false" data-sortable="false" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="company" data-visible="false" data-formatter="companiesLinkObjFormatter">
                {{ trans('admin/companies/table.title') }}
              </th>
              <th data-searchable="true" data-formatter="{{ $category_type }}LinkFormatter" data-sortable="true" data-field="name">{{ trans('general.name') }}</th>
              <th data-searchable="false" data-sortable="false" data-formatter="{{ $category_type }}ActionsFormatter" data-field="actions"  data-switchable="false">{{ trans('table.actions') }}</th>
            </tr>
          </thead>
        @endif
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
    @else
    @include ('partials.bootstrap-table',
    [
      'exportFile' => 'category-' . $category->name . '-export',
      'search' => false])

    @endif


@stop
