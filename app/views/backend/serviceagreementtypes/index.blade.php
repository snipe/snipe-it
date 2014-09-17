@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.serviceagreementtypes') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/serviceagreementtype') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
       <h3>@lang('base.serviceagreementtypes')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
    <div class="col-md-9 bio">
        <table id="example">
            <thead>
                <tr role="row">
                   <th class="col-md-3">@lang('general.name')</th>          
                   <th class="col-md-1 actions">@lang('actions.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($serviceagreementtypes as $serviceagreementtype)
                <tr>
                    <td><a href="{{ route('view/serviceagreementtype', $serviceagreementtype->id) }}">{{{ $serviceagreementtype->name }}}</a></td> 

                    <td>
                                    <a href="{{ route('update/serviceagreementtype', $serviceagreementtype->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                                    <a data-html="false" 

                                       class="btn delete-asset btn-danger" 
                                       data-toggle="modal" href="{{ route('delete/serviceagreementtype', $serviceagreementtype->id) }}" 
                                       data-content="@lang('admin/serviceagreementtypes/message.delete.confirm')"
                                       data-title="@lang('actions.delete')
                                        {{ htmlspecialchars($serviceagreementtype->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

    <!-- side address column -->
    <div class="col-md-3 col-xs-12 address pull-right">
    <br />
    <h4>@lang('base.serviceagreementtype_about')</h4>
    <p>@lang('admin/serviceagreementtypes/message.about') </p>
        
        
</div>
</div>
</div>

@stop
