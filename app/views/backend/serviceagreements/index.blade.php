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
      
        @if (Input::get('onlyTrashed'))
            <a data-html="false" 
               class="btn delete-asset btn-danger pull-right" 
               data-toggle="modal" 
               href="{{ route('purge/serviceagreements', null) }}" 
               data-content="@choice('message.purge.confirm', $serviceagreements->count())" 
               title="@choice('message.purge.confirm', $serviceagreements->count())"
               data-title="@lang('actions.purge')?" onClick="return false;"><i class="icon-trash icon-white"></i>
               @lang('actions.purge')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/serviceagreements') }}">
                {{ Lang::get('actions.showcurrent')}}</a>
        @else
            <a href="{{ route('create/serviceagreement') }}" title="@lang('actions.create')" class="btn btn-success pull-right">
                <i class="icon-plus-sign icon-white"></i>
                @lang('actions.create')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/serviceagreements?onlyTrashed=true') }}">@lang('actions.showdeleted')</a>
        @endif
        <h3>@lang('base.serviceagreements')</h3>
    </div>
</div>

<div class="row form-wrapper">


<table id="example">
    <thead>
        <tr role="row">
           <th class="col-md-3">@lang('general.name')</th>
           <th class="col-md-2">@lang('admin/serviceagreements/form.contract_number')</th> 
           <th class="col-md-2">@lang('general.purchasedate')</th> 
            <th class="col-md-2">@lang('admin/suppliers/form.hw-sw')</th> 
           <th class="col-md-1 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($serviceagreements as $serviceagreement)
        <tr>
            <td><a href="{{ route('view/serviceagreement', $serviceagreement->id) }}">{{{ $serviceagreement->name }}}</a></td> 
            <td>{{{ $serviceagreement->contract_number }}}</a></td> 
            <td>{{{ $serviceagreement->purchase_date }}}</a></td> 
            <td>{{$serviceagreement->has_assets()}} / {{$serviceagreement->has_licenses()}}</td>
            <td>
                           
            
             @if (is_null($serviceagreement->deleted_at))
              <a href="{{ route('update/serviceagreement', $serviceagreement->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" 
                               
                               class="btn delete-asset btn-danger" 
                               data-toggle="modal" href="{{ route('delete/serviceagreement', $serviceagreement->id) }}" 
                               data-content="@lang('admin/serviceagreements/message.delete.confirm')"
                               data-title="@lang('actions.delete')
                                {{ htmlspecialchars($serviceagreement->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                                       
             @else
                            <a href="{{ route('restore/serviceagreement', $serviceagreement->id) }}" class="btn btn-warning"><i class="icon-share-alt icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/serviceagreement', $serviceagreement->id) }}" data-content="@choice('message.purge.confirm',1)" 
                            data-title="@lang('actions.purge')
                            {{ htmlspecialchars($serviceagreement->name) }}?" onClick="return false;"><i class="icon-remove icon-white"></i></a>
                        @endif
            
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
