@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/hardware/general.view') }} {{ $asset->asset_tag }}
@parent
@stop

{{-- Right header --}}
@section('header_right')

@can('manage', \App\Models\Asset::class)
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
    @if (($asset->assetstatus) && ($asset->assetstatus->deployable=='1'))
      @if ($asset->assigned_to != '')
        @can('checkin', \App\Models\Asset::class)
      <li role="presentation"><a href="{{ route('checkin/hardware', $asset->id) }}">{{ trans('admin/hardware/general.checkin') }}</a></li>
          @endcan
      @else
       @can('checkout', \App\Models\Asset::class)
      <li role="presentation"><a href="{{ route('checkout/hardware', $asset->id)  }}">{{ trans('admin/hardware/general.checkout') }}</a></li>
          @endcan
      @endif
    @endif
      @can('update', \App\Models\Asset::class)
    <li role="presentation"><a href="{{ route('hardware.edit', $asset->id) }}">{{ trans('admin/hardware/general.edit') }}</a></li>
      @endcan
      @can('create', \App\Models\Asset::class)
    <li role="presentation"><a href="{{ route('clone/hardware', $asset->id) }}">{{ trans('admin/hardware/general.clone') }}</a></li>
      @endcan
      @can('audit', \App\Models\Asset::class)
      <li role="presentation"><a href="{{ route('asset.audit.create', $asset->id)  }}">{{ trans('general.audit') }}</a></li>
     @endcan
  </ul>
