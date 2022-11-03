@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{ $consumable->name }}
 {{ trans('general.consumable') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

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


        @can('consumables.files', $consumable)
          <li>
            <a href="#files" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-file fa-2x" aria-hidden="true"></i></span>
              <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}
                {!! ($consumable->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($consumable->uploads->count()).'</badge>' : '' !!}
            </span>
            </a>
          </li>
        @endcan

        @can('update', Consumable::class)

          <li class="pull-right">
            <a href="#" data-toggle="modal" data-target="#uploadFileModal">
              <i class="fas fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}
            </a>
          </li>
        @endcan

      </ul>

      <div class="tab-content">

        <div class="tab-pane active" id="checkedout">
              <div class="table-responsive">

                <table
                        data-cookie-id-table="consumablesCheckedoutTable"
                        data-pagination="true"
                        data-id-table="consumablesCheckedoutTable"
                        data-search="false"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-footer="true"
                        data-show-refresh="true"
                        data-sort-order="asc"
                        data-sort-name="name"
                        id="consumablesCheckedoutTable"
                        class="table table-striped snipe-table"
                        data-url="{{route('api.consumables.showUsers', $consumable->id)}}"
                        data-export-options='{
                "fileName": "export-consumables-{{ str_slug($consumable->name) }}-checkedout-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                  <thead>
                  <tr>
                    <th data-searchable="false" data-sortable="false" data-field="avatar" data-formatter="imageFormatter">{{ trans('general.image') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="name" formatter="usersLinkFormatter">{{ trans('general.user') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">
                      {{ trans('general.date') }}
                    </th>
                    <th data-searchable="false" data-sortable="false" data-field="note">{{ trans('general.notes') }}</th>
                    <th data-searchable="false" data-sortable="false" data-field="admin">{{ trans('general.admin') }}</th>
                  </tr>
                  </thead>
                </table>
          </div>
        </div> <!-- close tab-pane div -->


        @can('consumables.files', $consumable)
          <div class="tab-pane" id="files">

            <div class="table-responsive">
              <table
                      data-cookie-id-table="consumableUploadsTable"
                      data-id-table="consumableUploadsTable"
                      id="consumableUploadsTable"
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
                    "fileName": "export-consumables-uploads-{{ str_slug($consumable->name) }}-{{ date('Y-m-d') }}",
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
                @if ($consumable->uploads->count() > 0)
                  @foreach ($consumable->uploads as $file)
                    <tr>
                      <td>
                        <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                        <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>

                      </td>
                      <td>
                        @if ($file->filename)
                          @if ( Helper::checkUploadIsImage($file->get_src('consumables')))
                            <a href="{{ route('show.consumablefile', ['consumableId' => $consumable->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show.consumablefile', ['consumableId' => $consumable->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                          @endif
                        @endif
                      </td>
                      <td>
                        {{ $file->filename }}
                      </td>
                      <td data-value="{{ (Storage::exists('private_uploads/consumables/'.$file->filename) ? Storage::size('private_uploads/consumables/'.$file->filename) : '') }}">
                        {{ @Helper::formatFilesizeUnits(Storage::exists('private_uploads/consumables/'.$file->filename) ? Storage::size('private_uploads/consumables/'.$file->filename) : '') }}
                      </td>

                      <td>
                        @if ($file->note)
                          {{ $file->note }}
                        @endif
                      </td>
                      <td>
                        @if ($file->filename)
                          <a href="{{ route('show.consumablefile', [$consumable->id, $file->id, 'download' => 'true']) }}" class="btn btn-default">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            <span class="sr-only">{{ trans('general.download') }}</span>
                          </a>
                        @endif
                      </td>
                      <td>{{ $file->created_at }}</td>
                      <td>
                        <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/consumablefile', [$consumable->id, $file->id]) }}" data-content="{{ trans('general.delete_confirm', ['item' => $file->filename]) }}" data-title="{{ trans('general.delete') }}">
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

      </div>
    </div>

  </div>


  <div class="col-md-3">

        <div class="box box-default">
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">

          
                @if ($consumable->image!='')
                <div class="col-md-12 text-center">
                  <a href="{{ Storage::disk('public')->url('consumables/'.e($consumable->image)) }}" data-toggle="lightbox">
                      <img src="{{ Storage::disk('public')->url('consumables/'.e($consumable->image)) }}" class="img-responsive img-thumbnail" alt="{{ $consumable->name }}"></a>
                </div>
                @endif

                @if ($consumable->purchase_date)
                  <div class="col-md-12">
                    <strong>{{ trans('general.purchase_date') }}: </strong>
                    {{ Helper::getFormattedDateObject($consumable->purchase_date, 'date', false) }}
                  </div>
                @endif

                @if ($consumable->purchase_cost)
                  <div class="col-md-12">
                    <strong>{{ trans('general.purchase_cost') }}:</strong>
                    {{ $snipeSettings->default_currency }}
                    {{ Helper::formatCurrencyOutput($consumable->purchase_cost) }}
                  </div>
                @endif

                @if ($consumable->item_no)
                  <div class="col-md-12">
                    <strong>{{ trans('admin/consumables/general.item_no') }}:</strong>
                    {{ $consumable->item_no }}
                  </div>
                @endif

                @if ($consumable->model_number)
                  <div class="col-md-12">
                    <strong>{{ trans('general.model_no') }}:</strong>
                    {{ $consumable->model_number }}
                  </div>
                @endif

                @if ($consumable->manufacturer)
                  <div class="col-md-12">
                    <strong>{{ trans('general.manufacturer') }}:</strong>
                    <a href="{{ route('manufacturers.show', $consumable->manufacturer->id) }}">{{ $consumable->manufacturer->name }}</a>
                  </div>
                @endif

                @if ($consumable->order_number)
                  <div class="col-md-12">
                    <strong>{{ trans('general.order_number') }}:</strong>
                    {{ $consumable->order_number }}
                  </div>
                @endif

    @can('checkout', \App\Models\Consumable::class)

      <div class="col-md-12">
        <br><br>
        @if ($consumable->numRemaining() > 0)
          <a href="{{ route('consumables.checkout.show', $consumable->id) }}" style="margin-bottom:10px; width:100%" class="btn btn-primary btn-sm">
            {{ trans('general.checkout') }}
          </a>
        @else
          <button style="margin-bottom:10px; width:100%"" class="btn btn-primary btn-sm disabled">
            {{ trans('general.checkout') }}
          </button>
        @endif
      </div>

    @endcan

    @if ($consumable->notes)
       
    <div class="col-md-12">
      <strong>
        {{ trans('general.notes') }}:
      </strong>
              </div>
    <div class="col-md-12">
      {!! nl2br(e($consumable->notes)) !!}
            </div>
          </div>
  @endif

    </div>
    
  </div> <!-- /.col-md-3-->
</div> <!-- /.row-->



@can('consumables.files', \App\Models\Consumable::class)
  @include ('modals.upload-file', ['item_type' => 'consumable', 'item_id' => $consumable->id])
@endcan
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'consumable' . $consumable->name . '-export', 'search' => false])
@stop
