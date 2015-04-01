@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/suppliers/table.view') -
{{{ $supplier->name }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/supplier', $supplier->id) }}" class="btn-flat white pull-right">
        @lang('admin/suppliers/table.update')</a>
        <h3 class="name">
        @lang('admin/suppliers/table.view_assets_for')
        {{{ $supplier->name }}} </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">
    <div class="profile-box">

                            <!-- checked out suppliers table -->
                            <h6>Assets</h6>
                            <br>
                            @if (count($supplier->assets) > 0)
                           <table id="example">
                            <thead>
                                <tr role="row">
                                        <th class="col-md-3">Name</th>
                                        <th class="col-md-3">Asset Tag</th>
                                        <th class="col-md-3">User</th>
                                        <th class="col-md-2">Actions</th>
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
                                        @if ($supplierassets->assigned_to != '')
                                            <a href="{{ route('checkin/hardware', $supplierassets->id) }}" class="btn-flat info">Checkin</a>
                                        @else
                                            <a href="{{ route('checkout/hardware', $supplierassets->id) }}" class="btn-flat success">Checkout</a>
                                        @endif
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                            @else
                            <div class="col-md-12">
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif
                            <br>
                            <br>
                            <h6>Software</h6>
                            <br>
                            @if (count($supplier->licenses) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-4"><span class="line"></span>Name</th>
                                        <th class="col-md-4"><span class="line"></span>Serial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier->licenses as $license)
                                    <tr>
                                        <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->name }}}</a></td>
                                        <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->serial }}}</a></td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else

                            <div class="col-md-12">
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif
    </div>
</div>


                    <!-- side address column -->
                    <div class="col-md-3 col-xs-12 address pull-right">
                    <h6>Contact:</h6>
                               <ul>

                                @if ($supplier->contact)
                                    <li><i class="fa fa-user"></i>{{{ $supplier->contact }}}</li>
                                @endif
                                @if ($supplier->phone)
                                    <li><i class="fa fa-phone"></i>{{{ $supplier->phone }}}</li>
                                @endif
                                @if ($supplier->fax)
                                    <li><i class="fa fa-print"></i>{{{ $supplier->fax }}}</li>
                                @endif


                                @if ($supplier->email)
                                    <li><i class="fa fa-envelope-o"></i><a href="mailto:{{{ $supplier->email }}}">
                                    {{{ $supplier->email }}}
                                    </a></li>
                                @endif

                                @if ($supplier->url)
                                    <li><i class="fa fa-globe"></i><a href="{{{ $supplier->url }}}" target="_new">{{{ $supplier->url }}}</a></li>
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
                                        {{{ $supplier->city }}} {{{ strtoupper($supplier->state) }}} {{{ $supplier->zip }}} {{{ strtoupper($supplier->country) }}}
                                    @endif
                                    </li>
                                @endif

                                @if ($supplier->notes)
                                    <li><i class="fa fa-comment"></i>{{{ $supplier->notes }}}</li>
                                @endif

                                @if ($supplier->image)
                                <li><br /><img src="/uploads/suppliers/{{{ $supplier->image }}}" /></li>
                                @endif

                                </ul>



                            </ul>



                            <ul>
                                <li><br><br /></li>
                            </ul>

                    </div>
@stop
