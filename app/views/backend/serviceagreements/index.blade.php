@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.serviceagreements') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/serviceagreement') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
       <h3>@lang('base.serviceagreements')</h3>
    </div>
</div>

<div class="row form-wrapper">
<table id="example">
    <thead>
        <tr role="row">
           <th class="col-md-3">@lang('general.name')</th>
           <th class="col-md-3">@lang('admin/serviceagreements/form.contract_number')</th> 
           <th class="col-md-3">@lang('general.purchasedate')</th> 
           <th class="col-md-1 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($serviceagreements as $serviceagreement)
        <tr>
            <td><a href="{{ route('view/serviceagreement', $serviceagreement->id) }}">{{{ $serviceagreement->name }}}</a></td> 
            <td>{{{ $serviceagreement->contract_number }}}</a></td> 
            <td>{{{ $serviceagreement->purchase_date }}}</a></td> 
            <td>
                            <a href="{{ route('update/serviceagreement', $serviceagreement->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" 
                               
                               class="btn delete-asset btn-danger" 
                               data-toggle="modal" href="{{ route('delete/serviceagreement', $serviceagreement->id) }}" 
                               data-content="@lang('admin/serviceagreements/message.delete.confirm')"
                               data-title="@lang('actions.delete')
                                {{ htmlspecialchars($serviceagreement->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                        </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
