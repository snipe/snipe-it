@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $accessory->name }}
 {{ trans('general.accessory') }}
 @if ($accessory->model_number!='')
     ({{ $accessory->model_number }})
 @endif

@parent
@stop

{{-- Page content --}}
@section('content')
    {{-- Page content --}}
    <div class="row">
        <div class="col-md-9">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs hidden-print">

                    <li class="active">
                        <a href="#checkedout" data-toggle="tab">
                            <span class="hidden-lg hidden-md">
                            <i class="fas fa-info-circle fa-2x" aria-hidden="true"></i>
                            </span>
                            <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.info') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="#history" data-toggle="tab">
                        <span class="hidden-lg hidden-md">
                        <i class="fas fa-history fa-2x" aria-hidden="true"></i></span>
                        <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span>
                        </a>
                    </li>


                    @can('accessories.files', $accessory)
                        <li>
                            <a href="#files" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-file fa-2x" aria-hidden="true"></i></span>
                                <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}
                                    {!! ($accessory->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($accessory->uploads->count()).'</badge>' : '' !!}
            </span>
                            </a>
                        </li>
                    @endcan

                    @can('update', $accessory)
                        <li class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#uploadFileModal">
                                <i class="fas fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}
                            </a>
                        </li>
                    @endcan
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="checkedout">
                        <div class="table table-responsive">
                          <div class="row">
                              <div class="col-md-12">
                                <table
                                    data-cookie-id-table="usersTable"
                                    data-pagination="true"
                                    data-id-table="usersTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-fullscreen="true"
                                    data-show-export="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    id="usersTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{ route('api.accessories.checkedout', $accessory->id) }}"
                                    data-export-options='{
                                    "fileName": "export-accessories-{{ str_slug($accessory->name) }}-users-{{ date('Y-m-d') }}",
                                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                    }'>
                                <thead>
                                    <tr>
                                    <th data-searchable="false" data-formatter="usersLinkFormatter" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                                    <th data-searchable="false" data-sortable="false" data-field="checkout_notes">{{ trans('general.notes') }}</th>
                                    <th data-searchable="false" data-formatter="dateDisplayFormatter" data-sortable="false" data-field="last_checkout">{{ trans('admin/hardware/table.checkout_date') }}</th>
                                    <th data-searchable="false" data-sortable="false" data-field="actions" data-formatter="accessoriesInOutFormatter">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>
                                </table>
                            </div><!--col-md-9-->
                          </div> <!-- close tab-pane div -->
                        </div>
                    </div>

                    <!-- history tab pane -->
                     <div class="tab-pane fade" id="history">
                         <div class="table table-responsive">
                             <div class="row">
                                 <div class="col-md-12">
                                <table
                                        class="table table-striped snipe-table"
                                        data-cookie-id-table="AccessoryHistoryTable"
                                        data-id-table="AccessoryHistoryTable"
                                        id="AccessoryHistoryTable"
                                        data-pagination="true"
                                        data-show-columns="true"
                                        data-side-pagination="server"
                                        data-show-refresh="true"
                                        data-show-export="true"
                                        data-sort-order="desc"
                                        data-export-options='{
                       "fileName": "export-{{ str_slug($accessory->name) }}-history-{{ date('Y-m-d') }}",
                       "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                     }'
                                                data-url="{{ route('api.activity.index', ['item_id' => $accessory->id, 'item_type' => 'accessory']) }}">

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
                                    </div> <!-- /.col-md-12-->
                                </div> <!-- /.row-->
                            </div><!--tab history-->
                     </div>



                    @can('accessories.files', $accessory)
                        <div class="tab-pane" id="files">

                            <div class="table table-responsive">
                                <div class="row">
                                    <div class="col-md-12">
                                <table
                                        data-cookie-id-table="accessoryUploadsTable"
                                        data-id-table="accessoryUploadsTable"
                                        id="accessoryUploadsTable"
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
            "fileName": "export-accessories-uploads-{{ str_slug($accessory->name) }}-{{ date('Y-m-d') }}",
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
                                    @if ($accessory->uploads->count() > 0)
                                        @foreach ($accessory->uploads as $file)
                                            <tr>
                                                <td>
                                                    <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                                                    <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>

                                                </td>
                                                <td>
                                                    @if ($file->filename)
                                                        @if ( Helper::checkUploadIsImage($file->get_src('accessories')))
                                                            <a href="{{ route('show.accessoryfile', ['accessoryId' => $accessory->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show.accessoryfile', ['accessoryId' => $accessory->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $file->filename }}
                                                </td>
                                                <td data-value="{{ (Storage::exists('private_uploads/accessories/'.$file->filename) ? Storage::size('private_uploads/accessories/'.$file->filename) : '') }}">
                                                    {{ @Helper::formatFilesizeUnits(Storage::exists('private_uploads/accessories/'.$file->filename) ? Storage::size('private_uploads/accessories/'.$file->filename) : '') }}
                                                </td>

                                                <td>
                                                    @if ($file->note)
                                                        {{ $file->note }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($file->filename)
                                                        <a href="{{ route('show.accessoryfile', [$accessory->id, $file->id, 'download' => 'true']) }}" class="btn btn-default">
                                                            <i class="fas fa-download" aria-hidden="true"></i>
                                                            <span class="sr-only">{{ trans('general.download') }}</span>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ $file->created_at }}</td>
                                                <td>
                                                    <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/accessoryfile', [$accessory->id, $file->id]) }}" data-content="{{ trans('general.delete_confirm', ['item' => $file->filename]) }}" data-title="{{ trans('general.delete') }}">
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
                        </div>
                    </div>
                </div> <!-- /.tab-pane -->
                @endcan
            </div>
        </div>
    </div>



