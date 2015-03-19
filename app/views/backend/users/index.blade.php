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
	    Lang::get('admin/users/table.email'), 
	    Lang::get('admin/users/table.manager'),
	    Lang::get('general.assets'), 
	    Lang::get('general.licenses'), 
	    Lang::get('admin/users/table.activated'), 
	    Lang::get('table.actions')
    )  
    ->setUrl(route('api.users.list', Input::get('status')))   // this is the route where data will be retrieved
    ->setOptions(
            array(
                'deferRender'=> true,
                'stateSave'=> true,
                'stateDuration'=> -1,
                'dom' =>'CT<"clear">lfrtip',
                'tableTools' => array(
                    'sSwfPath'=> Config::get('app.url').'/assets/swf/copy_csv_xls_pdf.swf',
                    'aButtons'=>array(
                        'copy',
                        'print',
                        array(
                            'sExtends'=>'collection',
                            'sButtonText'=>'Export',
                            'aButtons'=>array(
                                'csv',
                                'xls',
                                'pdf'
                                )
                            )
                        ) 
                    ),
                'colVis'=> array('showAll'=>'Show All','restore'=>'Restore','activate'=>'mouseover'),
                'columnDefs'=> array(array('visible'=>false,'targets'=>array()),array('bSortable'=>false,'targets'=>array(6))),
		'order'=>array(array(1,'asc')),
		'bProcessing'=>true,
                'oLanguage'=>array(
                    'sProcessing'=>'<i class="fa fa-spinner fa-spin"></i> Loading...'
                    ),
            )
        )
    ->render() }}


</div>
</div>


@stop
