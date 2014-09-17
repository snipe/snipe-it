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
                <li><a href="{{ route('clone/serviceagreement', $serviceagreement->id) }}">@lang('base.serviceagreement_clone')</a></li>
            </ul>
        </div>
       <h3 class="name">@lang('base.serviceagreement') : {{ $serviceagreement->name }}</h3>
    </div>
</div>


   
        <div class="col-md-3 col-xs-12 address pull-right">
 <h6>@lang('base.serviceagreement'):</h6>
            <ul>
                @if ($serviceagreement->contract_number)
                    <li><strong>@lang('admin/serviceagreements/form.contract_number'): </strong> {{ $serviceagreement->contract_number }} </li>
                @endif
                
                @if ($serviceagreement->management_url)
                    <li><strong>@lang('admin/serviceagreements/form.management_url'): </strong> 
                        {{ HTML::link($serviceagreement->management_url,$serviceagreement->management_url, ['target'=>'_new']); }}
                    </li>
                @endif
                
                @if ($serviceagreement->registered_to)
                    <li><strong>@lang('admin/serviceagreements/form.registered_to'): </strong> 
                        {{ $serviceagreement->registered_to }}
                    </li>
                @endif

                @if ($serviceagreement->term_months)
                    <li><strong>@lang('admin/serviceagreements/form.term_months'): </strong> 
                        {{ $serviceagreement->term_months }}
                    </li>
                @endif
                
                @if ($serviceagreement->supplier_id)
                    <li><strong>@lang('base.supplier'): </strong> 
                        {{ $serviceagreement->supplier_id }}
                    </li>
                @endif
                
                @if ($serviceagreement->service_agreement_type_id)
                    <li><strong>@lang('admin/serviceagreements/form.service_agreement_type_id'): </strong> 
                        {{ $serviceagreement->serviceagreementtype->name }}
                    </li>
                @endif
                
                @if ($serviceagreement->purchase_date)
                    <li><strong>@lang('admin/serviceagreements/form.purchase_date'): </strong> 
                        {{ $serviceagreement->purchase_date }}
                    </li>
                @endif
                
                @if ($serviceagreement->purchase_cost)
                    <li><strong>@lang('admin/serviceagreements/form.purchase_cost'): </strong> 
                        {{ $serviceagreement->purchase_cost }}
                    </li>
                @endif
                
                @if ($serviceagreement->notes)
                    <li><strong>@lang('admin/serviceagreements/form.notes'): </strong> 
                        {{ $serviceagreement->notes }}
                    </li>
                @endif
            </ul>       
            
        </div>
        <br>
        <div class="col-md-9 bio">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-license" data-toggle="tab"><strong>@lang('base.licenses')</strong></a></li>
                <li><a href="#tab-asset" data-toggle="tab"><strong>@lang('base.assets')</strong></a></li>
            </ul>
            <div class="tab-content">
                <!-- Hardware tab -->
                <div class="tab-pane active" id="tab-license">
                    @if ($serviceagreement->license()->count() > 0)
                    <hr>
                       <h6 class="name">@lang('base.licenses')</h6>
                       <table id="example">
                           <thead>
                               <tr role="row">
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
                    @else
                     <div class="col-md-9"><br>
                        <div class="alert alert-info alert-block">
                            <i class="icon-info-sign"></i>
                            @lang('general.no_results')
                        </div>
                    </div>
                    @endif
                </div>
             <div class="tab-pane" id="tab-asset">
             
             @if ($serviceagreement->asset()->count() > 0)
            
                <h6 class="name">@lang('base.assets') </h6>
		<table id="example">
                    <thead>
                        <tr role="row">
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
                @else
                 <div class="col-md-9"><br>
                        <div class="alert alert-info alert-block">
                            <i class="icon-info-sign"></i>
                            @lang('general.no_results')
                        </div>
                    </div>
             @endif
         </div>
    </div>

@stop