<!-- side address column -->

<div class="col-md-3">

      @if ($accessory->image!='')
          <div class="row">
              <div class="col-md-12 text-center" style="padding-bottom: 15px;">
                  <a href="{{ Storage::disk('public')->url('accessories/'.e($accessory->image)) }}" data-toggle="lightbox"><img src="{{ Storage::disk('public')->url('accessories/'.e($accessory->image)) }}" class="img-responsive img-thumbnail" alt="{{ $accessory->name }}"></a>
              </div>
          </div>
      @endif

      @if ($accessory->company)
          <div class="row">
              <div class="col-md-3" style="padding-bottom: 15px;">
                  <strong> {{ trans('general.company')}}</strong>
              </div>
              <div class="col-md-9">
                  <a href="{{ route('companies.show', $accessory->company->id) }}">{{ $accessory->company->name }} </a>
              </div>
          </div>
      @endif


      @if ($accessory->category)
          <div class="row">
              <div class="col-md-3" style="padding-bottom: 10px;">
                  <strong>{{ trans('general.category')}}</strong>
              </div>
              <div class="col-md-9">
                  <a href="{{ route('categories.show', $accessory->category->id) }}">{{ $accessory->category->name }} </a>
              </div>
          </div>
      @endif


      @if ($accessory->notes)
        <div class="row">
          <div class="col-md-3" style="padding-bottom: 10px;">
              <strong>
                  {{ trans('general.notes') }}
              </strong>
          </div>
          <div class="col-md-9">
              {!! nl2br(Helper::parseEscapedMarkedownInline($accessory->notes)) !!}
          </div>
       </div>

     @endif


      <div class="row">
          <div class="col-md-3" style="padding-bottom: 10px;">
              <strong>{{ trans('admin/accessories/general.remaining') }}</strong>
          </div>
          <div class="col-md-9">
              {{ $accessory->numRemaining() }}
          </div>
      </div>

      <div class="row">
          <div class="col-md-3" style="padding-bottom: 10px;">
              <strong>{{ trans('general.checked_out') }}</strong>
          </div>
          <div class="col-md-9">
              {{ $accessory->users_count }}
          </div>
      </div>
</div>

    <div class="col-md-3 pull-right">
        @can('checkout', \App\Models\Accessory::class)
                <div class="text-center" style="padding-top:5px;">
                    <a href="{{ route('accessories.checkout.show', $accessory->id) }}" style="margin-right:5px; width:100%" class="btn btn-primary btn-sm" {{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
                </div>
        @endcan
        @can('update', \App\Models\Accessory::class)
               <div class="text-center" style="padding-top:5px;">
                  <a href="{{ route('accessories.edit', $accessory->id) }}" style="margin-right:5px; width:100%" class="btn btn-primary btn-sm">{{ trans('admin/accessories/general.edit') }}</a>
               </div>
        @endcan
        @can('update', \App\Models\Accessory::class)
                <div class="text-center" style="padding-top:5px;">
                    <a href="{{ route('clone/accessories', $accessory->id) }}" style="margin-right:5px; width:100%" class="btn btn-primary btn-sm">{{ trans('admin/accessories/general.clone') }}</a>
                </div>
        @endcan

        @can('delete', $accessory)
            @if ($accessory->users_count == 0)
                <div class="text-center" style="padding-top:5px;">
                    <button class="btn btn-block btn-danger delete-asset" style="padding-top:5px;" data-toggle="modal" data-title="{{ trans('general.delete') }}" data-content="{{ trans('general.delete_confirm_no_undo', ['item' => $accessory->name]) }}" data-target="#dataConfirmModal">
                    {{ trans('general.delete') }}
                    </button>
                </div>
            @else
                <div class="text-center" style="padding-top:5px;">
                    <span data-tooltip="true" title=" {{ trans('admin/accessories/general.delete_disabled') }}">
                        <a href="#" class="btn btn-block btn-danger disabled">
                        {{ trans('general.delete') }}
                        </a>
                    </span>
                </div>
            @endif
        @endcan
    </div>
</div>



@can('accessories.files', Accessory::class)
    @include ('modals.upload-file', ['item_type' => 'accessory', 'item_id' => $accessory->id])
@endcan
@stop




@section('moar_scripts')
    <script>
        $('#dataConfirmModal').on('show.bs.modal', function (event) {
            var content = $(event.relatedTarget).data('content');
            var title = $(event.relatedTarget).data('title');
            $(this).find(".modal-body").text(content);
            $(this).find(".modal-header").text(title);
        });
    </script>
@include ('partials.bootstrap-table')
@stop
