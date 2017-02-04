@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $category->name }}
 {{ trans('general.assets') }}
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
          data-url="{{ ($category->category_type=='asset') ? route('api.assets.index',['category_id'=> $category->id]) : route('api'.$category->category_type.'index', ['category_id'=> $category->id]) }}
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="categoryAssetsTable">
          <thead>
            <tr>
              <th data-searchable="false" data-sortable="false" data-field="company" data-visible="false">
                  {{ trans('admin/companies/table.title') }}
              </th>
              <th data-searchable="false" data-sortable="false" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.name') }}</th>
              @if ($category->category_type=='asset')
              <th data-searchable="false" data-sortable="false" data-field="model" data-formatter="modelsLinkObjFormatter">{{ trans('admin/hardware/form.model') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="asset_tag" data-formatter="hardwareLinkFormatter">{{ trans('general.asset_tag') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="serial" data-formatter="hardwareLinkFormatter">{{ trans('admin/hardware/form.serial') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="assigned_to" data-formatter="usersLinkFormatter">{{ trans('general.user') }}</th>
              <th data-searchable="false" data-sortable="false" data-field="change"  data-switchable="false">{{ trans('admin/hardware/table.change') }}</th>
              @endif
              <th data-searchable="false" data-sortable="false" data-field="actions"  data-switchable="false">{{ trans('table.actions') }}</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'category-' . $category->name . '-export', 'search' => false])
@stop