</div>
@endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row">

  @if (!$asset->model)
    <div class="col-md-12">
      <div class="callout callout-danger">
        <h4>NO MODEL ASSOCIATED</h4>
        <p>This will break things in weird and horrible ways. Edit this asset now to assign it a model. </p>
      </div>
    </div>
  @endif

  @if ($asset->deleted_at!='')
    <div class="col-md-12">
      <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>WARNING: </strong>
        This asset has been deleted.
        You must <a href="{{ route('restore/hardware', $asset->id) }}">restore it</a> before you can assign it to someone.
      </div>
    </div>
  @endif

  <div class="col-md-12">




    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#details" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-info-circle"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.details') }}</span></a>
        </li>
        <li>
          <a href="#software" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-floppy-o"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}</span></a>
        </li>
        <li>
          <a href="#components" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-hdd-o"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.components') }}</span></a>
        </li>
        <li>
          <a href="#assets" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-barcode"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}</span></a>
        </li>
        <li>
          <a href="#maintenances" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-wrench"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.maintenances') }}</span></a>
        </li>
        <li>
          <a href="#history" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-history"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span></a>
        </li>
        <li>
          <a href="#files" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-files-o"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.files') }}</span></a>
        </li>
        <li class="pull-right">
          <!-- <a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip"></i> </a> -->
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade in active" id="details">
          <div class="row">
            <div class="col-md-8">
              <div class="table-responsive" style="margin-top: 10px;">
                <table class="table">
                  <tbody>
                    @if ($asset->assetstatus)
                    <tr>
                      <td>{{ trans('general.status') }}</td>
                      <td>

                        @if (($asset->assignedTo) && ($asset->deleted_at==''))
                          <i class="fa fa-circle text-blue"></i>
                          {{ $asset->assetstatus->name }}
                          <label class="label label-default">{{ trans('general.deployed') }}</label>

                          <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                          {!!  $asset->assignedTo->present()->glyph()  !!}
                          {!!  $asset->assignedTo->present()->nameUrl() !!}
                        @else
                          @if (($asset->assetstatus) && ($asset->assetstatus->deployable=='1'))
                            <i class="fa fa-circle text-green"></i>
                          @elseif (($asset->assetstatus) && ($asset->assetstatus->pending=='1'))
                              <i class="fa fa-circle text-orange"></i>
                          @elseif (($asset->assetstatus) && ($asset->assetstatus->archived=='1'))
                            <i class="fa fa-times text-red"></i>
                          @endif
                            <a href="{{ route('statuslabels.show', $asset->assetstatus->id) }}">
                              {{ $asset->assetstatus->name }}</a>
                            <label class="label label-default">{{ $asset->present()->statusMeta }}</label>

                        @endif
                      </td>
                    </tr>
                    @endif

                    @if ($asset->company)
                    <tr>
                      <td>{{ trans('general.company') }}</td>
                      <td><a href="{{ url('/companies/' . $asset->company->id) }}">{{ $asset->company->name }}</a></td>
                    </tr>
                    @endif

                    @if ($asset->name)
                    <tr>
                      <td>{{ trans('admin/hardware/form.name') }}</td>
                      <td>{{ $asset->name }}</td>
                    </tr>
                    @endif

                    @if ($asset->serial)
                    <tr>
                      <td>{{ trans('admin/hardware/form.serial') }}</td>
                      <td>{{ $asset->serial  }}</td>
                    </tr>
                    @endif
                    @if ((isset($audit_log)) && ($audit_log->created_at))
                      <tr>
                        <td>{{ trans('general.last_audit') }}</td>
                        <td> {{ \App\Helpers\Helper::getFormattedDateObject($audit_log->created_at, 'date', false) }} (by {{ link_to_route('users.show', $audit_log->user->present()->fullname(), [$audit_log->user->id]) }})</td>
                      </tr>
                    @endif
                    @if ($asset->next_audit_date)
                      <tr>
                        <td>{{ trans('general.next_audit_date') }}</td>
                        <td> {{ \App\Helpers\Helper::getFormattedDateObject($asset->next_audit_date, 'date', false) }}</td>
                      </tr>
                    @endif

                    @if (($asset->model) && ($asset->model->manufacturer))
                    <tr>
                      <td>{{ trans('admin/hardware/form.manufacturer') }}</td>
                      <td>
                        <ul class="list-unstyled" style="line-height: 25px;">
                        @can('view', \App\Models\Manufacturer::class)

                          <li><a href="{{ route('manufacturers.show', $asset->model->manufacturer->id) }}">
                          {{ $asset->model->manufacturer->name }}</li>
                          </a>
                        @else
                         <li> {{ $asset->model->manufacturer->name }}</li>
                        @endcan

                      @if (($asset->model) && ($asset->model->manufacturer->url))
                            <li><i class="fa fa-globe"></i> <a href="{{ $asset->model->manufacturer->url }}">{{ $asset->model->manufacturer->url }}</a></li>
                      @endif

                      @if (($asset->model) && ($asset->model->manufacturer->support_url))
                            <li><i class="fa fa-life-ring"></i> <a href="{{ $asset->model->manufacturer->support_url }}">{{ $asset->model->manufacturer->support_url }}</a></li>
                       @endif

                       @if (($asset->model) && ($asset->model->manufacturer->support_phone))
                            <li><i class="fa fa-phone"></i>
                              <a href="tel:{{ $asset->model->manufacturer->support_phone }}">{{ $asset->model->manufacturer->support_phone }}</a>
                            </li>
                       @endif

                       @if (($asset->model) && ($asset->model->manufacturer->support_email))
                            <li><i class="fa fa-envelope"></i> <a href="mailto:{{ $asset->model->manufacturer->support_email }}">{{ $asset->model->manufacturer->support_email }}</a></li>
                       @endif
                        </ul>
                      </td>
                    </tr>
                    @endif

                    <tr>
                      <td>
                        {{ trans('general.category') }}</td>
                      <td>
                        @if (($asset->model) && ($asset->model->category))

                          @can('view', \App\Models\Category::class)

                            <a href="{{ route('categories.show', $asset->model->category->id) }}">
                              {{ $asset->model->category->name }}
                            </a>
                          @else
                            {{ $asset->model->category->name }}
                          @endcan
                        @else
                          Invalid category
                        @endif

                      </td>
                    </tr>

                    
                    <tr>
                      <td>
                        {{ trans('admin/hardware/form.model') }}
                      </td>
                      <td>

                      @if ($asset->model)

                           @can('view', \App\Models\AssetModel::class)
                            <a href="{{ route('models.show', $asset->model->id) }}">
                              {{ $asset->model->name }}
                            </a>
                          @else
                            {{ $asset->model->name }}
                          @endcan

                        @endif
                      </td>
                    </tr>


                    <tr>
                      <td>{{ trans('admin/models/table.modelnumber') }}</td>
                      <td>
                        {{ ($asset->model) ? $asset->model->model_number : ''}}
                      </td>
                    </tr>


                    @if (($asset->model) && ($asset->model->fieldset))
                      @foreach($asset->model->fieldset->fields as $field)
                        <tr>
                          <td>
                            {{ $field->name }}
                          </td>
                          <td>
                            @if ($field->field_encrypted=='1')
                              <i class="fa fa-lock" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/custom_fields/general.value_encrypted') }}"></i>
                            @endif

                            @if ($field->isFieldDecryptable($asset->{$field->db_column_name()} ))
                              @can('superuser')
                                @if (($field->format=='URL') && ($asset->{$field->db_column_name()}!=''))
                                  <a href="{{ \App\Helpers\Helper::gracefulDecrypt($field, $asset->{$field->db_column_name()}) }}" target="_new">{{ \App\Helpers\Helper::gracefulDecrypt($field, $asset->{$field->db_column_name()}) }}</a>
                                @else
                                  {{ \App\Helpers\Helper::gracefulDecrypt($field, $asset->{$field->db_column_name()}) }}
                                @endif
                              @else
                                  {{ strtoupper(trans('admin/custom_fields/general.encrypted')) }}
                              @endcan

                            @else
                              @if (($field->format=='URL') && ($asset->{$field->db_column_name()}!=''))
                                <a href="{{ $asset->{$field->db_column_name()} }}" target="_new">{{ $asset->{$field->db_column_name()} }}</a>
                              @else
                                {{ $asset->{$field->db_column_name()} }}
                              @endif
                            @endif
                           </td>
                        </tr>
                      @endforeach
                    @endif

                    @if ($asset->purchase_date)
                      <tr>
                        <td>{{ trans('admin/hardware/form.date') }}</td>
                        <td>
                          {{ \App\Helpers\Helper::getFormattedDateObject($asset->purchase_date, 'date', false) }}
                        </td>
                      </tr>
                    @endif

                    @if ($asset->purchase_cost)
                      <tr>
                        <td>{{ trans('admin/hardware/form.cost') }}</td>
                        <td>
                          @if (($asset->id) && ($asset->location))
                            {{ $asset->location->currency }}
                          @elseif (($asset->id) && ($asset->location))
                            {{ $asset->location->currency }}
                          @else
                            {{ $snipeSettings->default_currency }}
                          @endif
                          {{ \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost)}}


                        </td>
                      </tr>
                    @endif
                    @if ($asset->order_number)
                      <tr>
                        <td>{{ trans('general.order_number') }}</td>
                        <td>
                          #{{ $asset->order_number }}
                        </td>
                      </tr>
                    @endif

                    @if ($asset->supplier)
                      <tr>
                        <td>{{ trans('general.supplier') }}</td>
                        <td>
                          @can ('superuser')
                            <a href="{{ route('suppliers.show', $asset->supplier_id) }}">
                              {{ $asset->supplier->name }}
                            </a>
                          @else
                            {{ $asset->supplier->name }}
                          @endcan
                        </td>
                      </tr>
                    @endif

                    @if ($asset->warranty_months)
                      <tr {!! $asset->present()->warrantee_expires() < date("Y-m-d") ? ' class="warning"' : '' !!}>
                        <td>{{ trans('admin/hardware/form.warranty') }}</td>
                        <td>
                          {{ $asset->warranty_months }}
                          {{ trans('admin/hardware/form.months') }}

                          ({{ trans('admin/hardware/form.expires') }}
                          {{ $asset->present()->warrantee_expires() }})
                        </td>
                      </tr>
                    @endif

                    @if (($asset->model) && ($asset->depreciation))
                      <tr>
                        <td>{{ trans('general.depreciation') }}</td>
                        <td>
                          {{ $asset->depreciation->name }}
                          ({{ $asset->depreciation->months }}
                          {{ trans('admin/hardware/form.months') }}
                          )
                        </td>
                      </tr>
                      <tr>
                        <td>
                          {{ trans('admin/hardware/form.fully_depreciated') }}
                        </td>
                        <td>
                          @if ($asset->time_until_depreciated()->y > 0)
                           {{ $asset->time_until_depreciated()->y }}
                           {{ trans('admin/hardware/form.years') }},
                          @endif
                          {{ $asset->time_until_depreciated()->m }}
                          {{ trans('admin/hardware/form.months') }}
                          ({{ $asset->depreciated_date()->format('Y-m-d') }})
                        </td>
                      </tr>
                    @endif

                    @if (($asset->model) && ($asset->model->eol))
                      <tr>
                        <td>{{ trans('admin/hardware/form.eol_rate') }}</td>
                        <td>
                          {{ $asset->model->eol }}
                          {{ trans('admin/hardware/form.months') }}

                          (
                          {{ trans('admin/hardware/form.eol_date') }}:
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

                        </td>
                      </tr>
                    @endif



                    @if ($asset->expected_checkin!='')
                      <tr>
                        <td>{{ trans('admin/hardware/form.expected_checkin') }}</td>
                        <td>
                          {{ \App\Helpers\Helper::getFormattedDateObject($asset->expected_checkin, 'date', false) }}
                        </td>
                      </tr>
                    @endif

                    <tr>
                      <td>{{ trans('admin/hardware/form.notes') }}</td>
                      <td> {!! nl2br(e($asset->notes)) !!}</td>
                    </tr>

                    @if ($asset->location)
                      <tr>
                        <td>{{ trans('general.location') }}</td>
                        <td>
                          @can('superuser')
                            <a href="{{ route('locations.show', ['location' => $asset->location->id]) }}">
                              {{ $asset->location->name }}
                            </a>
                          @else
                            {{ $asset->location->name }}
                          @endcan
                        </td>
                      </tr>
                    @endif

                    @if ($asset->defaultLoc)
                      <tr>
                        <td>{{ trans('admin/hardware/form.default_location') }}</td>
                        <td>
                          @can('superuser')
                            <a href="{{ route('locations.show', ['location' => $asset->defaultLoc->id]) }}">
                              {{ $asset->defaultLoc->name }}
                            </a>
                          @else
                            {{ $asset->defaultLoc->name }}
                          @endcan
                        </td>
                      </tr>
                    @endif

                    @if ($asset->created_at!='')
                      <tr>
                        <td>{{ trans('general.created_at') }}</td>
                        <td>
                          {{ \App\Helpers\Helper::getFormattedDateObject($asset->created_at, 'datetime', false) }}
                        </td>
                      </tr>
                    @endif

                    @if ($asset->updated_at!='')
                      <tr>
                        <td>{{ trans('general.updated_at') }}</td>
                        <td>
                          {{ \App\Helpers\Helper::getFormattedDateObject($asset->updated_at, 'datetime', false) }}
                        </td>
                      </tr>
                    @endif

                    <tr>
                      <td>{{ trans('general.checkouts_count') }}</td>
                      <td>
                       {{ ($asset->checkouts) ? (int) $asset->checkouts->count() : '0' }}
                      </td>
                    </tr>

                    <tr>
                      <td>{{ trans('general.checkins_count') }}</td>
                      <td>
                        {{ ($asset->checkins) ? (int) $asset->checkins->count() : '0' }}
                      </td>
                    </tr>

                    <tr>
                      <td>{{ trans('general.user_requests_count') }}</td>
                      <td>
                        {{ ($asset->userRequests) ? (int) $asset->userRequests->count() : '0' }}
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div> <!-- /table-responsive -->
            </div><!-- /col-md-8 -->

            <div class="col-md-4">
              @if ($asset->image)
                <img src="{{ url('/') }}/uploads/assets/{{{ $asset->image }}}" class="assetimg img-responsive">
              @elseif (($asset->model) && ($asset->model->image!=''))
                <img src="{{ url('/') }}/uploads/models/{{{ $asset->model->image }}}" class="assetimg img-responsive">
              @endif

              @if  ($snipeSettings->qr_code=='1')
                 <img src="{{ config('app.url') }}/hardware/{{ $asset->id }}/qr_code" class="img-thumbnail pull-right" style="height: 100px; width: 100px; margin-right: 10px;">
              @endif

              @if (($asset->assignedTo) && ($asset->deleted_at==''))
                <h4>{{ trans('admin/hardware/form.checkedout_to') }}</h4>
                <p>
                  @if($asset->checkedOutToUser()) <!-- Only users have avatars currently-->
                  <img src="{{ $asset->assignedTo->present()->gravatar() }}" class="user-image-inline" alt="{{ $asset->assignedTo->present()->fullName() }}">
                  @endif
                  {!! $asset->assignedTo->present()->glyph() . ' ' .$asset->assignedTo->present()->nameUrl() !!}
                </p>

                  <ul class="list-unstyled" style="line-height: 25px;">
                  @if ((isset($asset->assignedTo->email)) && ($asset->assignedTo->email!=''))
                    <li><i class="fa fa-envelope-o"></i> <a href="mailto:{{ $asset->assignedTo->email }}">{{ $asset->assignedTo->email }}</a></li>
                  @endif

                  @if ((isset($asset->assignedTo)) && ($asset->assignedTo->phone!=''))
                    <li>
                      <i class="fa fa-phone"></i>
                      <a href="tel:{{ $asset->assignedTo->phone }}">{{ $asset->assignedTo->phone }}</a>
                    </li>
                  @endif

                  @if (isset($asset->location))
                    <li>{{ $asset->location->name }}</li>
                    <li>{{ $asset->location->address }}
                      @if ($asset->location->address2!='')
                      {{ $asset->location->address2 }}
                      @endif
                    </li>

                    <li>{{ $asset->location->city }}
                      @if (($asset->location->city!='') && ($asset->location->state!=''))
                          ,
                      @endif
                      {{ $asset->location->state }} {{ $asset->location->zip }}
                    </li>
                    @endif
                </ul>

	          @endif
            </div> <!-- div.col-md-4 -->
          </div><!-- /row -->
        </div><!-- /.tab-pane asset details -->

        <div class="tab-pane fade" id="software">
          <div class="row">
            <div class="col-md-12">
              <!-- Licenses assets table -->
              @if ($asset->licenses->count() > 0)
                <table class="table">
                  <thead>
                    <tr>
                      <th class="col-md-4">{{ trans('general.name') }}</th>
                      <th class="col-md-4"><span class="line"></span>{{ trans('admin/licenses/form.license_key') }}</th>
                      <th class="col-md-1"><span class="line"></span>{{ trans('table.actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($asset->licenseseats as $seat)
                    <tr>
                      <td><a href="{{ route('licenses.show', $seat->license->id) }}">{{ $seat->license->name }}</a></td>
                      <td>
                          @can('viewKeys', $seat->license)
                            {!! nl2br(e($seat->license->serial)) !!}
                          @else
                           ------------
                          @endcan
                      </td>
                      <td>
                        <a href="{{ route('licenses.checkin', $seat->id) }}" class="btn btn-sm bg-purple" data-tooltip="true">{{ trans('general.checkin') }}</a>
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
            </div><!-- /col -->
          </div> <!-- row -->
        </div> <!-- /.tab-pane software -->

        <div class="tab-pane fade" id="components">
          <!-- checked out assets table -->
          <div class="row">
              <div class="col-md-12">
                @if($asset->components->count() > 0)
                  <table class="table table-striped">
                    <thead>
                      <th>{{ trans('general.name') }}</th>
                      <th>{{ trans('general.qty') }}</th>
                      <th>{{ trans('general.purchase_cost') }}</th>
                    </thead>
                    <tbody>
                      <?php $totalCost = 0; ?>
                      @foreach ($asset->components as $component)
                        @if (is_null($component->deleted_at))
                          <tr>
                            <td>
                              <a href="{{ route('components.show', $component->id) }}">{{ $component->name }}</a>
                            </td>
                            <td>{{ $component->pivot->assigned_qty }}</td>
                            <td>{{ $component->purchase_cost }}</td>

                          </tr>
                        @endif
                      @endforeach
                    </tbody>

                    <tfoot>
                      <tr>
                        <td colspan="7" class="text-right">{{ $use_currency.$totalCost }}</td>
                      </tr>
                    </tfoot>
                  </table>
                @else
                  <div class="alert alert-info alert-block">
                    <i class="fa fa-info-circle"></i>
                    {{ trans('general.no_results') }}
                  </div>
                @endif
              </div>
          </div>
        </div> <!-- /.tab-pane components -->


        <div class="tab-pane fade" id="assets">
          <div class="row">
            <div class="col-md-12">
              {{ Form::open([
                        'method' => 'POST',
                        'route' => ['hardware/bulkedit'],
                        'class' => 'form-inline',
                         'id' => 'bulkForm']) }}
              <div id="toolbar">
                <select name="bulk_actions" class="form-control select2" style="width: 150px;">
                  <option value="edit">Edit</option>
                  <option value="delete">Delete</option>
                  <option value="labels">Generate Labels</option>
                </select>
                <button class="btn btn-primary" id="bulkEdit" disabled>Go</button>
              </div>

              <!-- checked out assets table -->
              <div class="table-responsive">

                <table
                        data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                        data-cookie-id-table="assetsTable"
                        data-pagination="true"
                        data-id-table="assetsTable"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        id="assetsListingTable"
                        class="table table-striped snipe-table"
                        data-url="{{route('api.assets.index',['assigned_to' => $asset->id, 'assigned_type' => 'App\Models\Asset']) }}"
                        data-export-options='{
                              "fileName": "export-assets-{{ str_slug($asset->name) }}-assets-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>

                </table>


                {{ Form::close() }}
              </div>
            </div><!-- /col -->
          </div> <!-- row -->
        </div> <!-- /.tab-pane software -->


        <div class="tab-pane fade" id="maintenances">
          <div class="row">
            <div class="col-md-12">
                @can('update', \App\Models\Asset::class)
                <div id="maintenance-toolbar">
                  <a href="{{ route('maintenances.create', ['asset_id' => $asset->id]) }}" class="btn btn-primary">Add Maintenance</a>
                </div>
                @endcan

              <!-- Asset Maintenance table -->
                <table
                        data-columns="{{ \App\Presenters\AssetMaintenancesPresenter::dataTableLayout() }}"
                        class="table table-striped snipe-table"
                        id="assetMaintenancesTable"
                        data-pagination="true"
                        data-id-table="assetMaintenancesTable"
                        data-search="true"
                        data-side-pagination="server"
                        data-toolbar="#maintenance-toolbar"
                        data-show-columns="true"
                        data-show-refresh="true"
                        data-show-export="true"
                        data-export-options='{
                           "fileName": "export-{{ $asset->asset_tag }}-maintenances",
                           "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                         }'
                        data-url="{{ route('api.maintenances.index', array('asset_id' => $asset->id)) }}"
                        data-cookie-id-table="assetMaintenancesTable">
                </table>
            </div> <!-- /.col-md-12 -->
          </div> <!-- /.row -->
        </div> <!-- /.tab-pane maintenances -->

        <div class="tab-pane fade" id="history">
          <!-- checked out assets table -->
          <div class="row">
            <div class="col-md-12">
              <table
                      class="table table-striped snipe-table"
                      id="assetHistory"
                      data-pagination="true"
                      data-id-table="assetHistory"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-refresh="true"
                      data-sort-order="desc"
                      data-sort-name="created_at"
                      data-show-export="true"
                      data-export-options='{
                         "fileName": "export-asset-{{  $asset->id }}-history",
                         "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                       }'

                      data-url="{{ route('api.activity.index', ['item_id' => $asset->id, 'item_type' => 'asset']) }}"
                      data-cookie-id-table="assetHistory">
                <thead>
                <tr>
                  <th data-field="icon" data-visible="true" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"></th>
                  <th class="col-sm-2" data-visible="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  <th class="col-sm-1" data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                  <th class="col-sm-1" data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                  <th class="col-sm-2" data-field="note">{{ trans('general.notes') }}</th>
                  @if  ($snipeSettings->require_accept_signature=='1')
                    <th class="col-md-3" data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">{{ trans('general.signature') }}</th>
                  @endif
                  <th class="col-md-3" data-visible="false" data-field="file" data-visible="false"  data-formatter="fileUploadFormatter">{{ trans('general.download') }}</th>
                  <th class="col-sm-2" data-field="log_meta" data-visible="true" data-formatter="changeLogFormatter">Changed</th>
                </tr>
                </thead>
              </table>

            </div>
          </div> <!-- /.row -->
        </div> <!-- /.tab-pane history -->

        <div class="tab-pane fade" id="files">
          <div class="row">

            @can('update', \App\Models\Asset::class)
              {{ Form::open([
              'method' => 'POST',
              'route' => ['upload/asset', $asset->id],
              'files' => true, 'class' => 'form-horizontal' ]) }}

              <div class="col-md-2">
                <span class="btn btn-default btn-file">Browse for file...
                    {{ Form::file('assetfile[]', ['multiple' => 'multiple']) }}
                </span>
              </div>
              <div class="col-md-7">
                {{ Form::text('notes', Input::old('notes', Input::old('notes')), array('class' => 'form-control','placeholder' => 'Notes')) }}
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">{{ trans('button.upload') }}</button>
              </div>

              <div class="col-md-12">
                <p>{{ trans('general.upload_filetypes_help', ['size' => \App\Helpers\Helper::file_upload_max_size_readable()]) }}</p>
                <hr>
              </div>

              {{ Form::close() }}
            @endcan

            <div class="col-md-12">
              <table
                      class="table table-striped snipe-table"
                      id="assetFileHistory"
                      data-pagination="true"
                      data-id-table="assetFileHistory"
                      data-search="true"
                      data-side-pagination="client"
                      data-show-columns="true"
                      data-show-refresh="true"
                      data-sort-order="desc"
                      data-sort-name="created_at"
                      data-show-export="true"
                      data-export-options='{
                         "fileName": "export-asset-{{ $asset->id }}-files",
                         "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                       }'
                      data-cookie-id-table="assetFileHistory">
                <thead>
                  <tr>
                    <th data-visible="true"></th>
                    <th class="col-md-2" data-searchable="true" data-visible="true">{{ trans('general.notes') }}</th>
                    <th class="col-md-2" data-searchable="true" data-visible="true">{{ trans('general.image') }}</th>
                    <th class="col-md-2" data-searchable="true" data-visible="true">{{ trans('general.file_name') }}</th>
                    <th class="col-md-2" data-searchable="true" data-visible="true">{{ trans('general.download') }}</th>
                    <th class="col-md-1" data-searchable="true" data-visible="true">{{ trans('general.actions') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($asset->uploads->count() > 0)
                    @foreach ($asset->uploads as $file)
                      <tr>
                        <td><i class="{{ \App\Helpers\Helper::filetype_icon($file->filename) }} icon-med"></i></td>
                        <td>
                          @if ($file->note)
                          {{ $file->note }}
                          @endif
                        </td>
                        <td>
                          @if ( \App\Helpers\Helper::checkUploadIsImage($file->get_src('assets')))
                            <a href="{{ route('show/assetfile', ['assetId' => $asset->id, 'fileId' =>$file->id]) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show/assetfile', ['assetId' => $asset->id, 'fileId' =>$file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                          @endif
                        </td>
                        <td>
                          {{ $file->filename }}
                        </td>
                        <td>
                          @if ($file->filename)
                          <a href="{{ route('show/assetfile', [$asset->id, $file->id]) }}" class="btn btn-default"><i class="fa fa-download"></i></a>
                          @endif
                        </td>
                        <td>
                          @can('update', \App\Models\Asset::class)
                            <a class="btn delete-asset btn-sm btn-danger btn-sm" href="{{ route('delete/assetfile', [$asset->id, $file->id]) }}" data-tooltip="true" data-title="Delete" data-content="{{ trans('delete_confirm', ['item' => $file->filename]) }}"><i class="fa fa-trash icon-white"></i></a>
                          @endcan
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
            </div> <!-- /.col-md-12 -->
          </div> <!-- /.row -->
        </div> <!-- /.tab-pane files -->
      </div> <!-- /. tab-content -->
    </div> <!-- /.nav-tabs-custom -->
  </div> <!-- /. col-md-12 -->
</div> <!-- /. row -->
@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')

<script nonce="{{ csrf_token() }}">
    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>

@stop
