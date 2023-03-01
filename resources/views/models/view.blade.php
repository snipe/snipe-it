@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $model->name }}
    {{ ($model->model_number) ? '(#'.$model->model_number.')' : '' }}
@parent
@stop

@section('header_right')
    @can('update', \App\Models\AssetModel::class)
        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @if ($model->deleted_at=='')
                    <li><a href="{{ route('models.edit', $model->id) }}">{{ trans('admin/models/table.edit') }}</a></li>
                    <li><a href="{{ route('models.clone.create', $model->id) }}">{{ trans('admin/models/table.clone') }}</a></li>
                    <li><a href="{{ route('hardware.create', ['model_id' => $model->id]) }}">{{ trans('admin/hardware/form.create') }}</a></li>
                @else
                    <li><a href="{{ route('models.restore.store', $model->id) }}">{{ trans('admin/models/general.restore') }}</a></li>
                @endif
            </ul>
        </div>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
    <div class="col-md-9">
        <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#assets" data-toggle="tab">

                        <span class="hidden-lg hidden-md">
                          <i class="fas fa-barcode fa-2x"></i>
                        </span>
                                    <span class="hidden-xs hidden-sm">
                            {{ trans('general.assets') }}
                                        {!! (($model->assets) && ($model->assets->count() > 0 )) ? '<badge class="badge badge-secondary">'.number_format($model->assets->count()).'</badge>' : '' !!}
                        </span>
                    </a>
                </li>

                <li>
                    <a href="#uploads" data-toggle="tab">

                        <span class="hidden-lg hidden-md">
                          <i class="fas fa-barcode fa-2x"></i>
                        </span>
                        <span class="hidden-xs hidden-sm">
                            {{ trans('general.files') }}
                            {!! ($model->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($model->uploads->count()).'</badge>' : '' !!}
                          </span>
                    </a>
                </li>
                <li class="pull-right">
                    <a href="#" data-toggle="modal" data-target="#uploadFileModal">
                        <i class="fas fa-paperclip" aria-hidden="true"></i>
                        {{ trans('button.upload') }}
                    </a>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane fade in active" id="assets">

                    @include('partials.asset-bulk-actions')

                    <table
                            data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                            data-cookie-id-table="assetListingTable"
                            data-pagination="true"
                            data-id-table="assetListingTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-fullscreen="true"
                            data-toolbar="#assetsBulkEditToolbar"
                            data-bulk-button-id="#bulkAssetEditButton"
                            data-bulk-form-id="#assetsBulkForm"
                            data-click-to-select="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            id="assetListingTable"
                            data-url="{{ route('api.assets.index',['model_id'=> $model->id]) }}"
                            class="table table-striped snipe-table"
                            data-export-options='{
                "fileName": "export-models-{{ str_slug($model->name) }}-assets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                    </table>
                    {{ Form::close() }}
                </div> <!-- /.tab-pane assets -->


                <div class="tab-pane fade" id="uploads">

                    <div class="row">
                        <div class="col-md-12">

                            @if ($model->uploads->count() > 0)
                                <table
                                        class="table table-striped snipe-table"
                                        id="modelFileHistory"
                                        data-pagination="true"
                                        data-id-table="modelFileHistory"
                                        data-search="true"
                                        data-side-pagination="client"
                                        data-sortable="true"
                                        data-show-columns="true"
                                        data-show-fullscreen="true"
                                        data-show-refresh="true"
                                        data-sort-order="desc"
                                        data-sort-name="created_at"
                                        data-show-export="true"
                                        data-export-options='{
                         "fileName": "export-asset-{{ $model->id }}-files",
                         "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                       }'
                                        data-cookie-id-table="assetFileHistory">
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

                                    @foreach ($model->uploads as $file)
                                        <tr>
                                            <td><i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i></td>
                                            <td>
                                                @if ((Storage::exists('private_uploads/assetmodels/'.$file->filename)) && ( Helper::checkUploadIsImage($file->get_src('assetmodels'))))
                                                    <a href="{{ route('show/modelfile', ['modelID' => $model->id, 'fileId' => $file->id]) }}" data-toggle="lightbox" data-type="image" data-title="{{ $file->filename }}">
                                                        <img src="{{ route('show/modelfile', ['modelID' => $model->id, 'fileId' =>$file->id]) }}" style="max-width: 50px;">
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if (Storage::exists('private_uploads/assetmodels/'.$file->filename))
                                                    {{ $file->filename }}
                                                @else
                                                    <del>{{ $file->filename }}</del>
                                                @endif
                                            </td>
                                            <td data-value="{{ (Storage::exists('private_uploads/assetmodels/'.$file->filename)) ? Storage::size('private_uploads/assetmodels/'.$file->filename) : '' }}">
                                                {{ (Storage::exists('private_uploads/assetmodels/'.$file->filename)) ? Helper::formatFilesizeUnits(Storage::size('private_uploads/assetmodels/'.$file->filename)) : '' }}
                                            </td>
                                            <td>
                                                @if ($file->note)
                                                    {{ $file->note }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (($file->filename) && (Storage::exists('private_uploads/assetmodels/'.$file->filename)))
                                                    <a href="{{ route('show/modelfile', [$model->id, $file->id]) }}" class="btn btn-default">
                                                        <i class="fas fa-download" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($file->created_at)
                                                    {{ Helper::getFormattedDateObject($file->created_at, 'datetime', false) }}
                                                @endif
                                            </td>
                                            <td>
                                                @can('update', \App\Models\AssetModel::class)
                                                    <a class="btn delete-asset btn-sm btn-danger btn-sm" href="{{ route('delete/assetfile', [$model->id, $file->id]) }}" data-tooltip="true" data-title="Delete" data-content="{{ trans('general.delete_confirm', ['item' => $file->filename]) }}"><i class="fas fa-trash icon-white" aria-hidden="true"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            @else

                                <div class="alert alert-info alert-block">
                                    <i class="fas fa-info-circle"></i>
                                    {{ trans('general.no_results') }}
                                </div>
                            @endif

                        </div> <!-- /.col-md-12 -->
                    </div> <!-- /.row -->

                </div>


            </div> <!-- /.tab-content -->
        </div>  <!-- /.nav-tabs-custom -->
    </div><!-- /. col-md-12 -->

    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-heading">
                            <h2 class="box-title"> {{ trans('general.moreinfo') }}:</h2>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">



                @if ($model->image)
                    <img src="{{ Storage::disk('public')->url(app('models_upload_path').e($model->image)) }}" class="img-responsive"></li>
                @endif


                <ul class="list-unstyled" style="line-height: 25px;">
                    @if ($model->category)
                        <li>{{ trans('general.category') }}:
                            <a href="{{ route('categories.show', $model->category->id) }}">{{ $model->category->name }}</a>
                        </li>
                    @endif

                    @if ($model->manufacturer)
                        <li>
                            {{ trans('general.manufacturer') }}:
                            @can('view', \App\Models\Manufacturer::class)
                                <a href="{{ route('manufacturers.show', $model->manufacturer->id) }}">
                                    {{ $model->manufacturer->name }}
                                </a>
                            @else
                                {{ $model->manufacturer->name }}
                            @endcan
                        </li>

                        @if ($model->manufacturer->url)
                            <li>
                                <i class="fas fa-globe-americas"></i> <a href="{{ $model->manufacturer->url }}">{{ $model->manufacturer->url }}</a>
                            </li>
                        @endif

                        @if ($model->manufacturer->support_url)
                            <li>
                                <i class="far fa-life-ring"></i> <a href="{{ $model->manufacturer->support_url }}">{{ $model->manufacturer->support_url }}</a>
                            </li>
                        @endif

                        @if ($model->manufacturer->support_phone)
                            <li>
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $model->manufacturer->support_phone }}">{{ $model->manufacturer->support_phone }}</a>

                            </li>
                        @endif

                        @if ($model->manufacturer->support_email)
                            <li>
                                <i class="far fa-envelope"></i> <a href="mailto:{{ $model->manufacturer->support_email }}">{{ $model->manufacturer->support_email }}</a>
                            </li>
                        @endif
                    @endif
                    @if ($model->model_number)
                        <li>
                            {{ trans('general.model_no') }}:
                            {{ $model->model_number }}
                        </li>
                    @endif

                    @if ($model->depreciation)
                        <li>
                            {{ trans('general.depreciation') }}:
                            {{ $model->depreciation->name }} ({{ $model->depreciation->months.' '.trans('general.months')}})
                        </li>
                    @endif

                    @if ($model->eol)
                        <li>{{ trans('general.eol') }}:
                            {{ $model->eol .' '. trans('general.months') }}
                        </li>
                    @endif

                    @if ($model->fieldset)
                        <li>{{ trans('admin/models/general.fieldset') }}:
                            <a href="{{ route('fieldsets.show', $model->fieldset->id) }}">{{ $model->fieldset->name }}</a>
                        </li>
                    @endif

                    @if ($model->notes)
                        <li>
                            {{ trans('general.notes') }}:
                            {{ $model->notes }}
                        </li>
                    @endif



                    @if  ($model->deleted_at!='')
                        <li><br /><a href="{{ route('models.restore.store', $model->id) }}" class="btn-flat large info ">{{ trans('admin/models/general.restore') }}</a></li>
                    @endif
                </ul>

                @if ($model->note)
                    Notes:
                    <p>
                        {!! $model->present()->note() !!}
                    </p>
                @endif
            </div>
        </div>
        </div>
            @can('update', \App\Models\AssetModel::class)
            <div class="col-md-12" style="padding-bottom: 5px;">
                <a href="{{ route('models.edit', $model->id) }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print">{{ trans('admin/models/table.edit') }}</a>
            </div>
            @endcan

            @can('create', \App\Models\AssetModel::class)
            <div class="col-md-12" style="padding-bottom: 5px;">
                <a href="{{ route('models.clone.create', $model->id) }}" style="width: 100%;" class="btn btn-sm btn-warning hidden-print">{{ trans('admin/models/table.clone') }}</a>
            </div>
            @endcan

            @can('delete', \App\Models\AssetModel::class)
                @if ($model->assets->count() > 0)

                    <div class="col-md-12" style="padding-bottom: 5px;">
                        <a href="{{ route('models.destroy', $model->id) }}" style="width: 100%;" class="btn btn-sm btn-danger hidden-print disabled">{{ trans('general.delete') }}</a>
                    </div>
                @else

                    <div class="col-md-12" style="padding-bottom: 10px;">
                        <a href="{{ route('models.destroy', $model->id) }}" style="width: 100%;" class="btn btn-sm btn-danger hidden-print">{{ trans('general.delete') }}</a>
                    </div>
                @endif
           @endcan
        </div>
</div> <!-- /.row -->

@can('update', \App\Models\AssetModel::class)
    @include ('modals.upload-file', ['item_type' => 'models', 'item_id' => $model->id])
@endcan
@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', ['exportFile' => 'manufacturer' . $model->name . '-export', 'search' => false])

@stop
