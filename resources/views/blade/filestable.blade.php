<!-- begin redirect submit options -->
@props([
    'filepath',
    'object',
    'showfile_routename',
    'deletefile_routename',
    'object_type',
])

<!-- begin non-ajaxed file listing table -->

    <table
            data-columns="{{ \App\Presenters\UploadsPresenter::dataTableLayout($object_type) }}"
            data-cookie-id-table="{{ str_slug($object->name ?? $object->id) }}UploadsTable"
            data-id-table="{{ str_slug($object->name ?? $object->id) }}UploadsTable"
            id="{{ str_slug($object->name ?? $object->id) }}UploadsTable"
            data-search="true"
            data-show-custom-view="true"
            data-custom-view="fileGalleryFormatter"
            data-show-custom-view-button="true"
            data-pagination="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-fullscreen="true"
            data-show-export="true"
            data-show-footer="true"
            data-toolbar="#upload-toolbar"
            data-show-refresh="true"
            data-card-view="true"
            data-show-toggle="true"
            data-sort-order="asc"
            data-sort-name="name"
            class="table table-striped snipe-table"
            data-url="{{ route("api.files.index", ['object_type' => $object_type, 'id' => $object->id]) }}"
            data-export-options='{
                    "fileName": "export-uploads-{{ str_slug($object->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
    </table>

<template id="fileGalleryTemplate">
    <div class="col-md-4">
        <div class="panel panel-%PANEL_CLASS%">

            <div class="panel-heading">
                <h3 class="panel-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <i class="%ICON%"></i> %FILENAME%
                </h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        %INLINE_IMAGE%
                        <br>
                        <p>
                            <strong>{{ trans('general.created_at') }}:</strong> %CREATED_AT% <br>
                            <strong>{{ trans('general.created_by') }}:</strong> %CREATED_BY% <br>
                            <strong>{{ trans('general.notes') }}:</strong> %NOTE%
                        </p>
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <div class="pull-right">
                    %DOWNLOAD_BUTTON% %NEW_WINDOW_BUTTON%
                </div>
                %DELETE_BUTTON%
             </div>

        </div>
    </div>
</template>


<!-- end non-ajaxed file listing table -->