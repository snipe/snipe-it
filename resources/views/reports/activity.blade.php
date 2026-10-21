@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.activity_report') }} 
@parent
@stop

@section('header_right')
    <form method="POST" action="{{ route('reports.activity.post') }}" accept-charset="UTF-8" class="form-horizontal">
    {{csrf_field()}}
        <button type="submit" class="btn btn-theme">
        <x-icon type="download" />
        {{ trans('general.download_all') }}
    </button>
    </form>
@stop

{{-- Page content.
     $typeFilters and $actionTypes are prepared in
     ReportsController::getActivityReport from the ActivityItemType and
     ActionType enums. --}}
@section('content')
    <x-container>
        <x-box>
                {{-- Standalone filter row above the table (not wired via
                     bs-table's data-toolbar) so the filters don't share
                     a row with the search / columns / export / refresh
                     controls on narrow viewports. nowrap keeps the
                     filters on one line. No overflow property, because
                     overflow on either axis creates a clipping region
                     that eats the datepicker popup when it opens below
                     the input. --}}
                {{-- All four multi-selects use the shared .js-select2-
                     checkboxes init in snipeit.js: compact "N selected"
                     collapsed state, checkbox rendering in the open
                     dropdown, badge strip below with X-remove, and
                     Select All / Clear buttons. Static mode (no data-
                     endpoint) reads from the pre-rendered <option>
                     tags. The user picker is AJAX against the users
                     selectlist. --}}
                {{-- Combined badge strip for all four filters. Each
                     widget's own .js-select2-checkboxes-badges div
                     is redirected into this shared container by
                     snipeit.js (via data-badges-container). The CSS
                     below makes those per-widget wrappers display:
                     contents so all badges visually render in a
                     single flex-wrap row below the toolbar. --}}
                <style>
                    #activityReportFilterBadges {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 4px;
                        padding: 0 0 10px;
                    }
                    #activityReportFilterBadges .js-select2-checkboxes-badges-shared {
                        display: contents;
                        margin: 0;
                    }
                </style>
                <div id="activityReportToolbar" style="padding: 5px 0 10px; display: flex; gap: 8px; align-items: flex-start; flex-wrap: nowrap;">
                    <div style="flex: 0 0 auto; width: 240px;">
                        <select
                            id="activityReportItemTypeFilter"
                            class="js-select2-checkboxes form-control" data-badges-container="#activityReportFilterBadges"
                            aria-label="{{ trans('general.item_type_label') }}"
                            data-placeholder="{{ trans('general.item_type_label') }}"
                            data-select-all="1"
                            data-select-all-label="{{ trans('general.select_all') }}"
                            data-clear-all-label="{{ trans('general.deselect_all') }}"
                            multiple
                            style="width: 100%;"
                        >
                            @foreach ($typeFilters as $filter)
                                <option value="{{ $filter['value'] }}" data-icon="{{ $filter['icon'] }}">{{ $filter['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="flex: 0 0 auto; width: 240px;">
                        <select
                            id="activityReportTargetTypeFilter"
                            class="js-select2-checkboxes form-control" data-badges-container="#activityReportFilterBadges"
                            aria-label="{{ trans('general.target_type_label') }}"
                            data-placeholder="{{ trans('general.target_type_label') }}"
                            data-select-all="1"
                            data-select-all-label="{{ trans('general.select_all') }}"
                            data-clear-all-label="{{ trans('general.deselect_all') }}"
                            multiple
                            style="width: 100%;"
                        >
                            @foreach ($typeFilters as $filter)
                                <option value="{{ $filter['value'] }}" data-icon="{{ $filter['icon'] }}">{{ $filter['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="flex: 0 0 auto; width: 240px;">
                        <select
                            id="activityReportActionTypeFilter"
                            class="js-select2-checkboxes form-control" data-badges-container="#activityReportFilterBadges"
                            aria-label="{{ trans('general.action_type_label') }}"
                            data-placeholder="{{ trans('general.action_type_label') }}"
                            data-select-all="1"
                            data-select-all-label="{{ trans('general.select_all') }}"
                            data-clear-all-label="{{ trans('general.deselect_all') }}"
                            multiple
                            style="width: 100%;"
                        >
                            @foreach ($actionTypes as $actionType)
                                <option value="{{ $actionType }}">{{ ucwords($actionType) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- AJAX user picker on the same .js-select2-
                         checkboxes init. Searches against the users
                         selectlist endpoint (FMCS-scoped by
                         Company::scopeCompanyables). The initial-load
                         JS reads created_by from the URL and hydrates
                         chips for each matching user. --}}
                    <div style="flex: 0 0 auto; width: 340px;">
                        <select
                            id="activityReportCreatedByFilter"
                            class="js-select2-checkboxes" data-badges-container="#activityReportFilterBadges"
                            data-endpoint="users"
                            data-placeholder="{{ trans('general.created_by_label') }}"
                            aria-label="{{ trans('general.created_by_label') }}"
                            multiple
                            style="width: 100%;"
                        >
                        </select>
                    </div>

                    <div style="flex: 0 0 auto; width: 150px;">
                        <x-input.datepicker
                            id="activityReportCreatedAtFrom"
                            name="created_at_from"
                            :placeholder="trans('general.date_from')"
                        />
                    </div>
                    <div style="flex: 0 0 auto; width: 150px;">
                        <x-input.datepicker
                            id="activityReportCreatedAtTo"
                            name="created_at_to"
                            :placeholder="trans('general.date_to')"
                        />
                    </div>
                </div>
                <div id="activityReportFilterBadges" aria-live="polite"></div>
                <table
                    data-columns="{{ \App\Presenters\HistoryPresenter::dataTableLayout() }}"
                        data-cookie-id-table="activityReport"
                        data-id-table="activityReport"
                        data-side-pagination="server"
                        data-advanced-search="false"
                        data-sort-order="desc"
                        data-sort-name="created_at"
                        id="activityReport"
                    data-url="{{ $canManageReports ? route('api.activity.index') : route('api.dashboard.activity') }}"
                    class="table table-striped snipe-table snipe-table--sticky-right-1"
                        data-export-options='{
                        "fileName": "activity-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
                </table>
        </x-box>
    </x-container>
@stop


@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'activity-export', 'search' => true])

<script nonce="{{ csrf_token() }}">
    // Activity report toolbar. Six filters all round-trip through the
    // browser URL so the view is shareable, bookmarkable, and
    // back/forward restores the prior filter state.
    //
    //   item_type       select2 of allowlisted types + icon chips
    //   target_type     same list, filters on the target column
    //   action_type     select2 of ActionType enum values
    //   created_by      ajax user picker (FMCS-scoped by snipeit.js)
    //   created_at_from datepicker, start-of-day inclusive on server
    //   created_at_to   datepicker, end-of-day inclusive on server
    //
    // Wrapped in $(function(){}) so snipeit.js has already auto-inited
    // the .js-data-ajax user picker and the datepickers by the time we
    // bind our change handlers. Change handlers are delegated off the
    // toolbar container (not bound directly) so handler attachment
    // does not depend on each select being present / wrapped at bind
    // time.
    $(function () {
        var baseUrl = @json($canManageReports ? route('api.activity.index') : route('api.dashboard.activity'));
        var userLookupUrl = @json(route('api.users.selectlist'));

        var $itemFilter = $('#activityReportItemTypeFilter');
        var $targetFilter = $('#activityReportTargetTypeFilter');
        var $actionTypeFilter = $('#activityReportActionTypeFilter');
        var $createdByFilter = $('#activityReportCreatedByFilter');
        var $createdAtFrom = $('#activityReportCreatedAtFrom');
        var $createdAtTo = $('#activityReportCreatedAtTo');

        // Flag flipped on while popstate / initial-load hydration is
        // writing values back into the dropdowns + datepickers from the
        // URL. The change / dp.change handlers skip URL re-push and
        // table refetch while this is on, since hydration already
        // batches those at the end.
        var isHydrating = false;

        // Build the current filter params. Multi-selects return arrays
        // from .val() (jQuery converts to [], [a], [a,b], etc.) and
        // $.param serializes those as ?item_type[]=a&item_type[]=b.
        // Empty arrays and empty strings are omitted so we never emit
        // a bare ?item_type= with no value.
        function currentFilterParams() {
            var params = {};
            var multiFilters = {
                item_type: $itemFilter.val(),
                target_type: $targetFilter.val(),
                action_type: $actionTypeFilter.val(),
                created_by: $createdByFilter.val(),
            };
            Object.keys(multiFilters).forEach(function (key) {
                var val = multiFilters[key];
                if (Array.isArray(val) && val.length > 0) {
                    params[key] = val;
                }
            });
            if ($createdAtFrom.val()) params.created_at_from = $createdAtFrom.val();
            if ($createdAtTo.val()) params.created_at_to = $createdAtTo.val();
            return params;
        }

        // Refetch the bs-table body with the current filter params.
        // The URL is updated by bs-table's addrbar extension via the
        // patched updateHistoryState below. Pushing our own history
        // state here would be clobbered on the next onLoadSuccess
        // (addrbar re-pushes with its own known keys only).
        function refreshActivityReport() {
            var qs = $.param(currentFilterParams());
            $('#activityReport').bootstrapTable('refresh', {
                url: baseUrl + (qs ? '?' + qs : ''),
                silent: true,
            });
        }

        // Set a (multi) select's value from hydration. Accepts either
        // a scalar or an array. Triggers plain 'change' so select2
        // (which binds its UI sync on plain 'change', not on namespaced
        // events) re-renders chips. The isHydrating flag keeps the
        // change handler from re-pushing URL state in a loop.
        function setSelect($select, value) {
            var normalized = value == null ? [] : (Array.isArray(value) ? value : [value]);
            var current = $select.val() || [];
            if (!Array.isArray(current)) {
                current = current ? [current] : [];
            }
            if (current.length === normalized.length && current.every(function (v, i) { return String(v) === String(normalized[i]); })) {
                return;
            }
            $select.val(normalized).trigger('change');
        }

        // Set a datepicker's value without opening the picker. Blade's
        // datepicker component wraps the input in a div[data-provide=
        // datetimepicker] bound by snipeit.js, so we set the underlying
        // input value and let the picker read it on next open.
        function setDate($dateInput, value) {
            if ($dateInput.val() === (value || '')) {
                return;
            }
            $dateInput.val(value || '');
        }

        // Hydrate the created_by multi-picker from an array of ids in
        // the URL. The ajax picker starts empty, so each id needs its
        // user record fetched to populate the chip label. One request
        // per id against the users selectlist with search=id. Chips
        // appended as they come back, which is fine because select2
        // re-renders on each append.
        function hydrateCreatedByFromUrl(userIds) {
            if (!userIds || userIds.length === 0) {
                return;
            }
            userIds.forEach(function (userId) {
                if (!userId) {
                    return;
                }
                $.ajax({
                    url: userLookupUrl,
                    data: { search: userId },
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                }).done(function (response) {
                    var rows = (response && response.results) || [];
                    var match = rows.find(function (r) { return String(r.id) === String(userId); });
                    if (!match) {
                        return;
                    }
                    var $opt = new Option(match.text, match.id, true, true);
                    $createdByFilter.append($opt).trigger('change');
                });
            });
        }

        // select2 init for all four selects is handled by snipeit.js's
        // .js-select2-checkboxes auto-init path. That gives us the
        // compact "N selected" collapsed state, dropdown-stays-open on
        // tick, badge strip with X-remove, and the Select All / Clear
        // buttons for free.

        // Event delegation off the toolbar container so handler
        // attachment is independent of whether each select / datepicker
        // has been wrapped by select2 / eonasdan yet. 'change' fires on
        // every select interaction and on direct typing in a datepicker
        // input. 'dp.change' is eonasdan's own event, fired on the
        // .input-group.date wrapper for calendar picks.
        var filterHandler = function () {
            if (isHydrating) {
                return;
            }
            refreshActivityReport();
        };
        $('#activityReportToolbar')
            .on('change', 'select, input', filterHandler)
            .on('dp.change', '.input-group.date', filterHandler);

        // Patch bs-table's addrbar URL management to preserve our
        // custom filter params. addrbar owns the query string and
        // re-pushes it on every onLoadSuccess with only its own known
        // keys (page/size/sort/order/search), which would otherwise
        // clobber any custom params we push ourselves. Same pattern
        // the advanced-search deeplinking uses in bootstrap-table.blade.
        // Runs after bs-table init because the partial's $(function(){})
        // registers before ours.
        var preservedKeys = ['item_type', 'target_type', 'action_type', 'created_by', 'created_at_from', 'created_at_to'];
        var tableInstance = $('#activityReport').data('bootstrap.table');
        if (tableInstance && typeof tableInstance.updateHistoryState === 'function') {
            var origUpdateHistoryState = tableInstance.updateHistoryState;
            tableInstance.updateHistoryState = function () {
                var params = this.searchParams;
                if (params) {
                    // Strip both scalar (key) and array (key[]) forms
                    // so a cleared filter actually leaves the URL.
                    preservedKeys.forEach(function (k) {
                        params.delete(k);
                        params.delete(k + '[]');
                    });
                    var filterParams = currentFilterParams();
                    Object.keys(filterParams).forEach(function (k) {
                        var v = filterParams[k];
                        if (Array.isArray(v)) {
                            v.forEach(function (item) { params.append(k + '[]', item); });
                        } else {
                            params.set(k, v);
                        }
                    });
                }
                return origUpdateHistoryState.apply(this, arguments);
            };
        }

        // URL multi-value keys use the ?key[]=a&key[]=b convention
        // (what jQuery $.param emits for arrays and what Laravel
        // reads as an array). URLSearchParams.getAll('key[]') returns
        // the full list. Falls back to a single scalar lookup for
        // callers that encoded as ?key=val.
        function readMultiParam(urlParams, key) {
            var arr = urlParams.getAll(key + '[]');
            if (arr.length > 0) {
                return arr;
            }
            var single = urlParams.get(key);
            return single ? [single] : [];
        }

        function hasAnyFilterParam(urlParams) {
            var keys = ['item_type', 'target_type', 'action_type', 'created_by'];
            for (var i = 0; i < keys.length; i++) {
                if (urlParams.has(keys[i]) || urlParams.has(keys[i] + '[]')) {
                    return true;
                }
            }
            return urlParams.has('created_at_from') || urlParams.has('created_at_to');
        }

        window.addEventListener('popstate', function () {
            var p = new URLSearchParams(window.location.search);
            isHydrating = true;
            setSelect($itemFilter, readMultiParam(p, 'item_type'));
            setSelect($targetFilter, readMultiParam(p, 'target_type'));
            setSelect($actionTypeFilter, readMultiParam(p, 'action_type'));
            setDate($createdAtFrom, p.get('created_at_from'));
            setDate($createdAtTo, p.get('created_at_to'));
            // created_by needs its labels refetched since the ajax picker
            // only knows about options it has already loaded.
            $createdByFilter.empty();
            hydrateCreatedByFromUrl(readMultiParam(p, 'created_by'));
            isHydrating = false;
            refreshActivityReport();
        });

        var initialParams = new URLSearchParams(window.location.search);
        if (hasAnyFilterParam(initialParams)) {
            isHydrating = true;
            setSelect($itemFilter, readMultiParam(initialParams, 'item_type'));
            setSelect($targetFilter, readMultiParam(initialParams, 'target_type'));
            setSelect($actionTypeFilter, readMultiParam(initialParams, 'action_type'));
            setDate($createdAtFrom, initialParams.get('created_at_from'));
            setDate($createdAtTo, initialParams.get('created_at_to'));
            hydrateCreatedByFromUrl(readMultiParam(initialParams, 'created_by'));
            isHydrating = false;
            refreshActivityReport();
        }
    });
</script>
@stop
