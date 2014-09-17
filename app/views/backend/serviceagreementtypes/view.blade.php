@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.serviceagreementtype') {{ $serviceagreementtype->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
            <button class="btn gray">@lang('actions.actions')</button>
            <button class="btn glow dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">    
                <li><a href="{{ route('update/serviceagreementtype', $serviceagreementtype->id) }}">@lang('base.serviceagreementtype_update')</a></li>                
            </ul>
        </div>
       <h3 class="name">@lang('base.serviceagreementtype') : {{ $serviceagreementtype->name }}</h3>
    </div>
</div>

<div class="row form-wrapper">
    <div class="col-md-9">


            <div class="col-md-12">

                <h6>[ {{{Lang::get('base.serviceagreement_use')}}} : {{$serviceagreementtype->has_serviceagreements()}} ]</h6>
               
            </div>       
            
        </div>
         <div class="col-md-9 bio">
       
             @if ($serviceagreementtype->serviceagreements()->count() > 0)
		<table id="example">
                    <thead>
                        <tr role="row">
                                    <th class="col-md-4"><span class="line"></span>@lang('general.name')</th>					
				</tr>
			</thead>
			<tbody>
				@foreach ($serviceagreementtype->serviceagreements as $serviceagreement)
				<tr>
					<td>{{ HTML::linkAction('view/serviceagreement', $serviceagreement->name, array($serviceagreement->id)) }} </td>
                                        
				</tr>
				@endforeach
			</tbody>
		</table>
             @endif
         </div>
    <div class="col-md-3 col-xs-12 address pull-right">
    <br />
    @if ($serviceagreementtype->notes)
        <strong>@lang('general.notes'): </strong> {{ $serviceagreementtype->notes }}
        <br>
    @endif
    <br />
    <h4>@lang('base.serviceagreementtype_about')</h4>
    <p>@lang('admin/serviceagreementtypes/message.about') </p>
        
        
</div>       
    </div>

@stop
