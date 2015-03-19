@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/licenses/general.software_licenses') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/licenses') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> Create New</a>
        <h3>@lang('admin/licenses/general.software_licenses')</h3>
    </div>
</div>

<div class="row form-wrapper">
    {{ Datatable::table()
                ->addColumn(Lang::get('admin/licenses/table.title'), 
                            Lang::get('admin/licenses/table.serial'), 
                            Lang::get('admin/licenses/form.seats'), 
                            Lang::get('admin/licenses/form.remaining_seats'), 
                            Lang::get('admin/licenses/table.purchase_date'), 
                            Lang::get('table.actions'))
                ->setUrl(route('api.licenses.list'))   // this is the route where data will be retrieved
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
                            'colVis'=> array('showAll'=>'Show All','restore'=>'Restore','exclude'=>array(5),'activate'=>'mouseover'),
                            'columnDefs'=> array(
                                array('bSortable'=>false,'targets'=>array(5)),
                                array('width'=>'20%','targets'=>array(5)),
                                ),
                            'order'=>array(array(0,'asc')),
                            'bProcessing'=>true,
                            'oLanguage'=>array(
                                'sProcessing'=>'<i class="fa fa-spinner fa-spin"></i> Loading...',
                                ),
                        )
                    )
                ->render() }}
</div>
@stop
