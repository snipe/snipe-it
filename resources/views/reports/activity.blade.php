@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.activity_report') }} 
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">

                <table
                name="activityReport"
                data-toolbar="#toolbar"
                class="table table-striped snipe-table"
                id="table"
                data-url="{{ route('api.activity.index') }}"
                data-cookie="true"
                data-cookie-id-table="activityReportTable">
                    <thead>
                        <tr>
                            <th data-field="icon" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter"></th>
                            <th class="col-sm-3" data-searchable="false" data-sortable="true" data-field="created_at" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                            <th class="col-sm-2" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                            <th class="col-sm-2" data-field="action_type">{{ trans('general.action') }}</th>
                            <th class="col-sm-1" data-field="type" data-formatter="itemTypeFormatter">{{ trans('general.type') }}</th>
                            <th class="col-sm-3" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                            <th class="col-sm-2" data-field="target" data-formatter="polymorphicItemFormatter">To</th>
                            <th class="col-sm-1" data-field="note">{{ trans('general.notes') }}</th>
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
