<!-- begin redirect submit options -->
@props([
    'filepath',
    'object',
    'showfile_routename',
    'deletefile_routename',
    'data_route'
])

<!-- begin non-ajaxed file listing table -->

    <table
            data-columns="{{ \App\Presenters\UploadsPresenter::dataTableLayout() }}"
            data-cookie-id-table="{{ str_slug($object->name ?? $object->id) }}UploadsTable"
            data-id-table="{{ str_slug($object->name ?? $object->id) }}UploadsTable"
            id="{{ str_slug($object->name ?? $object->id) }}UploadsTable"
            data-search="true"
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
            data-url="{{ route($data_route, $object->id) }}"
            data-export-options='{
                    "fileName": "export-license-uploads-{{ str_slug($object->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
    </table>

<!-- end non-ajaxed file listing table -->