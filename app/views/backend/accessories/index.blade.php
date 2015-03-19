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
            {{ Datatable::table()
                ->addColumn(Lang::get('admin/accessories/table.title'), 
                            Lang::get('admin/accessories/general.total'), 
                            Lang::get('admin/accessories/general.remaining'), 
                            Lang::get('table.actions'))
                ->setUrl(route('api.accessories.list'))   // this is the route where data will be retrieved
                ->setOptions(
                        array(
                            'deferRender'=> true,
                            'stateSave'=> true,
                            'stateDuration'=> -1,
                            'dom' =>'T<"clear">lfrtip',
                            'tableTools' => array(
                                'sSwfPath'=> Config::get('app.url').'/assets/swf/copy_csv_xls_pdf.swf',
                                'aButtons'=>array(
                                    array(
                                        'sExtends'=>'copy',
                                        'mColumns'=> array(0,1,2),
                                    ),
                                    'print',
                                    array(
                                        'sExtends'=>'collection',
                                        'sButtonText'=>'Export',
                                        'aButtons'=>array(
                                            array(
                                                'sExtends'=>'csv',
                                                'mColumns'=> array(0,1,2),
                                            ),
                                            array(
                                                'sExtends'=>'xls',
                                                'mColumns'=> array(0,1,2),
                                            ),
                                            array(
                                                'sExtends'=>'pdf',
                                                'mColumns'=> array(0,1,2),
                                            ),
                                        ),
                                    ),
                                ) 
                            ),
                            'columnDefs'=> array(
                                array('bSortable'=>false,'targets'=>array(3)),
                                array('width'=>'20%','targets'=>array(3)),
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


        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br /><br />
            <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
            <p>@lang('admin/accessories/general.about_accessories_text') </p>

        </div>
    </div>
</div>
@stop
