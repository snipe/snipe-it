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
  @can('update', $license)
    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="{{ route('licenses.edit', ['license' => $license->id]) }}">{{ trans('admin/licenses/general.edit') }}</a></li>
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
        <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
        <li><a href="#uploads" data-toggle="tab">{{ trans('general.file_uploads') }}</a></li>
        <li><a href="#history" data-toggle="tab">{{ trans('admin/licenses/general.checkout_history') }}</a></li>
        <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip"></i> {{ trans('button.upload') }}</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-8">

              <div class="table-responsive">

                <table
                        data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayoutSeats() }}"
                        data-cookie-id-table="seatsTable"
                        data-pagination="true"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        id="seatsTable"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.license.seats',['license_id' => $license->id]) }}"
                        data-export-options='{
                        "fileName": "export-seats-{{ str_slug($license->name) }}-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
                </table>

              </div>

            </div>

            <div class="col-md-4">
              <div class="table">
                <table class="table">
                  <tbody>
                    @if (!is_null($license->company))
                    <tr>
                      <td>{{ trans('general.company') }}</td>
                      <td>{{ $license->company->name }}</td>
                    </tr>
                    @endif

                    @if ($license->manufacturer)
                      <tr>
                        <td>{{ trans('admin/hardware/form.manufacturer') }}:</td>
                        <td><p style="line-height: 23px;">
                          @can('view', \App\Models\Manufacturer::class)
                            <a href="{{ route('manufacturers.show', $license->manufacturer->id) }}">
                              {{ $license->manufacturer->name }}
                            </a>
                          @else
                            {{ $license->manufacturer->name }}
                          @endcan

                          @if ($license->manufacturer->url)
                            <br><i class="fa fa-globe"></i> <a href="{{ $license->manufacturer->url }}" rel="noopener">{{ $license->manufacturer->url }}</a>
                          @endif

                          @if ($license->manufacturer->support_url)
                            <br><i class="fa fa-life-ring"></i>
                              <a href="{{ $license->manufacturer->support_url }}"  rel="noopener">{{ $license->manufacturer->support_url }}</a>
                          @endif

                          @if ($license->manufacturer->support_phone)
                            <br><i class="fa fa-phone"></i>
                              <a href="tel:{{ $license->manufacturer->support_phone }}">{{ $license->manufacturer->support_phone }}</a>
                          @endif

                          @if ($license->manufacturer->support_email)
                            <br><i class="fa fa-envelope"></i> <a href="mailto:{{ $license->manufacturer->support_email }}">{{ $license->manufacturer->support_email }}</a>
                          @endif
                          </p>
                        </td>
                      </tr>
                    @endif


                      @if (!is_null($license->serial))
                      <tr>
                        <td>{{ trans('admin/licenses/form.license_key') }}: </td>
                        <td style="word-wrap: break-word;overflow-wrap: break-word;word-break: break-word;">
                          @can('viewKeys', $license)
                            {!! nl2br(e($license->serial)) !!}
                          @else
                           ------------
                          @endcan

                        </td>
                      </tr>
                      @endif


                    @if ($license->license_name!='')
                    <tr>
                      <td>{{ trans('admin/licenses/form.to_name') }}: </td>
                      <td>{{ $license->license_name }}</td>
                    </tr>
                    @endif

                    @if ($license->license_email!='')
                    <tr>
                      <td>{{ trans('admin/licenses/form.to_email') }}:</td>
                      <td>{{ $license->license_email }}</td>
                    </tr>
                    @endif

                    @if ($license->supplier_id)
                    <tr>
                      <td>{{ trans('general.supplier') }}:
                      </td>
                      <td>
                        <a href="{{ route('suppliers.show', $license->supplier_id) }}">
                          {{ $license->supplier->name }}
                        </a>
                      </td>
                    </tr>
                    @endif

                    @if (isset($license->expiration_date))
                    <tr>
                      <td>{{ trans('admin/licenses/form.expiration') }}:</td>
                      <td>{{ $license->expiration_date }}</td>
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

                    @if (isset($license->purchase_date))
                    <tr>
                      <td>{{ trans('general.purchase_date') }}:</td>
                      <td>{{ $license->purchase_date }}</td>
                    </tr>
                    @endif

                    @if ($license->purchase_cost > 0)
                    <tr>
                      <td>{{ trans('general.purchase_cost') }}:</td>
                      <td>
                        {{ $snipeSettings->default_currency }}
                        {{ \App\Helpers\Helper::formatCurrencyOutput($license->purchase_cost) }}
                      </td>
                    </tr>
                    @endif

                    @if ($license->order_number)
                    <tr>
                      <td>{{ trans('general.order_number') }}:</td>
                      <td>{{ $license->order_number }}</td>
                    </tr>
                    @endif

                    @if (($license->seats) && ($license->seats) > 0)
                    <tr>
                      <td>{{ trans('admin/licenses/form.seats') }}:</td>
                      <td>{{ $license->seats }}</td>
                    </tr>
                    @endif

                    <tr>
                      <td>{{ trans('admin/licenses/form.reassignable') }}:</td>
                      <td>{{ $license->reassignable ? 'Yes' : 'No' }}</td>
                    </tr>

                    @if ($license->notes)
                    <tr>
                      <td>{{ trans('general.notes') }}:</td>
                      <td>
                        {!! nl2br(e($license->notes)) !!}
                      </td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div> <!-- .table-->
            </div> <!--/.col-md-5-->
          </div> <!--/.row-->
        </div> <!-- /.tab-pane -->

        <div class="tab-pane" id="uploads">
          <div class="table-responsive">
            <div id="upload-toolbar">
              <a href="#" data-toggle="modal" data-target="#uploadFileModal" class="btn btn-default"><i class="fa fa-paperclip"></i> {{ trans('button.upload') }}</a>
            </div>

            <table
                data-cookie-id-table="licenseUploadsTable"
                data-pagination="true"
                data-id-table="assetsListingTable"
                data-search="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-footer="true"
                data-toolbar="#upload-toolbar"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="licenseUploadsTable"
                class="table table-striped snipe-table"
                data-export-options='{
                    "fileName": "export-license-uploads-{{ str_slug($license->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
            <thead>
              <tr>
                <th></th>
                <th class="col-md-4" data-field="file_name" data-visible="true"  data-sortable="true" data-switchable="true">{{ trans('general.file_name') }}</th>
                <th class="col-md-4" data-field="notes" data-visible="true" data-sortable="true" data-switchable="true">{{ trans('general.notes') }}</th>
                <th class="col-md-2" data-field="created_at" data-visible="true"  data-sortable="true" data-switchable="true">{{ trans('general.created_at') }}</th>
                <th class="col-md-2" data-field="download" data-visible="true"  data-sortable="false" data-switchable="true">Download</th>
                <th class="col-md-2" data-field="delete" data-visible="true"  data-sortable="false" data-switchable="true">Delete</th>
              </tr>
            </thead>
            <tbody>
            @if ($license->uploads->count()> 0)
              @foreach ($license->uploads as $file)
              <tr>
                <td><i class="{{ \App\Helpers\Helper::filetype_icon($file->filename) }} icon-med"></i></td>
                <td>
                  {{ $file->filename }}

                </td>
                <td>
                  @if ($file->note)
                    {{ $file->note }}
                  @endif
                </td>
                <td>{{ $file->created_at }}</td>
                <td>
                @if ($file->filename)
                    @if ( \App\Helpers\Helper::checkUploadIsImage($file->get_src('licenses')))
                      <a href="{{ route('show.licensefile', ['licenseId' => $license->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show.licensefile', ['licenseId' => $license->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                    @endif
                @endif
                </td>
                <td>
                  <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/licensefile', [$license->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?"><i class="fa fa-trash icon-white"></i></a>
                </td>
              </tr>
              @endforeach
            @else
              <tr>
              <td colspan="4">{{ trans('general.no_results') }}</td>
              </tr>
            @endif
            </tbody>
          </table>
          </div>
        </div> <!-- /.tab-pane -->

        <div class="tab-pane" id="history">
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
              <table
                      class="table table-striped snipe-table"
                      id="historyTable"
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
                      data-url="{{ route('api.activity.index', ['item_id' => $license->id, 'item_type' => 'license']) }}"
                      data-cookie-id-table="license-history">

                <thead>
                <tr>
                  <th class="col-sm-2" data-visible="true" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  <th class="col-sm-2"data-visible="true" data-sortable="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                  <th class="col-sm-2" data-sortable="true" data-visible="true" data-field="note">{{ trans('general.notes') }}</th>
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
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="modal-body">
          <p>{{ trans('general.upload_filetypes_help', ['size' => \App\Helpers\Helper::file_upload_max_size_readable()]) }}</p>
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
        </div> <!-- /.modal-body-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
          <button type="submit" class="btn btn-primary btn-sm">{{ trans('button.upload') }}</button>
        </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

@stop


@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop

