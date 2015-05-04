@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/users/table.viewusers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
	    <a href="{{ route('import/user') }}" class="btn btn-default pull-right"><span class="fa fa-upload"></span> Import</a>
        <a href="{{ route('create/user') }}" class="btn btn-success pull-right" style="margin-right: 5px;"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
         @if (Input::get('status')=='deleted')
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/users') }}" style="margin-right: 5px;">@lang('admin/users/table.show_current')</a>
        @else
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/users?status=deleted') }}" style="margin-right: 5px;">@lang('admin/users/table.show_deleted')</a>
        @endif

        <h3>
        @if (Input::get('status')=='deleted')
            @lang('general.deleted')
        @else
            @lang('general.current')
        @endif
         @lang('general.users')
    </h3>
    </div>
</div>

<div class="row">

{{ Datatable::table()
    ->addColumn(
	    Lang::get('admin/users/table.name'),
	    '<i class="fa fa-envelope fa-lg"></i>',
	    Lang::get('admin/users/table.manager'),
        Lang::get('admin/users/table.location'),
        '<i class="fa fa-barcode fa-lg"></i>',
        '<i class="fa fa-certificate fa-lg"></i>',
        '<i class="fa fa-keyboard-o fa-lg"></i>',
	    Lang::get('general.groups'),
	    Lang::get('table.actions')
    )
    ->setOptions(
            array(
                'sAjaxSource'=>route('api.users.list', Input::get('status')),
                'dom' =>'CT<"clear">lfrtip',
                'colVis'=> array('showAll'=>'Show All','restore'=>'Restore','activate'=>'mouseover'),
                'columnDefs'=> array(array('visible'=>false,'targets'=>array()),array('bSortable'=>false,'targets'=>array(8))),
                'order'=>array(array(1,'asc')),
            )
        )
    ->render() }}


</div>
</div>


@stop
