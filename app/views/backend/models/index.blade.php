@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/models/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/model') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
        @if(Input::get('status')=='Deleted')
            <a href="{{ URL::to('hardware/models') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  @lang('admin/models/general.view_models')</a>
        @else
            <a href="{{ URL::to('hardware/models?status=Deleted') }}" class="btn btn-default pull-right" style="margin-right:5px;"><i class="fa fa-trash"></i>  @lang('admin/models/general.view_deleted')</a>
        @endif
        <h3>@lang('admin/models/table.title')</h3>
    </div>
</div>

<div class="row form-wrapper">
    {{ Datatable::table()
    ->addColumn(Lang::get('admin/models/table.title'),
        Lang::get('admin/models/table.modelnumber'),
        Lang::get('admin/models/table.numassets'),
        Lang::get('general.depreciation'),
        Lang::get('general.category'),
        Lang::get('general.eol'), 
        Lang::get('table.actions'))
    ->setOptions(
            array(
                'ajax'=> route('api.models.list', Input::get('status')),
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
                'colVis'=> array('showAll'=>'Show All','restore'=>'Restore','exclude'=>array(6),'activate'=>'mouseover'),
                'columnDefs'=> array(array('bSortable'=>false,'targets'=>array(6))),
                'order'=>array(array(0,'asc')),
                'bProcessing'=>true,
                'oLanguage'=>array(
                    'sProcessing'=>'<i class="fa fa-spinner fa-spin"></i> Loading...',
                    ),
            )
        )
    ->render() }}

@stop
