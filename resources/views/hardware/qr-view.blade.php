@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/hardware/general.view') }} {{ $asset->asset_tag }} 
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
     <h3 class="name">
        {{ trans('admin/hardware/general.view') }}
        {{ $asset->asset_tag }}
        @if ($asset->name)
        ({{ $asset->name }})
        @endif
    </h3>

        <div class="btn-group pull-right">

		<div class="dropdown">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
                @if ($asset->status_id == 1)
                    @if ($asset->assigned_to != 0)
                        <li role="presentation"><a href="{{ route('checkin/hardware', $asset->id) }}">{{ trans('admin/hardware/general.checkin') }}</a></li>
                    @endif
                @elseif ($asset->status_id == 0)
                        <li role="presentation"><a href="{{ route('checkout/hardware', $asset->id) }}">{{ trans('admin/hardware/general.checkout') }}</a></li>
                @endif
                <li role="presentation"><a href="{{ route('update/hardware', $asset->id) }}">{{ trans('admin/hardware/general.edit') }}</a></li>
                <li role="presentation"><a href="{{ route('clone/hardware', $asset->id) }}">{{ trans('admin/hardware/general.clone') }}</a></li>
            </ul>
        </div>


    </div>
</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

		@if ($asset->model->deleted_at!='')
            <div class="alert alert-warning alert-block">
				<i class="fa fa-warning"></i>
				{{ trans('admin/hardware/general.model_deleted', array('model_id' => $asset->model->id)) }}
			</div>
        @elseif ($asset->deleted_at!='')
			<div class="alert alert-warning alert-block">
				<i class="fa fa-warning"></i>
				{{ trans('admin/hardware/general.deleted', array('asset_id' => $asset->id)) }}
			</div>
		@endif

        @if ($asset->serial)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.serial') }}: </strong>
            <em>{{ $asset->serial }}</em></div>

        @endif

        @if ($asset->mac_address!='')
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.mac_address') }}:</strong>
            {{ $asset->mac_address }}
            </div>
        @endif

        @if ($asset->model->manufacturer)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.manufacturer') }}: </strong>
            <a href="{{ route('update/manufacturer', $asset->model->manufacturer->id) }}">
            {{ $asset->model->manufacturer->name }}
            </a> </div>
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.model') }}:</strong>
            <a href="{{ route('view/model', $asset->model->id) }}">
            {{ $asset->model->name }}
            </a>
             / {{ $asset->model->model_number }}</div>
        @endif

        @if ($asset->purchase_date)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.date') }}: </strong>
            {{ $asset->purchase_date }} </div>
        @endif

        @if ($asset->purchase_cost)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.cost') }}:</strong>
            {{ $snipeSettings->default_currency }}
            {{ number_format($asset->purchase_cost,2) }} </div>
        @endif

        @if ($asset->order_number)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.order') }}:</strong>
            {{ $asset->order_number }} </div>
        @endif

        @if ($asset->supplier_id)
            <div class="col-md-6" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.supplier') }}: </strong>
            <a href="{{ route('view/supplier', $asset->supplier_id) }}">
            {{ $asset->supplier->name }}
            </a> </div>
        @endif

        @if ($asset->warranty_months)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.warranty') }}:</strong>
            {{ $asset->warranty_months }}
            {{ trans('admin/hardware/form.months') }}
            </div>
            <div class="col-md-12 {{ $asset->warrantee_expires() < date("Y-m-d H:i:s") ? 'ui-state-highlight' : '' }}"  style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.expires') }}:</strong>
            {{ $asset->warrantee_expires() }}</div>
        @endif

        @if ($asset->depreciation)
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.depreciation') }}: </strong>
            {{ $asset->depreciation->name }}
                ({{ $asset->depreciation->months }}
                {{ trans('admin/hardware/form.months') }}
                )</div>
            <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.fully_depreciated') }}: </strong>
             @if ($asset->time_until_depreciated()->y > 0)
                {{ $asset->time_until_depreciated()->y }}
                {{ trans('admin/hardware/form.years') }},
             @endif
           {{ $asset->time_until_depreciated()->m }}
            {{ trans('admin/hardware/form.months') }}
               ({{ $asset->depreciated_date()->format('Y-m-d') }})
             </div>
        @endif


        @if ($asset->model->eol)
            <div class="col-md-12" style="padding-bottom: 5px;">
            <strong>{{ trans('admin/hardware/form.eol_rate') }}: </strong>
            {{ $asset->model->eol }}
            {{ trans('admin/hardware/form.months') }} </div>
            <div class="col-md-12" style="padding-bottom: 5px;">
            <strong>{{ trans('admin/hardware/form.eol_date') }}: </strong>
            {{ $asset->eol_date() }}
            @if ($asset->months_until_eol())
                 (
                 @if ($asset->months_until_eol()->y > 0) {{ $asset->months_until_eol()->y }}
                  {{ trans('general.years') }},
                 @endif

                {{ $asset->months_until_eol()->m }}
                {{ trans('general.months') }}
                )
            @endif
            </div>
        @endif





