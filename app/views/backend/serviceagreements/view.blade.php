@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.serviceagreement') {{ $serviceagreement->name }} ::
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
                <li><a href="{{ route('update/serviceagreement', $serviceagreement->id) }}">@lang('base.serviceagreement_update')</a></li>                
            </ul>
        </div>
       <h3 class="name">@lang('base.serviceagreement') : {{ $serviceagreement->name }}</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

            <div class="col-md-12">
                @if ($serviceagreement->contract_number)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.contract_number'): </strong> {{ $serviceagreement->contract_number }} </div>
                @endif
                
                @if ($serviceagreement->management_url)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.management_url'): </strong> 
                        {{ HTML::link($serviceagreement->management_url,$serviceagreement->management_url, ['target'=>'_new']); }}
                    </div>
                @endif
                
                @if ($serviceagreement->registered_to)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.registered_to'): </strong> 
                        {{ $serviceagreement->registered_to }}
                    </div>
                @endif

                @if ($serviceagreement->term_months)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.term_months'): </strong> 
                        {{ $serviceagreement->term_months }}
                    </div>
                @endif
                
                @if ($serviceagreement->supplier_id)
                    <div class="col-md-6"><strong>@lang('base.supplier'): </strong> 
                        {{ $serviceagreement->supplier_id }}
                    </div>
                @endif
                
                @if ($serviceagreement->service_agreement_type_id)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.service_agreement_type_id'): </strong> 
                        {{ $serviceagreement->serviceagreementtype->name }}
                    </div>
                @endif
                
                @if ($serviceagreement->purchase_date)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.purchase_date'): </strong> 
                        {{ $serviceagreement->purchase_date }}
                    </div>
                @endif
                
                @if ($serviceagreement->purchase_cost)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.purchase_cost'): </strong> 
                        {{ $serviceagreement->purchase_cost }}
                    </div>
                @endif
                
                @if ($serviceagreement->notes)
                    <div class="col-md-6"><strong>@lang('admin/serviceagreements/form.notes'): </strong> 
                        {{ $serviceagreement->notes }}
                    </div>
                @endif
            </div>       
            
        </div>
        
        <div class="col-md-9 bio">
            
             @if ($serviceagreement->license()->count() > 0)
             <hr>
                <h6 class="name">@lang('base.licenses')</h6>
		<table class="table table-hover">
			<thead>
				<tr>
                                    <th class="col-md-4"><span class="line"></span>@lang('general.name')</th>					
				</tr>
			</thead>
			<tbody>
				@foreach ($serviceagreement->license as $license)
				<tr>
					<td>{{ HTML::linkAction('view/license', $license->name, array($license->id)) }} </td>
				</tr>
				@endforeach
			</tbody>
		</table>
             @endif
             
             
             @if ($serviceagreement->asset()->count() > 0)
             <hr>
                <h6 class="name">@lang('base.assets') </h6>
		<table class="table table-hover">
			<thead>
				<tr>
                                    <th class="col-md-4"><span class="line"></span>@lang('general.name')</th>					
				</tr>
			</thead>
			<tbody>
				@foreach ($serviceagreement->asset as $asset)
				<tr>
					<td>{{ HTML::linkAction('view/hardware', $asset->name, array($asset->id)) }} </td>
				</tr>
				@endforeach
			</tbody>
		</table>
             @endif
         </div>
    </div>
</div>
@stop
