@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.categories') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/category') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('actions.create')</a>
        <h3>@lang('base.categories')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

        <table id="example">
        <thead>
            <tr role="row">
                <th class="col-md-4">@lang('base.category_shortname')</th>
                <th class="col-md-3">@lang('general.count')</th>
                <th class="col-md-1 actions">@lang('actions.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ HTML::linkAction('view/category', $category->name, array($category->id))  }}</td>
                <td>{{ $category->has_models() }}</td>
                <td>
                <a href="{{ route('update/category', $category->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" 
                    class="btn delete-asset btn-danger" 
                    data-toggle="modal" 
                    href="{{ route('delete/category', $category->id) }}" 
                    data-content="@lang('admin/categories/message.delete.confirm')" 
                    data-title="@lang('actions.delete')
                    {{{ htmlspecialchars($category->name) }}}
                    ?" 
                    @if($category->has_models())
                        disabled='disabled'
                    @endif
                    onClick="return false;"><i class="icon-trash icon-white"></i></a> 

                </td>
            </tr>
            @endforeach
        </tbody>
        </table>

    </div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <h4>@lang('base.category_about')</h4>
    <br>
    <p>@lang('admin/categories/message.about') </p>

</div>
</div>
</div>
@stop