<div class="col-md-12">
  		<!-- Licenses assets table -->
        <h6>Software Assigned </h6>
		<br>
		<!-- checked out assets table -->
		@if (count($asset->licenses) > 0)
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-4"><span class="line"></span>{{ trans('general.name') }}</th>
					<th class="col-md-4"><span class="line"></span>{{ trans('admin/licenses/form.license_key') }}</th>
					<th class="col-md-1"><span class="line"></span>{{ trans('table.actions') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($asset->licenseseats as $seat)
				<tr>
					<td><a href="{{ route('view/license', $seat->license->id) }}">{{ $seat->license->name }}</a></td>
					<td>{{ $seat->license->serial }}</td>
					<td><a href="{{ route('checkin/license', $seat->id) }}" class="btn-flat info">{{ trans('general.checkin') }}</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else

		<div class="col-md-12">
			<div class="alert alert-info alert-block">
				<i class="fa fa-info-circle"></i>
				{{ trans('general.no_results') }}
			</div>
		</div>
		@endif


		<div class="col-md-12">


 	<h6>{{ trans('general.file_uploads') [ <a href="#" data-toggle="modal" data-target="#uploadFileModal">@lang('button.add') }}</a> ]</h6>


 	<table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-5">{{ trans('general.notes') }}</th>
                            <th class="col-md-5"><span class="line"></span>{{ trans('general.file_name') }}</th>
                            <th class="col-md-2"></th>
                            <th class="col-md-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($asset->uploads) > 0)
							@foreach ($asset->uploads as $file)
							<tr>
								<td>
									@if ($file->note) {{ $file->note }}
									@endif
								</td>
								<td>
								{{ $file->filename }}
								</td>
								<td>
									@if ($file->filename)
									<a href="{{ route('show/assetfile', [$asset->id, $file->id]) }}" class="btn btn-default">{{ trans('general.download') }}</a>
									@endif
								</td>
								<td>
									<a class="btn delete-asset btn-danger btn-sm"
                                    href="{{ route('delete/assetfile', [$asset->id, $file->id]) }}"
                                    data-html="false" data-toggle="modal"
                                    data-title="{{ trans('admin/hardware/message.deletefile.confirm') }}"
                                    data-content="{{ trans('admin/hardware/message.deletefile.confirm-more',array('filename' => $file->filename)) }} " onClick="return false;">
                                    <i class="fa fa-trash icon-white"></i>
                                    </a>
								</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4">
									{{ trans('general.no_results') }}
								</td>
							</tr>

                        @endif

                    </tbody>
        </table>

</div>




        <!-- checked out assets table -->

        <table class="table table-hover table-fixed break-word">
            <thead>
                <tr>
                    <th class="col-md-3">{{ trans('general.date') }}</th>
                    <th class="col-md-2"><span class="line"></span>{{ trans('general.admin') }}</th>
                    <th class="col-md-2"><span class="line"></span>{{ trans('table.actions') }}</th>
                    <th class="col-md-2"><span class="line"></span>{{ trans('general.user') }}</th>
                    <th class="col-md-3"><span class="line"></span>{{ trans('general.notes') }}</th>
                </tr>
            </thead>
            <tbody>
            @if (count($asset->assetlog) > 0)
                @foreach ($asset->assetlog as $log)

                <tr>
                    <td>{{ $log->created_at }}</td>
                    <td>
                        @if (isset($log->user_id))
                        {{ $log->user->fullName() }}
                        @endif
                    </td>
                    <td>{{ $log->action_type }}</td>
                    <td>
                        @if ((isset($log->target_id)) && ($log->target_id!=0) && ($log->target_id!=''))

	                        @if ($log->target->deleted_at=='')
		                        <a href="{{ route('view/user', $log->target_id) }}">
		                        {{ $log->user->fullName() }}
		                         </a>
		                    @else
		 						<del>{{ $log->user->fullName() }}</del>
	                        @endif

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
                    <td>{{ $asset->created_at }}</td>
                    <td>
                    @if (isset($asset->adminuser->id)) {{ $asset->adminuser->fullName() }}
                    @else
                    {{ trans('general.unknown_admin') }}
                    @endif
                    </td>
                    <td>{{ trans('general.created_asset') }}</td>
                    <td></td>
                    <td>
<!--                    @if ($asset->notes)
                    {{ $asset->notes }}
                    @endif -->
                    </td>
                </tr>
            </tbody>
        </table>


        </div>
</div>
        <!-- side address column -->
        <div class="col-md-3">

        	<!-- Asset notes -->
@if ($asset->notes)

		<h6>{{ trans('admin/hardware/form.notes') }}:</h6>
		 <div class="break-word">{{ nl2br(e($asset->notes)) }}</div>

@endif

            @if ($qr_code->display)
            <h6>{{ trans('admin/hardware/form.qr') }}</h6>
            <ul>
                <li>
                    <img src="{{ $qr_code->url }}" />
                </li>
            </ul>
            @endif


            @if (($asset->assigneduser) && ($asset->assigned_to > 0) && ($asset->deleted_at==''))
                <h6><br>{{ trans('admin/hardware/form.checkedout_to') }}</h6>
                <ul>

                    <li><img src="{{ $asset->assigneduser->gravatar() }}" class="img-circle" style="width: 100px; margin-right: 20px;" /><br /><br /></li>
                    <li><a href="{{ route('view/user', $asset->assigned_to) }}">{{ $asset->assigneduser->fullName() }}</a></li>


                    @if (isset($asset->assetloc->address))
                        <li>{{ $asset->assetloc->address }}
                        @if (isset($asset->assetloc->address2)) {{ $asset->assetloc->address2 }}
                        @endif
                        </li>
                        @if (isset($asset->assetloc->city))
                            <li>{{ $asset->assetloc->city }}, {{ $asset->assetloc->state }} {{ $asset->assetloc->zip }}</li>
                        @endif

                    @endif

                    @if (isset($asset->assigneduser->email))
                        <li><br /><i class="fa fa-envelope-o"></i> <a href="mailto:{{ $asset->assigneduser->email }}">{{ $asset->assigneduser->email }}</a></li>
                    @endif

                    @if ((isset($asset->assigneduser->phone)) && ($asset->assigneduser->phone!=''))
                        <li><i class="fa fa-phone"></i> {{ $asset->assigneduser->phone }}</li>
                    @endif


                    </ul>

			 @endif

            @if (($asset->status_id ) && ($asset->status_id > 0))
			<!-- Status Info -->

                @if ($asset->assetstatus)
                    <h6><br>
                     	@if (($asset->assetstatus->deployable=='1') && ($asset->assigned_to > 0))
                            {{ trans('admin/hardware/general.asset') }}
                            {{ trans('general.deployed') }}
                        @else
                            {{ $asset->assetstatus->name }}
                            {{ trans('admin/hardware/general.asset') }}
                        @endif
                    <ul>

                    	 @if (($asset->assetstatus->deployable=='1') && ($asset->assigned_to > 0) && ($asset->deleted_at==''))
                    	<li><br /><a href="{{ route('checkin/hardware', $asset->id) }}" class="btn btn-primary btn-sm">{{ trans('admin/hardware/general.checkin') }}</a></li>
                    	@elseif ((($asset->assetstatus->deployable=='1') &&  (($asset->assigned_to=='') || ($asset->assigned_to==0))) && ($asset->deleted_at==''))
                    	<li><br /><a href="{{ route('checkout/hardware', $asset->id) }}" class="btn btn-info btn-sm">{{ trans('admin/hardware/general.checkout') }}</a></li>
						@elseif  (($asset->deleted_at!='') && ($asset->model->deleted_at==''))

						<li><br /><a href="{{ route('restore/hardware', $asset->id) }}" class="btn-flat large info ">{{ trans('admin/hardware/general.restore') }}</a></li>

                    	@endif
                    </ul>

					@if (($asset->assetstatus->notes) && ($asset->assigned_to==''))
                    <div class="col-md-12">
						<div class="alert alert-info alert-block">
							<i class="fa fa-info-circle"></i>
							{{ $asset->assetstatus->notes }}

						</div>
                    </div>
                    @endif

                 @endif
            @endif

        </div>
    </div>
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
      'route' => ['upload/asset', $asset->id],
      'files' => true, 'class' => 'form-horizontal' ]) }}
      <div class="modal-body">

		<p><p>{{ trans('admin/hardware/general.filetype_info') }}</p>.</p>

		 <div class="form-group col-md-12">
		 <div class="input-group col-md-12">
		 	<input class="col-md-12 form-control" type="text" name="notes" id="notes" placeholder="Notes">
		</div>
		</div>
		<div class="form-group col-md-12">
		 <div class="input-group col-md-12">
			{{ Form::file('assetfile[]', ['multiple' => 'multiple']) }}
		</div>
		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
        <button type="submit" class="btn btn-primary btn-sm">{{ trans('button.upload') }}</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

@stop
