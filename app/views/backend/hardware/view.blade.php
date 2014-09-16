@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.asset') {{ $asset->asset_tag }} ::
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

                @if ($asset->status_id == 3)
                    @if ($asset->assigned_to != 0)
                        <li><a href="{{ route('checkin/hardware', $asset->id) }}">@lang('actions.checkin')</a></li>
                    @endif
                @elseif ($asset->status_id == 2)
                        <li><a href="{{ route('checkout/hardware', $asset->id) }}">@lang('actions.checkout')</a></li>
                @endif
                <li><a href="{{ route('update/hardware', $asset->id) }}">@lang('base.asset_update')</a></li>
                <li><a href="{{ route('clone/hardware', $asset->id) }}">@lang('base.asset_clone')</a></li>
            </ul>
        </div>
        <h3>
        <h3 class="name">
        @lang('base.assets') : 
        {{{ $asset->asset_tag }}}
        @if ($asset->name)
        ({{{ $asset->name }}})
        @endif
    </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

    <div class="col-md-12" style="min-height: 130px;">

        <!-- Information column 1 -->
        <div class='col-md-6'>
        @if ($asset->model->manufacturer)
            <strong>@lang('base.manufacturer'): </strong>
            <a href="{{ route('view/manufacturer', $asset->model->manufacturer->id) }}">
            {{{ $asset->model->manufacturer->name }}}
            </a> <br>
            <strong>@lang('base.model'):</strong>
            <a href="{{ route('view/model', $asset->model->id) }}">
            {{{ $asset->model->name }}}
            </a>
             / 
         @endif 
         {{{ $asset->model->modelno }}} <br>
         
        <strong>@lang('base.category'): </strong>
            {{ $asset->model->category->name }} 

            @if ($asset->model->eol)
                <strong>@lang('admin/hardware/form.eol_rate'): </strong>
                {{{ $asset->model->eol }}}
                @lang('admin/hardware/form.months') <br>
                <strong>@lang('admin/hardware/form.eol_date'): </strong>
                {{{ $asset->eol_date() }}} <br.
                @if ($asset->months_until_eol())
                     (
                     @if ($asset->months_until_eol()->y > 0) {{{ $asset->months_until_eol()->y }}}
                      @lang('general.years'),
                     @endif

                    {{{ $asset->months_until_eol()->m }}}
                    @lang('general.months')
                    ) <br>
                @endif
            @endif
            
        </div>       
        
        <!-- Information column 2 -->
        <div class='col-md-6'>

            @if ($asset->purchase_date)
                <strong>@lang('general.purchasedate'): </strong>
                {{{ $asset->purchase_date }}} <br>
            @endif
            
            @if ($asset->order_number)
                <strong>@lang('admin/hardware/form.order'):</strong>
                {{{ $asset->order_number }}} <br>
            @endif
            
            @if ($asset->supplier_id)
                <strong>@lang('base.supplier'): </strong>
                <a href="{{ route('view/supplier', $asset->supplier_id) }}">
                {{{ $asset->supplier->name }}} <br>
                </a>
            @endif
            
            @if ($asset->purchase_cost)
                <strong>@lang('general.purchasecost'):</strong>
                @lang('general.currency')
                {{{ number_format($asset->purchase_cost,2) }}} <br>
            @endif

            @if ($asset->warranty_months)
                <strong>@lang('admin/hardware/form.warranty'):</strong>
                {{{ $asset->warranty_months }}}
                @lang('admin/hardware/form.months') <br>
                
                <div class="{{{ $asset->warrantee_expires() < date("Y-m-d H:i:s") ? 'ui-state-highlight' : '' }}}" ><strong>@lang('admin/hardware/form.warrantee_expires'):</strong>
                {{{ $asset->warrantee_expires() }}}</div> <br>
            @endif

            @if ($asset->depreciation)
                <strong>@lang('base.depreciation'): </strong>
                {{ $asset->depreciation->name }}
                    ({{{ $asset->depreciation->months }}}
                    @lang('general.months')
                    ) <br>
                <strong>@lang('admin/hardware/form.depreciates_on'): </strong>
                {{{ $asset->depreciated_date() }}} <br>
                <strong>@lang('admin/hardware/form.fully_depreciated'): </strong>
                {{{ $asset->months_until_depreciated()->m }}}
                @lang('general.months')
                 @if ($asset->months_until_depreciated()->y > 0)
                    , {{{ $asset->months_until_depreciated()->y }}}
                    @lang('general.years')
                 @endif
                 <br>
            @endif
            
        </div>



    </div>

		<!-- Licenses assets table -->

        <h6>Software Assigned to {{{ $asset->name }}}</h6>
		<br>
		<!-- checked out assets table -->
		@if (count($asset->licenses) > 0)
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-4"><span class="line"></span>@lang('general.name')</th>
					<th class="col-md-1"><span class="line"></span>@lang('actions.actions')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($asset->licenseseats as $seat)
				<tr>
					<td><a href="{{ route('view/license', $seat->license->id) }}">{{{ $seat->license->name }}}</a></td>
					<td><a href="{{ route('checkin/license', $seat->id) }}" class="btn btn-primary">@lang('actions.checkin')</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else

		<div class="col-md-12">
			<div class="alert alert-info alert-block">
				<i class="icon-info-sign"></i>
				@lang('general.no_results')
			</div>
		</div>
		@endif

        <!-- checked out assets table -->

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-md-3"><span class="line"></span>@lang('general.date')</th>
                    <th class="col-md-2"><span class="line"></span>@lang('general.admin')</th>
                    <th class="col-md-2"><span class="line"></span>@lang('actions.actions')</th>
                    <th class="col-md-2"><span class="line"></span>@lang('base.user')</th>                   
                    <th class="col-md-3"><span class="line"></span>@lang('general.notes')</th>
                </tr>
            </thead>
            <tbody>
            @if (count($asset->assetlog) > 0)
                @foreach ($asset->assetlog as $log)
                <tr>
                    <td>{{{ $log->added_on }}}</td>
                    <td>
                        @if (isset($log->user_id)) {{{ $log->adminlog->fullName() }}}
                        @endif
                    </td>
                    <td>{{ $log->action_type }}</td>
                    <td>
                        @if ($log->checkedout_to)
                        <a href="{{ route('view/user', $log->checkedout_to) }}">
                        {{{ $log->userlog->fullName() }}}
                        </a>
                        @endif
                    </td>
                    <td></td>
                    <td>
                        @if ($log->note) {{{ $log->note }}}
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <td>{{ $asset->created_at }}</td>
                    <td>
                    @if ($asset->adminuser->id) {{{ $asset->adminuser->fullName() }}}
                    @else
                    @lang('general.unknown_admin')
                    @endif
                    </td>
                    <td>@lang('actions.created')</td>
                    
                    <td>
                    @if ($asset->notes)
                    {{{ $asset->notes }}}
                    @endif
                    </td>
                </tr>
            </tbody>
        </table>


        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">

            @if ($qr_code->display)
            <h6>@lang('admin/hardware/form.qr')</h6>
            <p>
                <img src="{{{ $qr_code->url }}}" />
            </p>
            @endif
             <h6>@lang('base.statuslabel'): {{ $asset->assetstatus->name }}</h6>
             <h6>@lang('base.location'): {{ $asset->location->name }}</h6>
            <ul>                
                 <li>{{ $asset->state->getCheckoutButton() }}</li>
             </ul>
            @if ((isset($asset->assigned_to ) && ($asset->assigned_to > 0)))
                <h6><br>@lang('admin/hardware/form.checkedout_to')</h6>
                <ul>

                    <li><img src="{{{ $asset->assigneduser->gravatar() }}}" class="img-circle" style="width: 100px; margin-right: 20px;" /><br /><br /></li>
                    <li><a href="{{ route('view/user', $asset->assigned_to) }}">{{ $asset->assigneduser->fullName() }}</a></li>

                    @if (isset($asset->assigneduser->email))
                        <li><br /><i class="icon-envelope-alt"></i> <a href="mailto:{{{ $asset->assigneduser->email }}}">{{{ $asset->assigneduser->email }}}</a></li>
                    @endif

                    @if ((isset($asset->assigneduser->phone)) && ($asset->assigneduser->phone!=''))
                        <li><i class="icon-phone"></i> {{{ $asset->assigneduser->phone }}}</li>
                    @endif

                   
                    </ul>
            
            @endif
             
        </div>
    </div>
</div>
@stop
