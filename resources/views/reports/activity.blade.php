@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.activity_report') }} 
@parent
@stop

@section('header_right')
    {{ Form::open(['method' => 'post', 'class' => 'form-horizontal']) }}
    {{csrf_field()}}
    <button type="submit" class="btn btn-default">
        <x-icon type="download" />
        {{ trans('general.download_all') }}
    </button>
    {{ Form::close() }}
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">

                <table
                        data-cookie-id-table="activityReport"
                        data-pagination="true"
                        data-id-table="activityReport"
                        data-search="true"
                        data-side-pagination="server"
                        data-show-columns="true"
                        data-show-export="true"
                        data-show-refresh="true"
                        data-sort-order="desc"
                        data-sort-name="created_at"
                        id="activityReport"
                        data-url="{{ route('api.activity.index') }}"
                        data-mobile-responsive="true"
                        class="table table-striped snipe-table"
                        data-export-options='{
                        "fileName": "activity-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>

                    <thead>
                        <tr>
                            <th data-field="id" class="hidden-xs "data-sortable="true" data-visible="false">
                                {{ trans('general.id') }}
                            </th>
                            <th data-field="icon" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter">
                                {{ trans('admin/hardware/table.icon') }}
                            </th>
                            <th class="col-sm-3" data-searchable="false" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">
                                {{ trans('general.date') }}
                            </th>
                            <th class="col-sm-2" data-searchable="true" data-sortable="true" data-field="created_by" data-formatter="usersLinkObjFormatter">
                                {{ trans('general.admin') }}
                            </th>
                            <th class="col-sm-2" data-field="action_type">
                                {{ trans('general.action') }}
                            </th>
                            <th class="col-sm-2" data-field="file" data-visible="false" data-formatter="fileUploadNameFormatter">
                                {{ trans('general.file_name') }}
                            </th>
                            <th class="col-sm-1" data-field="item_type" data-searchable="true" data-formatter="itemTypeFormatter">
                                {{ trans('general.type') }}
                            </th>
                            <th class="col-sm-3" data-field="item.serial" data-visible="false">
                                {{ trans('admin/hardware/table.serial') }}
                            </th>
                            <th class="col-sm-3" data-field="item" data-formatter="polymorphicItemFormatter">
                                {{ trans('general.item') }}
                            </th>
                            <th class="col-sm-2" data-field="target" data-formatter="polymorphicItemFormatter">
                                {{ trans('general.to') }}
                            </th>
                            <th class="col-sm-1" data-field="note" data-sortable="true">
                                {{ trans('general.notes') }}
                            </th>
                            <th class="col-sm-2" data-field="log_meta" data-visible="false" data-formatter="changeLogFormatter">
                                {{ trans('general.changed') }}
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
        </div>
    </div>
</div>
@stop


@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'activity-export', 'search' => true])
@stop
