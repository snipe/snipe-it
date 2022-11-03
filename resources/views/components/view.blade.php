@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $component->name }}
 {{ trans('general.component') }}
@parent
@stop

{{-- Right header --}}
@section('header_right')
  @can('manage', $component)
    <div class="dropdown pull-right">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        {{ trans('button.actions') }}
          <span class="caret"></span>
      </button>
      
      <ul class="dropdown-menu pull-right" role="menu22">
        @if ($component->assigned_to != '')
          @can('checkin', $component)
          <li role="menuitem">
            <a href="{{ route('components.checkin.show', $component->id) }}">
              {{ trans('admin/components/general.checkin') }}
            </a>
          </li>
          @endcan
        @else
          @can('checkout', $component)
          <li role="menuitem">
            <a href="{{ route('components.checkout.show', $component->id)  }}">
              {{ trans('admin/components/general.checkout') }}
            </a>
          </li>
          @endcan
        @endif

        @can('update', $component)
        <li role="menuitem">
          <a href="{{ route('components.edit', $component->id) }}">
            {{ trans('admin/components/general.edit') }}
          </a>
        </li>
        @endcan
      </ul>
    </div>
  @endcan
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


        @can('components.files', $component)
          <li>
            <a href="#files" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-file fa-2x" aria-hidden="true"></i></span>
              <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}
                {!! ($component->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($component->uploads->count()).'</badge>' : '' !!}
            </span>
            </a>
          </li>
        @endcan

        @can('update', Component::class)

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

            <table
                    data-cookie-id-table="componentsCheckedoutTable"
                    data-pagination="true"
                    data-id-table="componentsCheckedoutTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="componentsCheckedoutTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.components.assets', $component->id)}}"
                    data-export-options='{
                "fileName": "export-components-{{ str_slug($component->name) }}-checkedout-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
              <thead>
              <tr>
                <th data-searchable="false" data-sortable="false" data-field="name" data-formatter="hardwareLinkFormatter">
                  {{ trans('general.asset') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="qty">
                  {{ trans('general.qty') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="note">
                  {{ trans('general.notes') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">
                  {{ trans('general.date') }}
                </th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkincheckout" data-formatter="componentsInOutFormatter">
                  {{ trans('general.checkin') }}/{{ trans('general.checkout') }}
                </th>
              </tr>
              </thead>
            </table>

          </div>
        </div> <!-- close tab-pane div -->


        @can('components.files', $component)
          <div class="tab-pane" id="files">

            <div class="table-responsive">
              <table
                      data-cookie-id-table="componentUploadsTable"
                      data-id-table="componentUploadsTable"
                      id="componentUploadsTable"
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
                    "fileName": "export-components-uploads-{{ str_slug($component->name) }}-{{ date('Y-m-d') }}",
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
                @if ($component->uploads->count() > 0)
                  @foreach ($component->uploads as $file)
                    <tr>
                      <td>
                        <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                        <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>

                      </td>
                      <td>
                        @if ($file->filename)
                          @if ( Helper::checkUploadIsImage($file->get_src('components')))
                            <a href="{{ route('show.componentfile', ['componentId' => $component->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show.componentfile', ['componentId' => $component->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                          @endif
                        @endif
                      </td>
                      <td>
                        {{ $file->filename }}
                      </td>
                      <td data-value="{{ (Storage::exists('private_uploads/components/'.$file->filename) ? Storage::size('private_uploads/components/'.$file->filename) : '') }}">
                        {{ @Helper::formatFilesizeUnits(Storage::exists('private_uploads/components/'.$file->filename) ? Storage::size('private_uploads/components/'.$file->filename) : '') }}
                      </td>

                      <td>
                        @if ($file->note)
                          {{ $file->note }}
                        @endif
                      </td>
                      <td>
                        @if ($file->filename)
                          <a href="{{ route('show.componentfile', [$component->id, $file->id, 'download' => 'true']) }}" class="btn btn-default">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            <span class="sr-only">{{ trans('general.download') }}</span>
                          </a>
                        @endif
                      </td>
                      <td>{{ $file->created_at }}</td>
                      <td>
                        <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/componentfile', [$component->id, $file->id]) }}" data-content="{{ trans('general.delete_confirm', ['item' => $file->filename]) }}" data-title="{{ trans('general.delete') }}">
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
  </div> <!-- .col-md-9-->


  <!-- side address column -->
  <div class="col-md-3">
    @if ($component->image!='')
      <div class="col-md-12 text-center" style="padding-bottom: 15px;">
        <a href="{{ Storage::disk('public')->url('components/'.e($component->image)) }}" data-toggle="lightbox">
          <img src="{{ Storage::disk('public')->url('components/'.e($component->image)) }}" class="img-responsive img-thumbnail" alt="{{ $component->name }}"></a>
      </div>

    @endif

    @if ($component->serial!='')
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.serial') }}: </strong>
    {{ $component->serial }} </div>
    @endif

    @if ($component->purchase_date)
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/components/general.date') }}: </strong>
    {{ $component->purchase_date }} </div>
    @endif

    @if ($component->purchase_cost)
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/components/general.cost') }}:</strong>
    {{ $snipeSettings->default_currency }}

    {{ Helper::formatCurrencyOutput($component->purchase_cost) }} </div>
    @endif

    @if ($component->order_number)
    <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('general.order_number') }}:</strong>
    {{ $component->order_number }} </div>
    @endif

    @if ($component->notes)

      <div class="col-md-12">
        <strong>
          {{ trans('general.notes') }}
        </strong>
      </div>
      <div class="col-md-12">
        {!! nl2br(e($component->notes)) !!}
      </div>
    </div>
    @endif

  </div>
</div> <!-- .row-->

@can('components.files', Component::class)
  @include ('modals.upload-file', ['item_type' => 'component', 'item_id' => $component->id])
@endcan
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'component' . $component->name . '-export', 'search' => false])
@stop
