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
    <ul class="dropdown-menu" role="menu">
        <li role="menuitem"><a href="{{ route('licenses.edit', ['license' => $license->id]) }}">{{ trans('admin/licenses/general.edit') }}</a></li>
        <li role="menuitem"><a href="{{ route('clone/license', $license->id) }}">{{ trans('admin/licenses/general.clone') }}</a></li>
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
        <li><a href="#seats" data-toggle="tab">{{ trans('admin/licenses/form.seats') }}</a></li>
        <li><a href="#uploads" data-toggle="tab">{{ trans('general.file_uploads') }}</a></li>
        <li><a href="#history" data-toggle="tab">{{ trans('admin/licenses/general.checkout_history') }}</a></li>
        <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal"><i class="fa fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}</a></li>
      </ul>

      <div class="tab-content">

        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-12">
              <div class="container row-striped">

                @if (!is_null($license->company))
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('general.company') }}</strong>
                    </div>
                    <div class="col-md-8">
                      {{ $license->company->name }}
                    </div>
                  </div>
                @endif

                @if ($license->manufacturer)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('admin/hardware/form.manufacturer') }}</strong>
                    </div>
                    <div class="col-md-8">
                      @can('view', \App\Models\Manufacturer::class)
                        <a href="{{ route('manufacturers.show', $license->manufacturer->id) }}">
                          {{ $license->manufacturer->name }}
                        </a>
                      @else
                        {{ $license->manufacturer->name }}
                      @endcan

                      @if ($license->manufacturer->url)
                        <br><i class="fa fa-globe" aria-hidden="true"></i> <a href="{{ $license->manufacturer->url }}" rel="noopener">{{ $license->manufacturer->url }}</a>
                      @endif

                      @if ($license->manufacturer->support_url)
                        <br><i class="fa fa-life-ring" aria-hidden="true"></i>
                        <a href="{{ $license->manufacturer->support_url }}"  rel="noopener">{{ $license->manufacturer->support_url }}</a>
                      @endif

                      @if ($license->manufacturer->support_phone)
                        <br><i class="fa fa-phone" aria-hidden="true"></i>
                        <a href="tel:{{ $license->manufacturer->support_phone }}">{{ $license->manufacturer->support_phone }}</a>
                      @endif

                      @if ($license->manufacturer->support_email)
                        <br><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:{{ $license->manufacturer->support_email }}">{{ $license->manufacturer->support_email }}</a>
                      @endif
                    </div>
                  </div>
                @endif


                @if (!is_null($license->serial))
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('admin/licenses/form.license_key') }}</strong>
                    </div>
                    <div class="col-md-8">
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
                    <div class="col-md-4">
                      <strong>{{ trans('general.category') }}</strong>
                    </div>
                    <div class="col-md-8">
                      <a href="{{ route('categories.show', $license->category->id) }}">{{ $license->category->name }}</a>
                    </div>
                  </div>
                @endif


                @if ($license->license_name!='')
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('admin/licenses/form.to_name') }}</strong>
                    </div>
                    <div class="col-md-8">
                      {{ $license->license_name }}
                    </div>
                  </div>
                @endif

                @if ($license->license_email!='')
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('admin/licenses/form.to_email') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ $license->license_email }}
                    </div>
                  </div>
                @endif


                @if ($license->supplier_id)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('general.supplier') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      <a href="{{ route('suppliers.show', $license->supplier_id) }}">
                        {{ $license->supplier->name }}
                      </a>
                    </div>
                  </div>
                @endif


                @if (isset($license->expiration_date))
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/licenses/form.expiration') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {{ $license->expiration_date }}
                  </div>
                </div>
                @endif


                @if ($license->depreciation)
                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/hardware/form.depreciation') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {{ $license->depreciation->name }}
                    ({{ $license->depreciation->months }}
                    {{ trans('admin/hardware/form.months') }}
                    )
                  </div>
                </div>



                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/hardware/form.depreciates_on') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {{ $license->depreciated_date()->format("Y-m-d") }}
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/hardware/form.fully_depreciated') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
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
                  <div class="col-md-4">
                    <strong>
                      {{ trans('admin/licenses/form.purchase_order') }}
                    </strong>
                  </div>
                  <div class="col-md-8">
                    {{ $license->purchase_order }}
                  </div>
                </div>
                  @endif


                  @if (isset($license->purchase_date))
                <div class="row">
                  <div class="col-md-4">
                    <strong>{{ trans('general.purchase_date') }}</strong>
                  </div>
                  <div class="col-md-8">
                    {{ $license->purchase_date }}
                  </div>
                </div>
                  @endif

                  @if ($license->purchase_cost > 0)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('general.purchase_cost') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ $snipeSettings->default_currency }}
                      {{ \App\Helpers\Helper::formatCurrencyOutput($license->purchase_cost) }}
                    </div>
                  </div>
                  @endif

                  @if ($license->order_number)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('general.order_number') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ $license->order_number }}
                    </div>
                  </div>
                  @endif

                  @if (($license->seats) && ($license->seats) > 0)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('admin/licenses/form.seats') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ $license->seats }}
                    </div>
                  </div>
                  @endif



                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('admin/licenses/form.reassignable') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
                      {{ $license->reassignable ? 'Yes' : 'No' }}
                    </div>
                  </div>


                  @if ($license->notes)
                  <div class="row">
                    <div class="col-md-4">
                      <strong>
                        {{ trans('general.notes') }}
                      </strong>
                    </div>
                    <div class="col-md-8">
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
                        data-cookie-id-table="seatsTable-{{ $license->id }}"
                        data-id-table="seatsTable-{{ $license->id }}"
                        id="seatsTable-{{$license->id}}"
                        data-pagination="true"
                        data-search="false"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        class="table table-striped snipe-table"
                        data-url="{{ route('api.license.seats',['license_id' => $license->id]) }}"
                        data-export-options='{
                        "fileName": "export-seats-{{ str_slug($license->name) }}-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
                </table>

              </div>

            </div>

          </div> <!--/.row-->
        </div> <!-- /.tab-pane -->

        <div class="tab-pane" id="uploads">
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
                <th data-visible="true" aria-hidden="true"><span class="sr-only">Icon</span></th>
                <th class="col-md-4" data-field="file_name" data-visible="true" data-sortable="true" data-switchable="true">{{ trans('general.file_name') }}</th>
                <th class="col-md-4" data-field="notes" data-visible="true" data-sortable="true" data-switchable="true">{{ trans('general.notes') }}</th>
                <th class="col-md-2" data-field="created_at" data-visible="true"  data-sortable="true" data-switchable="true">{{ trans('general.created_at') }}</th>
                <th class="col-md-2" data-searchable="true" data-visible="true">{{ trans('general.image') }}</th>
                <th class="col-md-2" data-field="download" data-visible="true"  data-sortable="false" data-switchable="true">Download</th>
                <th class="col-md-2" data-field="delete" data-visible="true"  data-sortable="false" data-switchable="true">Delete</th>
              </tr>
            </thead>
            <tbody>
            @if ($license->uploads->count() > 0)
              @foreach ($license->uploads as $file)
              <tr>
                <td>
                  <i class="{{ \App\Helpers\Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                  <span class="sr-only">{{ \App\Helpers\Helper::filetype_icon($file->filename) }}</span>

                </td>
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
                  @if ($file->filename)
                    <a href="{{ route('show.licensefile', [$license->id, $file->id, 'download' => 'true']) }}" class="btn btn-default">
                      <i class="fa fa-download" aria-hidden="true"></i>
                      <span class="sr-only">Download</span>
                    </a>
                  @endif
                </td>
                <td>
                  <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/licensefile', [$license->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?">
                    <i class="fa fa-trash icon-white" aria-hidden="true"></i>
                    <span class="sr-only">Delete</span>
                  </a>
                </td>
              </tr>
              @endforeach
            @else
              <tr>
              <td colspan="6">{{ trans('general.no_results') }}</td>
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
                      data-cookie-id-table="dsffsdflicenseHistoryTable"
                      data-id-table="dsffsdflicenseHistoryTable"
                      id="dsffsdflicenseHistoryTable"
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
                  <th class="col-sm-2" data-visible="true" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  <th class="col-sm-2"data-visible="true" data-sortable="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                  <th class="col-sm-2" data-sortable="true"  data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                  <th class="col-sm-2" data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                  <th class="col-sm-2" data-sortable="true" data-visible="true" data-field="note">{{ trans('general.notes') }}</th>
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

