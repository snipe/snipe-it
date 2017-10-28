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
                    <li role="presentation"><a href="{{ route('hardware.edit', $asset->id) }}">{{ trans('admin/hardware/general.edit') }}</a></li>
                    <li role="presentation"><a href="{{ route('clone/hardware', $asset->id) }}">{{ trans('admin/hardware/general.clone') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
            <div class="col-md-12">
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
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.manufacturer') }}: </strong>
                    <a href="{{ route('manufacturers.edit', $asset->model->manufacturer->id) }}">
                        {{ $asset->model->manufacturer->name }}
                    </a>
                </div>
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.model') }}:</strong>
                    <a href="{{ route('models.show', $asset->model->id) }}">
                        {{ $asset->model->name }}
                    </a>
                    / {{ $asset->model->model_number }}
                </div>
                @endif

                @if ($asset->purchase_date)
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.date') }}: </strong>
                    {{ $asset->purchase_date }}
                </div>
                @endif

                @if ($asset->purchase_cost)
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.cost') }}:</strong>
                    {{ $snipeSettings->default_currency }}
                    {{ number_format($asset->purchase_cost,2) }}
                </div>
                @endif

                @if ($asset->order_number)
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.order') }}:</strong>
                    {{ $asset->order_number }}
                </div>
                @endif

                @if ($asset->supplier_id)
                <div class="col-md-6" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.supplier') }}: </strong>
                    <a href="{{ route('suppliers.show', $asset->supplier_id) }}">
                        {{ $asset->supplier->name }}
                    </a>
                </div>
                @endif

                @if ($asset->warranty_months)
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.warranty') }}:</strong>
                    {{ $asset->warranty_months }}
                    {{ trans('admin/hardware/form.months') }}
                </div>
                <div class="col-md-12 {{ $asset->present()->warrantee_expires() < date("Y-m-d H:i:s") ? 'ui-state-highlight' : '' }}"  style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.expires') }}:</strong>
                    {{ $asset->present()->warrantee_expires() }}
                </div>
                @endif

                @if ($asset->depreciation)
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.depreciation') }}: </strong>
                    {{ $asset->depreciation->name }}
                    ({{ $asset->depreciation->months }}
                    {{ trans('admin/hardware/form.months') }}
                    )
                </div>
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.fully_depreciated') }}: </strong>
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
                    {{ trans('admin/hardware/form.months') }}
                </div>
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <strong>{{ trans('admin/hardware/form.eol_date') }}: </strong>
                    {{ $asset->present()->eol_date() }}
                    @if ($asset->present()->months_until_eol())
                        (
                        @if ($asset->present()->months_until_eol()->y > 0) {{ $asset->present()->months_until_eol()->y }}
                        {{ trans('general.years') }},
                        @endif
                        {{ $asset->present()->months_until_eol()->m }}
                        {{ trans('general.months') }}
                        )
                    @endif
                </div>
                @endif
            </div>

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
                            <td><a href="{{ route('licenses.show', $seat->license->id) }}">{{ $seat->license->name }}</a></td>
                            <td>{{ $seat->license->serial }}</td>
                            <td><a href="{{ route('licenses.checkin', $seat->id) }}" class="btn-flat info">{{ trans('general.checkin') }}</a>
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
            </div>

            <div class="col-md-12">
                <h6>
                    {{ trans('general.file_uploads') }} [ <a href="#" data-toggle="modal" data-target="#uploadFileModal">{{trans('button.add')}} </a> ]
                </h6>

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
                                @if ($file->note)
                                {{ $file->note }}
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

            <div class="col-md-12">
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
                                'icon'          => '<i class="'.$this->parseItemIcon().'"></i>',
            'created_at'    => date("M d, Y g:iA", strtotime($this->created_at)),
            'action_type'   => strtolower(trans('general.'.str_replace(' ', '_', $this->action_type))),
            'admin'         =>  $this->model->user ? $this->model->user->present()->nameUrl() : '',
            'target'        => $this->target(),
            'item'          => $this->item(),
            'item_type'     => $this->itemType(),
            'note'          => e($this->note),

                        @if (count($asset->assetlog) > 0)
                        @foreach ($asset->assetlog as $log)
                        @php $result = $log->present()->forDataTable();
                        @endphp
                        <tr>
                            <td>{{ $result['created_at'] }}</td>
                            <td>
                                {!! $result['admin'] !!}
                            </td>
                            <td>{{ $result['action_type'] }}</td>
                            <td>
                            {!! $result['target'] !!}
                            </td>
                            <td>
                                {{ $result['note'] }}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td>{{ $asset->created_at }}</td>
                            <td>
                            @if (isset($asset->adminuser->id)) {{ $asset->adminuser->present()->fullName() }}
                            @else
                            {{ trans('general.unknown_admin') }}
                            @endif
                            </td>
                            <td>{{ trans('general.created_asset') }}</td>
                            <td></td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> <!--/.col-md-9.bio-->

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

            @if (($asset->checkedOutToUser()) && ($asset->assigned_to > 0) && ($asset->deleted_at==''))
            {{-- @TODO This should be extnded for details about non users --}}
            <h6><br>{{ trans('admin/hardware/form.checkedout_to') }}</h6>
            <ul>
                <li>
                    <img src="{{ $asset->assignedTo->present()->gravatar() }}" class="img-circle" style="width: 100px; margin-right: 20px;" /><br /><br />
                </li>
                <li>
                    {{ $asset->assignedTo->present()->nameUrl() }}
                </li>

                @if (isset($asset->location->address))
                <li>
                    {{ $asset->location->address }}
                    @if (isset($asset->location->address2))
                    {{ $asset->location->address2 }}
                    @endif
                </li>
                    @if (isset($asset->location->city))
                    <li>{{ $asset->location->city }}, {{ $asset->location->state }} {{ $asset->location->zip }}</li>
                    @endif
                @endif

                @if (isset($asset->assignedTo->email))
                <li><br /><i class="fa fa-envelope-o"></i> <a href="mailto:{{ $asset->assignedTo->email }}">{{ $asset->assignedTo->email }}</a></li>
                @endif

                @if ((isset($asset->assignedTo->phone)) && ($asset->assignedTo->phone!=''))
                <li><i class="fa fa-phone"></i> {{ $asset->assignedTo->phone }}</li>
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
        </div> <!-- /.col-md-3-->
    </div> <!--/.row.profile-->
</div> <!--/.user-profile-->

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
