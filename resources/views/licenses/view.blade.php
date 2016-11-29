@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.view') }}
 - {{ $license->name }}
@parent
@stop

{{-- Right header --}}
@section('header_right')
<div class="btn-group pull-right">
    @can('licenses.edit')
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
          <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
          <li><a href="{{ route('update/license', $license->id) }}">{{ trans('admin/licenses/general.edit') }}</a></li>
          <li><a href="{{ route('clone/license', $license->id) }}">{{ trans('admin/licenses/general.clone') }}</a></li>
      </ul>
     @endcan
  </div>
@stop


{{-- Page content --}}
@section('content')

<div class="row">

  <div class="col-md-12">
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Details</a></li>
        <li><a href="#tab_2" data-toggle="tab">{{ trans('general.file_uploads') }}</a></li>
        <li><a href="#tab_3" data-toggle="tab">{{ trans('admin/licenses/general.checkout_history') }}</a></li>

        <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip"></i> {{ trans('button.upload') }}</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">

          <div class="row">
            <div class="col-md-7">

              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th class="col-md-2">{{ trans('admin/licenses/general.seat') }}</th>
                           <th class="col-md-2">{{ trans('admin/licenses/general.user') }}</th>
                           <th class="col-md-4">{{ trans('admin/licenses/form.asset') }}</th>
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

                                @if (($licensedto->user) && ($licensedto->deleted_at == NULL))
                                    @can('users.view')
                                        <a href="{{ route('view/user', $licensedto->assigned_to) }}">
                                            {{ $licensedto->user->fullName() }}
                                        </a>
                                     @else
                                        {{ $licensedto->user->fullName() }}
                                     @endcan

                                @elseif (($licensedto->user) && ($licensedto->deleted_at != NULL))
                                    <del>{{ $licensedto->user->fullName() }}</del>
                                @elseif ($licensedto->asset)
                                    @if ($licensedto->asset->assigned_to != 0)
                                        @can('users.view')
                                            <a href="{{ route('view/user', $licensedto->asset->assigned_to) }}">
                                                {{ $licensedto->asset->assigneduser->fullName() }}
                                            </a>
                                        @else
                                            {{ $licensedto->asset->assigneduser->fullName() }}
                                        @endcan

                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($licensedto->asset_id)
                                        @can('assets.view')
                                            <a href="{{ route('view/hardware', $licensedto->asset_id) }}">
                                                {{ $licensedto->asset->name }} {{ $licensedto->asset->asset_tag }}
                                            </a>
                                        @else
                                            {{ $licensedto->asset->name }} {{ $licensedto->asset->asset_tag }}
                                        @endcan

                                @endif
                            </td>
                            <td>
                                @can('licenses.checkout')
                                        @if (($licensedto->assigned_to) || ($licensedto->asset_id))

                                            @if ($license->reassignable)
                                                <a href="{{ route('checkin/license', $licensedto->id) }}" class="btn btn-primary btn-sm">
                                                {{ trans('general.checkin') }}
                                                </a>
                                            @else
                                                <span>Assigned</span>
                                            @endif
                                        @else
                                            <a href="{{ route('checkout/license', $licensedto->id) }}" class="btn btn-info btn-sm">
                                            {{ trans('general.checkout') }}</a>
                                        @endif
                                @endcan
                            </td>

                        </tr>
                        <?php $count++; ?>
                        @endforeach
                    @endif


                  </tbody>
              </table>

            </div>
            <div class="col-md-5">
              <div class="table">
                <table class="table">
                  <tbody>
                    @if (!is_null($license->company))
                    <tr>
                      <td>{{ trans('general.company') }}</td>
                      <td>{{ $license->company->name }}</td>
                    </tr>
                    @endif

                    @if (!is_null($license->manufacturer))
                    <tr>
                      <td>{{ trans('general.manufacturer') }}</td>
                      <td>{{ $license->manufacturer->name }}</td>
                    </tr>
                    @endif

                    @can('licenses.keys')
                        @if (!is_null($license->serial))
                        <tr>
                          <td>{{ trans('admin/licenses/form.license_key') }}</td>
                          <td style="word-wrap: break-word;overflow-wrap: break-word;word-break: break-word;">{!! nl2br(e($license->serial)) !!}</td>
                        </tr>
                        @endif
                    @endcan

                    @if (!is_null($license->license_name))
                    <tr>
                      <td>{{ trans('admin/licenses/form.to_name') }}</td>
                      <td>{{ $license->license_name }}</td>
                    </tr>
                    @endif

                    @if (!is_null($license->license_email))
                    <tr>
                      <td>{{ trans('admin/licenses/form.to_email') }}</td>
                      <td>{{ $license->license_email }}</td>
                    </tr>
                    @endif


                    @if ($license->supplier_id)
                      <tr>
                        <td>{{ trans('general.supplier') }}:
                        </td>
                        <td>
                        <a href="{{ route('view/supplier', $license->supplier_id) }}">
                        {{ $license->supplier->name }}
                        </a>
                      </td>
                    </tr>
                    @endif

                    @if ($license->expiration_date > 0)
                      <tr>
                        <td>{{ trans('admin/licenses/form.expiration') }}:
                        </td>
                        <td>  {{ $license->expiration_date }}
                      </td>
                    </tr>
                    @endif

                     @if ($license->depreciation)
                       <tr>
                         <td>
                            {{ trans('admin/hardware/form.depreciation') }}:
                          </td>
                          <td>
                            {{ $license->depreciation->name }}
                              ({{ $license->depreciation->months }}
                              {{ trans('admin/hardware/form.months') }}
                              )
                            </td>
                          </tr>
                      <tr>
                        <td>
                        {{ trans('admin/hardware/form.depreciates_on') }}:
                      </td>
                      <td>
                        {{ $license->depreciated_date()->format("Y-m-d") }}
                      </td>
                    </tr>

                    <tr>
                        <td>
                        {{ trans('admin/hardware/form.fully_depreciated') }}:
                      </td>
                      <td>
                        @if ($license->time_until_depreciated()->y > 0)
                          {{ $license->time_until_depreciated()->y }}
                          {{ trans('admin/hardware/form.years') }},
                        @endif
                        {{ $license->time_until_depreciated()->m }}
                        {{ trans('admin/hardware/form.months') }}

                      </td>
                    </tr>
                    @endif

                    @if ($license->purchase_order)
                    <tr>
                      <td>
                        {{ trans('admin/licenses/form.purchase_order') }}:
                      </td>
                      <td>
                        {{ $license->purchase_order }}
                      </td>
                    </tr>
                    @endif

                    @if ($license->purchase_date > 0)
                    <tr>
                      <td>
                        {{ trans('general.purchase_date') }}:
                      </td>
                      <td>
                        {{ $license->purchase_date }}
                      </td>
                    </tr>
                    @endif

                    @if ($license->purchase_cost > 0)
                    <tr>
                      <td>{{ trans('general.purchase_cost') }}:
                      </td>
                      <td>
                        {{ $snipeSettings->default_currency }}
                        {{ \App\Helpers\Helper::formatCurrencyOutput($license->purchase_cost) }}
                      </td>
                    </tr>
                    @endif

                    @if ($license->order_number)
                    <tr>
                      <td>{{ trans('general.order_number') }}:
                      </td>
                      <td>
                        {{ $license->order_number }}
                      </td>
                    </tr>
                    @endif

                    @if (($license->seats) && ($license->seats) > 0)
                    <tr>
                      <td>{{ trans('admin/licenses/form.seats') }}:
                      </td>
                      <td>
                        {{ $license->seats }}</td>
                    </tr>
                    @endif

                    <tr>
                      <td>
                      {{ trans('admin/licenses/form.reassignable') }}:
                      </td>
                      <td>
                        {{ $license->reassignable ? 'Yes' : 'No' }}
                      </td>
                    </tr>

                    @if ($license->notes)
                       <tr><td>
                         {{ trans('general.notes') }}:
                         </td><td>
                        {!! nl2br(e($license->notes)) !!}</td></tr>
                    @endif


                  </tbody>
                </table>
              </div>

            </div>
        </div>

        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">

          <table class="table table-striped">
          <thead>
            <tr>
                <th class="col-md-5">{{ trans('general.notes') }}</th>
                <th class="col-md-5"><span class="line"></span>{{ trans('general.file_name') }}</th>
                <th class="col-md-2"></th>
                <th class="col-md-2"></th>
            </tr>
          </thead>
          <tbody>
            @if (count($license->uploads) > 0)
              @foreach ($license->uploads as $file)
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
                  <a href="{{ route('show/licensefile', [$license->id, $file->id]) }}" class="btn btn-default">Download</a>
                @endif
                </td>
                <td>
                  <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/licensefile', [$license->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?"><i class="fa fa-trash icon-white"></i></a>
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
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_3">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-hover table-fixed break-word">
                  <thead>
                      <tr>
                          <th class="col-md-2">{{ trans('general.date') }}</th>
                          <th class="col-md-2"><span class="line"></span>{{ trans('general.admin') }}</th>
                          <th class="col-md-2"><span class="line"></span>{{ trans('button.actions') }}</th>
                          <th class="col-md-2"><span class="line"></span>{{ trans('admin/licenses/general.user') }}</th>
                          <th class="col-md-4"><span class="line"></span>{{ trans('general.notes') }}</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if (count($license->assetlog) > 0)
                      @foreach ($license->assetlog as $log)
                      <tr>
                          <td>{{ $log->created_at }}</td>
                          <td>
                              @if (isset($log->user_id))
                              <a href="{{ route('view/user', $log->user_id)}}">{{ $log->user->fullName() }}</a>
                              @endif
                          </td>
                          <td>{{ $log->action_type }}</td>

                          <td>
                              @if (($log->target) && ($log->target->id!='0'))

                                  @if ($log->target_type == 'App\Models\User')
                                      <a href="{{ route('view/user', $log->target_id) }}">
                                          {{ $log->userlog->fullName() }}
                                      </a>
                                  @elseif ($log->target_type == 'App\Models\Asset')
                                      <a href="{{ route('view/hardware', $log->target_id) }}">
                                          {{ $log->userlog->showAssetName() }}
                                      </a>
                                  @endif


                              @elseif ($log->action_type=='uploaded')

                                  {{ $log->filename }}

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
                          {{ trans('general.unknown_admin') }}
                          @endif
                          </td>
                          <td>{{ trans('general.created_asset') }}</td>
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
          </div>

        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
  </div>
  <!-- /.col -->


</div>
<!-- /.row -->


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

		<p>{{ trans('admin/licenses/general.filetype_info') }}</p>

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
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
        <button type="submit" class="btn btn-primary btn-sm">{{ trans('button.upload') }}</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

@stop
