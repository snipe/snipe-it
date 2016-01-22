@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/licenses/general.view')
 - {{{ $license->name }}}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">@lang('button.actions')
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="{{ route('update/license', $license->id) }}">@lang('admin/licenses/general.edit')</a></li>
                <li><a href="{{ route('clone/license', $license->id) }}">@lang('admin/licenses/general.clone')</a></li>
            </ul>
        </div>
       <h3 class="name">@lang('general.history_for')
       {{{ $license->name }}}</h3>
    </div>
</div>

<div class="user-profile ">
<div class="row profile">
<div class="col-md-9 bio">

@if (!is_null($license->company))
    <div class="col-md-12 col-sm-12" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
        <strong>@lang('general.company'): </strong>
        {{{ $license->company->name }}}
    </div>
@endif

@if ($license->serial)
	<div class="col-md-12 col-sm-12" style="padding-bottom: 10px; margin-left: 15px; word-wrap: break-word;">
	<strong>@lang('admin/licenses/form.serial'): </strong>
	{{ nl2br($license->serial) }}
	</div>
@endif

<div class="col-md-12" style="padding-bottom: 20px">

@if ($license->license_name)
<div class="col-md-6" style="padding-bottom: 5px"><strong>@lang('admin/licenses/form.to_name'): </strong>
{{{ $license->license_name }}} </div>
@endif

@if ($license->license_email)
<div class="col-md-6" style="padding-bottom: 5px"><strong>@lang('admin/licenses/form.to_email'): </strong>
{{{ $license->license_email }}} </div>
@endif

@if ($license->supplier_id)
    <div class="col-md-6" style="padding-bottom: 5px"><strong>@lang('admin/licenses/form.supplier'): </strong>
    <a href="{{ route('view/supplier', $license->supplier_id) }}">
    {{{ $license->supplier->name }}}
    </a> </div>
@endif

@if ($license->expiration_date > 0)
<div class="col-md-6" style="padding-bottom: 5px"><strong>@lang('admin/licenses/form.expiration'): </strong>
{{{ $license->expiration_date }}} </div>
@endif


 @if ($license->depreciation)
	<div class="col-md-6" style="padding-bottom: 5px">
	<strong>@lang('admin/hardware/form.depreciation'): </strong>
	{{{ $license->depreciation->name }}}
		({{{ $license->depreciation->months }}}
		@lang('admin/hardware/form.months')
		)
	</div>

	<div class="col-md-6" style="padding-bottom: 5px">
		<strong>@lang('admin/hardware/form.depreciates_on'): </strong>
		{{{ $license->depreciated_date()->format("Y-m-d") }}}
	</div>

	<div class="col-md-6" style="padding-bottom: 5px">
		<strong>@lang('admin/hardware/form.fully_depreciated'): </strong>
        @if ($license->time_until_depreciated()->y > 0)
            {{{ $license->time_until_depreciated()->y }}}
            @lang('admin/hardware/form.years'),
        @endif
		{{{ $license->time_until_depreciated()->m }}}
		@lang('admin/hardware/form.months')

	 </div>
@endif

</div>


<div class="col-md-12" style="padding-top: 60px;">
                <!-- checked out assets table -->
                <h6>{{ $license->seats }} @lang('admin/licenses/general.license_seats')</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-2">@lang('admin/licenses/general.seat')</th>
                             <th class="col-md-2">@lang('admin/licenses/general.user')</th>
                             <th class="col-md-4">@lang('admin/licenses/form.asset')</th>
                             <th class="col-md-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $count=1; ?>
                        @if ($license->licenseseats)
                            @foreach ($license->licenseseats as $licensedto)

                            <tr>
                                <td>Seat {{ $count }} </td>
                                <td>
                                    @if (($licensedto->assigned_to) && ($licensedto->deleted_at == NULL))
                                        <a href="{{ route('view/user', $licensedto->assigned_to) }}">
                                    {{{ $licensedto->user->fullName() }}}
                                    </a>
                                    @elseif (($licensedto->assigned_to) && ($licensedto->deleted_at != NULL))
                                        <del>{{{ $licensedto->user->fullName() }}}</del>
                                    @elseif ($licensedto->asset_id)
                                        @if ($licensedto->asset->assigned_to != 0)
                                            <a href="{{ route('view/user', $licensedto->asset->assigned_to) }}">
                                                {{{ $licensedto->asset->assigneduser->fullName() }}}
                                            </a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($licensedto->asset_id)
                                        <a href="{{ route('view/hardware', $licensedto->asset_id) }}">
                                        {{{ $licensedto->asset->name }}} {{{ $licensedto->asset->asset_tag }}}
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    @if (($licensedto->assigned_to) || ($licensedto->asset_id))
                                        @if ($license->reassignable)
                                            <a href="{{ route('checkin/license', $licensedto->id) }}" class="btn btn-primary btn-sm">
                                            @lang('general.checkin')
                                            </a>
                                        @else
                                            <span>Assigned</span>
                                        @endif
                                    @else
                                        <a href="{{ route('checkout/license', $licensedto->id) }}" class="btn btn-info btn-sm">
                                        @lang('general.checkout')</a>
                                    @endif
                                </td>

                            </tr>
                            <?php $count++; ?>
                            @endforeach
                            @endif


                    </tbody>
                </table>
