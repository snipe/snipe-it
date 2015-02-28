@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.accessories') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/accessory') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@lang('general.accessories')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

        <div class="table-responsive">
		<table id="example">
        <thead>
            <tr role="row">
                <th class="col-md-5" bSortable="true">@lang('admin/accessories/table.title')</th>
                <th class="col-md-2" bSortable="true">@lang('admin/accessories/general.total')</th>
                <th class="col-md-2" bSortable="true">@lang('admin/accessories/general.remaining')</th>
                <th class="col-md-3 actions" bSortable="true">@lang('table.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accessories as $accessory)
            <tr>
                <td><a href="{{ route('view/accessory', $accessory->id) }}">{{{ $accessory->name }}}</a></td>
                <td>{{{ $accessory->qty }}} </td>
                <td>{{{ $accessory->numRemaining() }}} </td>
                <td>
	            <a href="{{ route('checkout/accessory', $accessory->id) }}" class="btn btn-info btn-sm"{{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>@lang('general.checkout')</a>
                <a href="{{ route('update/accessory', $accessory->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a>
<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="{{ route('delete/accessory', $accessory->id) }}" data-content="@lang('admin/accessories/message.delete.confirm')"
data-title="@lang('general.delete') {{{ htmlspecialchars($accessory->name) }}}?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>

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
    <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
    <p>@lang('admin/accessories/general.about_accessories_text') </p>

</div>
</div>
</div>
@stop
