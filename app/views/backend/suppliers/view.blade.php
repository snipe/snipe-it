@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.supplier') -
{{{ $supplier->name }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/supplier', $supplier->id) }}" class="btn btn-warning pull-right">
        @lang('actions.update')</a>
        <h3 class="name">
        @lang('base.supplier') : 
        {{{ $supplier->name }}} </h3>
    </div>
</div>


<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">
        

<!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-hardware" data-toggle="tab"><strong>@lang('general.hardware')</strong></a></li>
    <li><a href="#tab-software" data-toggle="tab"><strong>@lang('general.software')</strong></a></li>
</ul>

<!-- Tabs Content -->
<div class="tab-content">
    
    
    <!-- Hardware tab -->
    <div class="tab-pane active" id="tab-hardware">
            <br>
                            <!-- suppliers hardware asset list table -->
                            @if (count($supplier->assets) > 0)
                           <table id='pgtable1'>
                            <thead>
                                <tr role="row">
                                        <th class="col-md-3">@lang('general.name')</th>
                                        <th class="col-md-3">@lang('general.asset_tag')</th>
                                        <th class="col-md-3">@lang('base.user')</th>
                                        <th class="col-md-2">@lang('actions.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($supplier->assets as $supplierassets)
                                    <tr>
                                        <td><a href="{{ route('view/hardware', $supplierassets->id) }}">{{{ $supplierassets->name }}}</a></td>
                                        <td><a href="{{ route('view/hardware', $supplierassets->id) }}">{{{ $supplierassets->asset_tag }}}</a></td>
                                        <td>
                                        @if ($supplierassets->assigneduser)
                                        <a href="{{ route('view/user', $supplierassets->assigned_to) }}">
                                        {{{ $supplierassets->assigneduser->fullName() }}}
                                        </a>
                                        @endif
                                        </td>
                                        <td>
                                        @if ($supplierassets->assigned_to != 0)
                                            <a href="{{ route('checkin/hardware', $supplierassets->id) }}" class="btn btn-primary">Checkin</a>
                                        @else
                                            <a href="{{ route('checkout/hardware', $supplierassets->id) }}" class="btn btn-info">Checkout</a>
                                        @endif
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                            @else
                            <div class="col-md-10"><br>
                                <div class="alert alert-info alert-block">
                                    <i class="icon-info-sign"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif
        
    <!-- End of Hardware tab -->
    </div>
    
    <!-- Software tab -->
    <div class="tab-pane" id="tab-software">
        <br>
                            <!-- suppliers hardware asset list table -->
                            @if (count($supplier->licenses) > 0)
                           <table id='pgtable2'>
                            <thead>
                                <tr role="row">
                                        <th class="col-md-3">@lang('general.name')</th>
                                        <th class="col-md-3">@lang('general.serialnumber')</th>
                                        <th class="col-md-3">@lang('base.licenseseats_shortname')</th>
                                        <th class="col-md-2">@lang('actions.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($supplier->licenses as $supplierlicenses)
                                    <tr>
                                        <td><a href="{{ route('view/license', $supplierlicenses->id) }}">{{{ $supplierlicenses->name }}}</a></td>
                                        <td> {{{ $supplierlicenses->serial }}}</td>
                                        <td> {{{ $supplierlicenses->seats }}}</td>
                                        <td>
                                            <a href="{{ route('update/license', $supplierlicenses->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $supplierlicenses->id) }}"
                                            data-content="@lang('admin/licenses/message.delete.confirm')"
                                            data-title="@lang('actions.delete')
                                            {{ htmlspecialchars($supplierlicenses->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>   
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                                
                            </table>

                            @else
                            <div class="col-md-10"><br>
                                <div class="alert alert-info alert-block">
                                    <i class="icon-info-sign"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif
        
    <!-- End of Software tab -->
    </div>
    

<!-- End of tab content -->
</div>
                    
</div>

                    <!-- side address column -->
                    <div class="col-md-3 col-xs-12 address pull-right">
                    <h6>@lang('general.contact'):</h6>
                               <ul>

                                @if ($supplier->contact)
                                    <li><i class="icon-user"></i>{{{ $supplier->contact }}}</li>
                                @endif
                                @if ($supplier->phone)
                                    <li><i class="icon-phone"></i>{{{ $supplier->phone }}}</li>
                                @endif
                                @if ($supplier->fax)
                                    <li><i class="icon-print"></i>{{{ $supplier->fax }}}</li>
                                @endif


                                @if ($supplier->email)
                                    <li><i class="icon-envelope-alt"></i><a href="mailto:{{{ $supplier->email }}}">
                                    {{{ $supplier->email }}}
                                    </a></li>
                                @endif

                                @if ($supplier->url)
                                    <li><i class="icon-globe"></i><a href="{{{ $supplier->url }}}" target="_new">{{{ $supplier->url }}}</a></li>
                                @endif

                                @if ($supplier->address)
                                    <li><br>
                                    {{{ $supplier->address }}}

                                    @if ($supplier->address2)
                                        <br>
                                        {{{ $supplier->address2 }}}
                                    @endif
                                    @if (($supplier->city) || ($supplier->state))
                                        <br>
                                        {{{ $supplier->city }}} {{{ $supplier->state }}} {{{ $supplier->zip }}} {{{ $supplier->country }}}
                                    @endif
                                    </li>
                                @endif

                                @if ($supplier->notes)
                                    <li><i class="icon-comment"></i>{{{ $supplier->notes }}}</li>
                                @endif
                            </ul>
                                     
        </div>
                    
</div>
</div>

@stop
