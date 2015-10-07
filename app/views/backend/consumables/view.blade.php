@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

 {{{ $consumable->name }}}
 @lang('general.consumable') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>        </div>
        <h3>
            {{{ $consumable->name }}}
 @lang('general.consumable')

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">
        
        @if ($consumable->purchase_date)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>@lang('admin/consumables/general.date'): </strong>
            {{{ $consumable->purchase_date }}} </div>
        @endif

        @if ($consumable->purchase_cost)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>@lang('admin/consumables/general.cost'):</strong>
            {{{ Setting::first()->default_currency }}}

            {{{ number_format($consumable->purchase_cost,2) }}} </div>
        @endif

        @if ($consumable->order_number)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>@lang('admin/consumables/general.order'):</strong>
            {{{ $consumable->order_number }}} </div>
        @endif
        <br />

        <!-- checked out consumables table -->
        @if ($consumable->users->count() > 0)
         {{ Datatable::table()
                ->addColumn(Lang::get('general.user'))
                ->setOptions(
                        array(
                            'sAjaxSource'=>route('api.consumables.view', $consumable->id),
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
                                
                                array('width'=>'auto','targets'=>array(0)),
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
    <h6>@lang('admin/consumables/general.about_consumables_title')</h6>
    <p>@lang('admin/consumables/general.about_consumables_text') </p>

</div>

@stop
