@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/categories/general.asset_categories') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/category') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@lang('admin/categories/general.asset_categories')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

        <div class="table-responsive">
		<table id="example">
        <thead>
            <tr role="row">
                <th class="col-md-5" bSortable="true">@lang('admin/categories/table.title')</th>
                <th class="col-md-2" bSortable="true">@lang('general.type')</th>
                 <th class="col-md-2" bSortable="true">@lang('general.assets')</th>
                 <th class="col-md-3" bSortable="true">@lang('admin/categories/table.require_acceptance')</th>
                 <th class="col-md-2" bSortable="true">@lang('admin/categories/table.eula_text')</th>
                <th class="col-md-2 actions" bSortable="true">@lang('table.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{{ $category->name }}}</td>
                <td>{{{ ucwords($category->category_type) }}}</td>
                <td>
	                @if ($category->category_type=='asset')
	               		<a href="{{ route('view/category',$category->id) }}">{{ $category->assetscount() }}</a>
	                @elseif ($category->category_type=='accessory')
	                	{{ $category->accessoriescount() }}
	                @endif
	            </td>
                <td>{{ ($category->require_acceptance=='1') ? '<i class="fa fa-check"></i>' : ''}}</td>
                <td>{{ ($category->eula_text!='') ? '<i class="fa fa-check"></i>' : ''}}</td>
                <td>
                <a href="{{ route('update/category', $category->id) }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i></a>
<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/category', $category->id) }}" data-content="@lang('admin/categories/message.delete.confirm')"
data-title="@lang('general.delete')
{{{ htmlspecialchars($category->name) }}}?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>

                </td>
            </tr>
            @endforeach
        </tbody>
        </table>


    </div>
    </div>


<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br /><br />
    <h6>@lang('admin/categories/general.about_asset_categories')</h6>
    <p>@lang('admin/categories/general.about_categories') </p>

</div>
</div>
</div>
@stop
