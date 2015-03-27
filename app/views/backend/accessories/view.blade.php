@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $accessory->name }}}
 @lang('general.accessory') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>        </div>
        <h3>
            {{{ $accessory->name }}}
 @lang('general.accessory')

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">


                            <!-- checked out accessories table -->
                            @if ($accessory->users->count() > 0)
                             {{ Datatable::table()
                ->addColumn(Lang::get('general.user'), 
                            Lang::get('table.actions'))
                ->setOptions(
                        array(
                            'sAjaxSource'=>route('api.accessories.view', $accessory->id),
                            'dom' =>'T<"clear">lfrtip',
                            'tableTools' => array(
                                'sSwfPath'=> Config::get('app.url').'/assets/swf/copy_csv_xls_pdf.swf',
                                'aButtons'=>array(
                                    array(
                                        'sExtends'=>'copy',
                                    ),
                                    'print',
                                    array(
                                        'sExtends'=>'collection',
                                        'sButtonText'=>'Export',
                                        'aButtons'=>array(
                                            array(
                                                'sExtends'=>'csv',
                                            ),
                                            array(
                                                'sExtends'=>'xls',
                                            ),
                                            array(
                                                'sExtends'=>'pdf',
                                            ),
                                        ),
                                    ),
                                ) 
                            ),
                            'columnDefs'=> array(
                                array('bSortable'=>false,'targets'=>array(1)),
                                array('width'=>'auto','targets'=>array(1)),
                                ),
                            'order'=>array(array(0,'asc')),
                        )
                    )
                ->render() }}

                            @else
                            <div class="col-md-9">
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif

                        </div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br /><br />
    <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
    <p>@lang('admin/accessories/general.about_accessories_text') </p>

</div>

@stop