</div>

<div class="col-md-12">


 	<h6>@lang('general.file_uploads') [ <a href="#" data-toggle="modal" data-target="#uploadFileModal">@lang('button.add')</a> ]</h6>


 	<table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-5">@lang('admin/licenses/form.notes')</th>
                            <th class="col-md-5"><span class="line"></span>@lang('general.file_name')</th>
                            <th class="col-md-2"></th>
                            <th class="col-md-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($license->uploads) > 0)
							@foreach ($license->uploads as $file)
							<tr>
								<td>
									@if ($file->note) {{{ $file->note }}}
									@endif
								</td>
								<td>
								{{{ $file->filename }}}
								</td>
								<td>
									@if ($file->filename)
									<a href="{{ route('show/licensefile', [$license->id, $file->id]) }}" class="btn btn-default">Download</a>
									@endif
								</td>
								<td>
									<a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/licensefile', [$license->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{{ $file->filename }}}?"><i class="fa fa-trash icon-white"></i></a>
								</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">
									@lang('general.no_results')
								</td>
							</tr>

                        @endif

                    </tbody>
        </table>

</div>

<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="uploadFileModalLabel">Upload File</h4>
      </div>
      {{ Form::open([
      'method' => 'POST',
      'route' => ['upload/license', $license->id],
      'files' => true, 'class' => 'form-horizontal' ]) }}
      <div class="modal-body">

		<p>@lang('admin/licenses/general.filetype_info')</p>

		 <div class="form-group col-md-12">
		 <div class="input-group col-md-12">
		 	<input class="col-md-12 form-control" type="text" name="notes" id="notes" placeholder="Notes">
		</div>
		</div>
		<div class="form-group col-md-12">
		 <div class="input-group col-md-12">
			{{ Form::file('licensefile[]', ['multiple' => 'multiple']) }}
		</div>
		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('button.cancel')</button>
        <button type="submit" class="btn btn-primary btn-sm">@lang('button.upload')</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>



<div class="col-md-12">
                <h6>@lang('admin/licenses/general.checkout_history')</h6>

                <table class="table table-hover table-fixed break-word">
                    <thead>
                        <tr>
                            <th class="col-md-3">@lang('general.date')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('general.admin')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('button.actions')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('admin/licenses/general.user')</th>
                            <th class="col-md-3"><span class="line"></span>@lang('admin/licenses/form.notes')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($license->assetlog) > 0)
                        @foreach ($license->assetlog as $log)
                        <tr>
                            <td>{{ $log->created_at }}</td>
                            <td>
                                @if (isset($log->user_id))
                                {{{ $log->adminlog->fullName() }}}
                                @endif
                            </td>
                            <td>{{ $log->action_type }}</td>

                            <td>
                                @if (($log->userlog) && ($log->userlog->id!='0'))
                                <a href="{{ route('view/user', $log->checkedout_to) }}">
                                {{{ $log->userlog->fullName() }}}
                                </a>

                                @elseif ($log->action_type=='uploaded')

                                		{{ $log->filename }}

                                @endif

                            </td>
                            <td>
                                @if ($log->note) {{{ $log->note }}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td>{{{ $license->created_at }}}</td>
                            <td>
                            @if ($license->adminuser) {{{ $license->adminuser->fullName() }}}
                            @else
                            @lang('general.unknown_admin')
                            @endif
                            </td>
                            <td>@lang('general.created_asset')</td>
                            <td></td>
                            <td>
                            @if ($license->notes)
                            {{{ $license->notes }}}
                            @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
</div>
        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
        <h6><br>@lang('general.moreinfo'):</h6>
                <ul>
                    @if ($license->purchase_order)
                    <li><strong>@lang('admin/licenses/form.purchase_order'):</strong>
                    {{{ $license->purchase_order }}} </li>
                    @endif
                    @if ($license->purchase_date > 0)
                    <li><strong>@lang('admin/licenses/form.date'):</strong>
                    {{{ $license->purchase_date }}} </li>
                    @endif
                    @if ($license->purchase_cost > 0)
                    <li><strong>@lang('admin/licenses/form.cost'):</strong>
                    {{{ Setting::first()->default_currency }}}
                    {{{ number_format($license->purchase_cost,2) }}} </li>
                    @endif
                    @if ($license->order_number)
                    <li><strong>@lang('admin/licenses/form.order'):</strong>
                    {{{ $license->order_number }}} </li>
                    @endif
                    @if (($license->seats) && ($license->seats) > 0)
                    <li><strong>@lang('admin/licenses/form.seats'):</strong>
                    {{{ $license->seats }}} </li>
                    @endif

                    <li><strong>@lang('admin/licenses/form.reassignable'):</strong>
                                {{ $license->reassignable ? 'Yes' : 'No' }}
                    </li>

                    @if ($license->notes)
                    	 <li><strong>@lang('admin/licenses/form.notes'):</strong>
                        <li class="break-word">{{ nl2br(e($license->notes)) }}</li>
                    @endif
                </ul>
        </div>
    </div>
</div>
@stop
