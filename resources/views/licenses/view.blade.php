@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.view') }}
 - {{ $license->name }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">

    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      
      <ul class="nav nav-tabs hidden-print">

        <li class="active">
          <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-info-circle fa-2x" aria-hidden="true"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.info') }}</span>
          </a>
        </li>

        <li>
          <a href="#seats" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="far fa-list-alt fa-2x" aria-hidden="true"></i>
              </span>
              <span class="hidden-xs hidden-sm">{{ trans('admin/licenses/form.seats') }}</span>
              <span class="badge badge-secondary">{{ number_format($license->availCount()->count()) }} / {{ number_format($license->seats) }}</span>

            </a>
        </li>

        @can('licenses.files', $license)
        <li>
          <a href="#files" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-file fa-2x" aria-hidden="true"></i></span>
            <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}
              {!! ($license->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($license->uploads->count()).'</badge>' : '' !!}
            </span>
          </a>
        </li>
        @endcan

        <li>
          <a href="#history" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-history fa-2x" aria-hidden="true"></i></span>
            <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span>
          </a>
        </li>

    
        @can('update', $license)
          <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fas fa-cog" aria-hidden="true"></i> {{ trans('button.actions') }}
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('licenses.edit', $license->id) }}">{{ trans('admin/licenses/general.edit') }}</a></li>
              <li><a href="{{ route('clone/license', $license->id) }}">{{ trans('admin/licenses/general.clone') }}</a></li>
            </ul>
          </li>
        @endcan

        @can('update', \App\Models\License::class)
          <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal">
              <i class="fas fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}</a>
          </li>
        @endcan
      </ul>

      <div class="tab-content">

        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-12">
              <div class="container row-new-striped">

                @if (!is_null($license->company))
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('general.company') }}</strong>
                    </div>
                    <div class="col-md-9">
                      <a href="{{ route('companies.show', $license->company->id) }}">{{ $license->company->name }}</a>
                    </div>
                  </div>
                @endif

                @if ($license->manufacturer)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('admin/hardware/form.manufacturer') }}</strong>
                    </div>
                    <div class="col-md-9">
                      @can('view', \App\Models\Manufacturer::class)
                        <a href="{{ route('manufacturers.show', $license->manufacturer->id) }}">
                          {{ $license->manufacturer->name }}
                        </a>
                      @else
                        {{ $license->manufacturer->name }}
                      @endcan

                      @if ($license->manufacturer->url)
                        <br><i class="fas fa-globe-americas" aria-hidden="true"></i> <a href="{{ $license->manufacturer->url }}" rel="noopener">{{ $license->manufacturer->url }}</a>
                      @endif

                      @if ($license->manufacturer->support_url)
                        <br><i class="far fa-life-ring" aria-hidden="true"></i>
                        <a href="{{ $license->manufacturer->support_url }}"  rel="noopener">{{ $license->manufacturer->support_url }}</a>
                      @endif

                      @if ($license->manufacturer->support_phone)
                        <br><i class="fas fa-phone" aria-hidden="true"></i>
                        <a href="tel:{{ $license->manufacturer->support_phone }}">{{ $license->manufacturer->support_phone }}</a>
                      @endif

                      @if ($license->manufacturer->support_email)
                        <br><i class="far fa-envelope" aria-hidden="true"></i> <a href="mailto:{{ $license->manufacturer->support_email }}">{{ $license->manufacturer->support_email }}</a>
                      @endif
                    </div>
                  </div>
                @endif


                @if (!is_null($license->serial))
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('admin/licenses/form.license_key') }}</strong>
                    </div>
                    <div class="col-md-9">
                      @can('viewKeys', $license)
                        {!! nl2br(e($license->serial)) !!}
                      @else
                        ------------
                      @endcan
                    </div>
                  </div>
                @endif


                @if ($license->category)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('general.category') }}</strong>
                    </div>
                    <div class="col-md-9">
                      <a href="{{ route('categories.show', $license->category->id) }}">{{ $license->category->name }}</a>
                    </div>
                  </div>
                @endif


                @if ($license->license_name!='')
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('admin/licenses/form.to_name') }}</strong>
                    </div>
                    <div class="col-md-9">
                      {{ $license->license_name }}
                    </div>
                  </div>
                @endif

                @if ($license->license_email!='')
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('admin/licenses/form.to_email') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {{ $license->license_email }}
                    </div>
                  </div>
                @endif


                @if ($license->supplier_id)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('general.supplier') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      <a href="{{ route('suppliers.show', $license->supplier_id) }}">
                        {{ $license->supplier->name }}
                      </a>
                    </div>
                  </div>
                @endif


                @if (isset($license->expiration_date))
                <div class="row">
                  <div class="col-md-3">
                    <strong>
                      {{ trans('admin/licenses/form.expiration') }}
                    </strong>
                  </div>
                  <div class="col-md-9">
                    {{ Helper::getFormattedDateObject($license->expiration_date, 'date', false) }}
                  </div>
                </div>
                @endif

                @if ($license->termination_date)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('admin/licenses/form.termination_date') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {{ Helper::getFormattedDateObject($license->termination_date, 'date', false) }}
                    </div>
                  </div>
                @endif


                @if ($license->depreciation)
                <div class="row">
                  <div class="col-md-3">
                    <strong>
                      {{ trans('admin/hardware/form.depreciation') }}
                    </strong>
                  </div>
                  <div class="col-md-9">
                    {{ $license->depreciation->name }}
                    ({{ $license->depreciation->months }}
                    {{ trans('admin/hardware/form.months') }}
                    )
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <strong>
                      {{ trans('admin/hardware/form.depreciates_on') }}
                    </strong>
                  </div>
                  <div class="col-md-9">
                    {{ Helper::getFormattedDateObject($license->depreciated_date(), 'date', false) }}
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-3">
                    <strong>
                      {{ trans('admin/hardware/form.fully_depreciated') }}
                    </strong>
                  </div>
                  <div class="col-md-9">
                    @if ($license->time_until_depreciated()->y > 0)
                      {{ $license->time_until_depreciated()->y }}
                      {{ trans('admin/hardware/form.years') }},
                    @endif
                    {{ $license->time_until_depreciated()->m }}
                    {{ trans('admin/hardware/form.months') }}
                  </div>
                </div>
                @endif

                  @if ($license->purchase_order)
                <div class="row">
                  <div class="col-md-3">
                    <strong>
                      {{ trans('admin/licenses/form.purchase_order') }}
                    </strong>
                  </div>
                  <div class="col-md-9">
                    {{ $license->purchase_order }}
                  </div>
                </div>
                  @endif


                @if (isset($license->purchase_date))
                <div class="row">
                  <div class="col-md-3">
                    <strong>{{ trans('general.purchase_date') }}</strong>
                  </div>
                  <div class="col-md-9">
                    {{ Helper::getFormattedDateObject($license->purchase_date, 'date', false) }}

                  </div>
                </div>
                  @endif

                  @if ($license->purchase_cost > 0)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('general.purchase_cost') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {{ $snipeSettings->default_currency }}
                      {{ Helper::formatCurrencyOutput($license->purchase_cost) }}
                    </div>
                  </div>
                  @endif

                  @if ($license->order_number)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('general.order_number') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {{ $license->order_number }}
                    </div>
                  </div>
                  @endif

                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('admin/licenses/form.maintained') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {!! $license->maintained ? '<i class="fas fa-check text-success" aria-hidden="true"></i> '.trans('general.yes') : '<i class="fas fa-times text-danger" aria-hidden="true"></i> '.trans('general.no') !!}
                    </div>
                  </div>

                  @if (($license->seats) && ($license->seats) > 0)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('admin/licenses/form.seats') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {{ $license->seats }}
                    </div>
                  </div>
                  @endif



                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('admin/licenses/form.reassignable') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {{ $license->reassignable ? 'Yes' : 'No' }}
                    </div>
                  </div>


                  @if ($license->notes)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>
                        {{ trans('general.notes') }}
                      </strong>
                    </div>
                    <div class="col-md-9">
                      {!! nl2br(e($license->notes)) !!}
                    </div>
                  </div>
                  @endif

              </div> <!-- end row-striped -->
            </div>
            </div>
          </div> <!-- end tab-pane -->



        <div class="tab-pane" id="seats">
          <div class="row">
            <div class="col-md-12">

              <div class="table-responsive">

                <table
                        data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayoutSeats() }}"
                        data-cookie-id-table="seatsTable"
                        data-id-table="seatsTable"
                        id="seatsTable"
                        data-pagination="true"
                        data-search="false"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-fullscreen="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.licenses.seats.index', $license->id) }}"
                        data-export-options='{
                        "fileName": "export-seats-{{ str_slug($license->name) }}-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
                </table>

              </div>

            </div>

          </div> <!--/.row-->
        </div> <!-- /.tab-pane -->

        @can('licenses.files', $license)
        <div class="tab-pane" id="files">
          <div class="table-responsive">
            <table
                data-cookie-id-table="licenseUploadsTable"
                data-id-table="licenseUploadsTable"
                id="licenseUploadsTable"
                data-search="true"
                data-pagination="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-toolbar="#upload-toolbar"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                class="table table-striped snipe-table"
                data-export-options='{
                    "fileName": "export-license-uploads-{{ str_slug($license->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
            <thead>
              <tr>
                <th data-visible="true" data-field="icon" data-sortable="true">{{trans('general.file_type')}}</th>
                <th class="col-md-2" data-searchable="true" data-visible="true" data-field="image">{{ trans('general.image') }}</th>
                <th class="col-md-2" data-searchable="true" data-visible="true" data-field="filename" data-sortable="true">{{ trans('general.file_name') }}</th>
                <th class="col-md-1" data-searchable="true" data-visible="true" data-field="filesize">{{ trans('general.filesize') }}</th>
                <th class="col-md-2" data-searchable="true" data-visible="true" data-field="notes" data-sortable="true">{{ trans('general.notes') }}</th>
                <th class="col-md-1" data-searchable="true" data-visible="true" data-field="download">{{ trans('general.download') }}</th>
                <th class="col-md-2" data-searchable="true" data-visible="true" data-field="created_at" data-sortable="true">{{ trans('general.created_at') }}</th>
                <th class="col-md-1" data-searchable="true" data-visible="true" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
            <tbody>
            @if ($license->uploads->count() > 0)
              @foreach ($license->uploads as $file)
              <tr>
                <td>
                  <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                  <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>

                </td>
                <td>
                  @if ($file->filename)
                    @if ((Storage::exists('private_uploads/licenses/'.$file->filename)) && ( Helper::checkUploadIsImage($file->get_src('licenses'))))
                      <a href="{{ route('show.licensefile', ['licenseId' => $license->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show.licensefile', ['licenseId' => $license->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                    @endif
                  @endif
                </td>
                <td>
                  @if (Storage::exists('private_uploads/licenses/'.$file->filename))
                    {{ $file->filename }}
                  @else
                    <del>{{ $file->filename }}</del>
                  @endif
                </td>
                <td data-value="{{ (Storage::exists('private_uploads/licenses/'.$file->filename)) ? Storage::size('private_uploads/licenses/'.$file->filename) : '' }}">
                  {{ (Storage::exists('private_uploads/licenses/'.$file->filename)) ? Helper::formatFilesizeUnits(Storage::size('private_uploads/licenses/'.$file->filename)) : '' }}
                </td>

                <td>
                  @if ($file->note)
                    {{ $file->note }}
                  @endif
                </td>
                <td>
                  @if ($file->filename)
                    <a href="{{ route('show.licensefile', [$license->id, $file->id, 'download' => 'true']) }}" class="btn btn-default">
                      <i class="fas fa-download" aria-hidden="true"></i>
                      <span class="sr-only">{{ trans('general.download') }}</span>
                    </a>
                  @endif
                </td>
                <td>{{ $file->created_at }}</td>
                <td>
                  <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/licensefile', [$license->id, $file->id]) }}" data-content="{{ trans('general.delete_confirm', ['item' => $file->filename]) }}" data-title="{{ trans('general.delete') }}">
                    <i class="fas fa-trash icon-white" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('general.delete') }}</span>
                  </a>
                </td>
              </tr>
              @endforeach
            @else
              <tr>
              <td colspan="8">{{ trans('general.no_results') }}</td>
              </tr>
            @endif
            </tbody>
          </table>
          </div>
        </div> <!-- /.tab-pane -->
        @endcan

        <div class="tab-pane" id="history">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
              <table
                      class="table table-striped snipe-table"
                      data-cookie-id-table="licenseHistoryTable"
                      data-id-table="licenseHistoryTable"
                      id="licenseHistoryTable"
                      data-pagination="true"
                      data-show-columns="true"
                      data-side-pagination="server"
                      data-show-refresh="true"
                      data-show-export="true"
                      data-sort-order="desc"
                      data-export-options='{
                       "fileName": "export-{{ str_slug($license->name) }}-history-{{ date('Y-m-d') }}",
                       "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                     }'
                      data-url="{{ route('api.activity.index', ['item_id' => $license->id, 'item_type' => 'license']) }}">

                <thead>
                <tr>
                  <th class="col-sm-2" data-visible="false" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.record_created') }}</th>
                  <th class="col-sm-2"data-visible="true" data-sortable="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                  <th class="col-sm-2" data-sortable="true" data-visible="true" data-field="note">{{ trans('general.notes') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="action_date" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  @if  ($snipeSettings->require_accept_signature=='1')
                    <th class="col-md-3" data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">{{ trans('general.signature') }}</th>
                  @endif
                </tr>
                </thead>
              </table>
              </div>
            </div> <!-- /.col-md-12-->
          </div> <!-- /.row-->
        </div> <!-- /.tab-pane -->
      </div> <!-- /.tab-content -->
    </div> <!-- nav-tabs-custom -->
  </div>  <!-- /.col -->
</div> <!-- /.row -->

@can('update', \App\Models\License::class)
  @include ('modals.upload-file', ['item_type' => 'license', 'item_id' => $license->id])
@endcan

@stop


@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
