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

      <!-- checked out suppliers table -->
      <h6>Assets</h6>
      <br>
      @if (count($supplier->assets) > 0)
      <div class="table-responsive">
       <table class="display table table-hover">
            <thead>
                <tr role="row">
                        <th class="col-md-3">Asset Tag</th>
                        <th class="col-md-3"><span class="line"></span>Name</th>
                        <th class="col-md-3"><span class="line"></span>User</th>
                        <th class="col-md-2"><span class="line"></span>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($supplier->assets as $supplierassets)
                    <tr>

                        <td><a href="{{ route('view/hardware', $supplierassets->id) }}">{{{ $supplierassets->asset_tag }}}</a></td>
                        <td><a href="{{ route('view/hardware', $supplierassets->id) }}">{{{ $supplierassets->showAssetName() }}}</a></td>
                        <td>
                        @if ($supplierassets->assigneduser)
                        <a href="{{ route('view/user', $supplierassets->assigned_to) }}">
                        {{{ $supplierassets->assigneduser->fullName() }}}
                        </a>
                        @endif
                        </td>
                        <td>
                        @if ($supplierassets->assigned_to != '')
                            <a href="{{ route('checkin/hardware', $supplierassets->id) }}" class="btn btn-info btn-sm">Checkin</a>
                        @else
                            <a href="{{ route('checkout/hardware', $supplierassets->id) }}" class="btn btn-success btn-sm">Checkout</a>
                        @endif
                        </td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
      </div>

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
                        <th class="col-md-4">Name</th>
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
            <!-- Improvements -->
            <br>
            <br>
            <h6>Improvements</h6>
            <br>
            <!-- Improvement table -->
            @if (count($supplier->improvements) > 0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-2"><span class="line"></span>@lang('admin/improvements/table.asset_name')</th>
                        <th class="col-md-2"><span class="line"></span>@lang('admin/improvements/form.improvement_type')</th>
                        <th class="col-md-2"><span class="line"></span>@lang('admin/improvements/form.start_date')</th>
                        <th class="col-md-2"><span class="line"></span>@lang('admin/improvements/form.completion_date')</th>
                        <th class="col-md-2"><span class="line"></span>@lang('admin/improvements/table.is_warranty')</th>
                        <th class="col-md-2"><span class="line"></span>@lang('admin/improvements/form.cost')</th>
                        <th class="col-md-1"><span class="line"></span>@lang('table.actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $totalCost = 0; ?>
                    @foreach ($supplier->improvements as $improvement)
                        @if (is_null($improvement->deleted_at))
                            <tr>
                                <td><a href="{{ route('view/hardware', $improvement->asset_id) }}">{{{ $improvement->asset->name }}}</a></td>
                                <td>{{{ $improvement->improvement_type }}}</td>
                                <td>{{{ $improvement->start_date }}}</td>
                                <td>{{{ $improvement->completion_date }}}</td>
                                <td>{{{ $improvement->is_warranty ? Lang::get('admin/improvements/message.warranty') : Lang::get('admin/improvements/message.not_warranty') }}}</td>
                                <td>{{{ sprintf( Lang::get( 'general.currency' ) . '%01.2f', $improvement->cost) }}}</td>
                                <?php $totalCost += $improvement->cost; ?>
                                <td><a href="{{ route('update/improvement', $improvement->id) }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{{sprintf(Lang::get( 'general.currency' ) . '%01.2f', $totalCost)}}}</td>
                    </tr>
                    </tfoot>
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
                                <li><br /><img src="{{ Config::get('app.url') }}/uploads/suppliers/{{{ $supplier->image }}}" /></li>
                                @endif

                                </ul>



                            </ul>



                            <ul>
                                <li><br><br /></li>
                            </ul>

                    </div>
@stop
