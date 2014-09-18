@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.license') {{ $license->name }} ::
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
                <li><a href="{{ route('update/license', $license->id) }}">@lang('base.license_update')</a></li>
                <li><a href="{{ route('clone/license', $license->id) }}">@lang('base.license_clone')</a></li>
            </ul>
        </div>
       <h3 class="name">@lang('base.license')
           :
           {{ $license->name }}</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

<div class="col-md-12">
@if ($license->serial)
<div class="col-md-6"><strong>@lang('general.serialnumber'): </strong> {{ $license->serial }} </div>
@endif

@if ($license->license_name)
<div class="col-md-6"><strong>@lang('admin/licenses/form.to_name'): </strong> {{ $license->license_name }} </div>
@endif

@if ($license->license_email)
<div class="col-md-6"><strong>@lang('admin/licenses/form.to_email'): </strong> {{ $license->license_email }} </div>
@endif

@if ($license->notes)
<div class="col-md-6"><strong>@lang('general.notes'): </strong>{{ $license->notes }}</div>
@endif

 @if ($license->depreciation)
            <div class="col-md-6"><strong>@lang('base.depreciation'): </strong>
            {{ $license->depreciation->name }}
                ({{{ $license->depreciation->months }}}
                @lang('general.months')
                )</div>
            <div class="col-md-6"><strong>@lang('admin/hardware/form.depreciates_on'): </strong>
            {{{ $license->depreciated_date() }}} </div>
            <div class="col-md-6"><strong>@lang('admin/hardware/form.fully_depreciated'): </strong>
            {{{ $license->months_until_depreciated()->m }}}
            @lang('general.months')
             @if ($license->months_until_depreciated()->y > 0)
                , {{{ $license->months_until_depreciated()->y }}}
                @lang('general.years')
             @endif
             </div>
        @endif

<br><br><br>
</div>




                <!-- checked out assets table -->
                <h6>@lang('base.licenseseats')
                 ( {{ $license->seats }} )
                </h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-2">@lang('base.licenseseat_shortname')</th>
                             <th class="col-md-2">@lang('base.user')</th>
                             <th class="col-md-4">@lang('base.asset_shortname')</th>
                             <th class="col-md-2">@lang('actions.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $count=1; ?>
                        @if ($license->licenseseats)
                            @foreach ($license->licenseseats as $licensedto)

                            <tr>
                                <td>@lang('base.licenseseats_shortname') :
                                     {{ $count }} </td>
                                <td> 
                                    
                                    @if ($licensedto->asset)
                                        @if ($licensedto->asset->assigned_to != 0)
                                            <a href="{{ route('view/user', $licensedto->asset->assigned_to) }}">
                                                {{ $licensedto->asset->assigneduser->fullName() }}
                                            </a>
                                        @endif
                                    @endif
                                    
                                 
                                </td>
                                <td>
                                @if ($licensedto->asset)
                                    <a href="{{ route('view/hardware', $licensedto->asset_id) }}">
                                	{{ $licensedto->asset->name }} {{ $licensedto->asset->asset_tag }}
                                </a>
                                @endif
                                </td>
                                <td>
                             
                                @if ($licensedto->asset)
                                    <a href="{{ route('checkin/license', $licensedto->id) }}" class="btn btn-primary"> @lang('actions.checkin') </a>
                                @else
                                    <a href="{{ route('checkout/license', $licensedto->id) }}" class="btn btn-info">@lang('actions.checkout')</a>
                                @endif
                                </td>

                            </tr>
                            <?php $count++; ?>
                            @endforeach
                            @endif

                    </tbody>
                </table>
                <br>
                <h6>@lang('general.history')</h6>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-3"><span class="line"></span>@lang('general.date')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('general.admin')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('actions.actions')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('base.user')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('general.notes')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($license->assetlog) > 0)
                        @foreach ($license->assetlog as $log)
                        <tr>
                            <td>{{ $log->added_on }}</td>
                            <td>
                                @if (isset($log->user_id)) {{ $log->adminlog->fullName() }}
                                @endif
                            </td>
                            <td>{{ $log->action_type }}</td>

                            <td>
                                @if ($log->userlog)
                                <a href="{{ route('view/user', $log->checkedout_to) }}">
                                {{ $log->userlog->fullName() }}
                                </a>
                                @endif

                            </td>
                            <td>
                                @if ($log->note) {{ $log->note }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td>{{ $license->created_at }}</td>
                            <td>
                            @if ($license->adminuser) {{ $license->adminuser->fullName() }}
                            @else
                            @lang('general.unknown_admin')
                            @endif
                            </td>
                            <td>@lang('actions.created')</td>
                            <td></td>
                            <td>
                            @if ($license->notes)
                            {{ $license->notes }}
                            @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
        <h6><br>@lang('general.moreinfo'):</h6>
                <ul>

                    @if ($license->purchase_date > 0)
                    <li>@lang('general.purchasedate'): {{ $license->purchase_date }} </li>
                    @endif
                    @if ($license->purchase_cost > 0)
                    <li>@lang('general.purchasecost'):
                    @lang('general.currency')
                    {{ number_format($license->purchase_cost,2) }} </li>
                    @endif

                    <!-- // Display the manufacturer -->
                    @if ($license->manufacturer_id)
                    <li>
                        @lang('base.manufacturer')
                        : {{ HTML::linkAction('view/manufacturer', $license->manufacturer->name, array($license->manufacturer->id)) }}</li>
                    @endif
                    
                    <!-- // Display the family -->
                    @if ($license->family_id)
                    <li>
                        @lang('base.family')
                        : {{ HTML::linkAction('view/family', $license->family->name, array($license->family->id)) }}</li>
                    @endif
                    
                    <!-- // Display the supplier -->
                    @if ($license->supplier_id)
                    <li>
                        @lang('base.supplier')
                        : <a href="{{{ route('view/supplier', $license->supplier_id) }}}">
                    {{ $license->supplier->name }} </a></li>
                    @endif
                    
                    @if ($license->order_number)
                    <li>@lang('general.ordernumber'):
                    {{ $license->order_number }} </li>
                    @endif
                    @if (($license->seats) && ($license->seats) > 0)
                    <li>@lang('base.licenseseats_shortname'):
                    {{ $license->seats }} </li>
                    @endif
                    @if ($license->depreciation)
                    <li>@lang('base.depreciation'):
                    {{ $license->depreciation->name }} ({{ $license->depreciation->months }} months)</li>
                    @endif
                    @if ($license->notes)
                        <li>{{ $license->notes }}</li>
                    @endif
                </ul>
        </div>
    </div>
</div>
@stop
