<!-- begin redirect submit options -->
@props([
    'filepath',
    'object',
    'object_type',
    'showfile_routename',
])

<!-- begin non-ajaxed file listing table -->
<div class="table-responsive">
    <table
            data-cookie-id-table="{{ $object_type }}HistoryTable"
            data-id-table="{{ $object_type }}HistoryTable"
            id="{{ $object_type }}HistoryTable"
            data-search="true"
            data-pagination="true"
            data-side-pagination="server"
            data-show-columns="true"
            data-show-fullscreen="true"
            data-show-export="true"
            data-show-footer="true"
            data-toolbar="#history-toolbar"
            data-show-refresh="true"
            data-sort-order="asc"
            data-sort-name="name"
            data-url="{{ route('api.activity.index', ['id' => $object->id, 'type' => $object_type]) }}"
            class="table table-striped snipe-table"
            data-export-options='{
                    "fileName": "export-history-{{ str_slug($object->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>

        <thead>
        <tr>
            <th data-visible="true" data-field="icon" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter">
                {{ trans('admin/hardware/table.icon') }}
            </th>
            <th data-visible="true" data-tooltip="true" title="{{ trans('general.created_at_tooltip') }}" data-field="created_at" data-sortable="true" data-formatter="dateDisplayFormatter">
                {{ trans('general.created_at') }}
            </th>
            <th data-visible="true" data-tooltip="true" title="{{ trans('general.action_date_tooltip') }}"  data-field="action_date" data-sortable="true" data-formatter="dateDisplayFormatter">
                {{ trans('general.date') }}
            </th>
            <th data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">
                {{ trans('general.created_by') }}
            </th>
            <th data-visible="true" data-field="action_type">
                {{ trans('general.action') }}
            </th>
            <th class="col-sm-2" data-field="file" data-visible="false" data-formatter="fileUploadNameFormatter">
                {{ trans('general.file_name') }}
            </th>
            <th data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">
                {{ trans('general.item') }}
            </th>
            <th data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">
                {{ trans('general.target') }}
            </th>
            <th data-field="note">
                {{ trans('general.notes') }}
            </th>
            <th data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">
                {{ trans('general.signature') }}
            </th>
            <th data-visible="false" data-field="file" data-visible="false"  data-formatter="fileUploadFormatter">
                {{ trans('general.download') }}
            </th>
            <th data-field="log_meta" data-visible="true" data-formatter="changeLogFormatter">
                {{ trans('admin/hardware/table.changed')}}
            </th>
            <th data-field="remote_ip" data-visible="false" data-sortable="true">
                {{ trans('admin/settings/general.login_ip') }}
            </th>
            <th data-field="user_agent" data-visible="false" data-sortable="true">
                {{ trans('admin/settings/general.login_user_agent') }}
            </th>
            <th data-field="action_source" data-visible="false" data-sortable="true">
                {{ trans('general.action_source') }}
            </th>
        </tr>
        </thead>

    </table>
</div>
<!-- end non-ajaxed file listing table -->