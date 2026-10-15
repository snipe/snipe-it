@can('view', \App\Models\Asset::class)
    <div class="box box-default">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ (\App\Models\Setting::getSettings()->dash_chart_type == 'name') ? trans('general.assets_by_status') : trans('general.assets_by_status_type') }}
            </h2>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                    <x-icon type="minus"/>
                    <span class="sr-only">{{ trans('general.collapse') }}</span>
                </button>
            </div>
        </div>
        {{-- Fixed-height wrapper with position:relative is the stable
             Chart.js responsive pattern. Canvas inside has no
             dimensions of its own and the responsive resize fills the
             wrapper. Height:100% here caused a resize loop against
             the flex-stretched box-body. Pinning to 300px gives the
             pie enough room without dominating the row. --}}
        <div class="box-body dashboard-chart-body">
            <div class="chart-responsive" style="position: relative; height: 300px;">
                <canvas id="statusPieChart"></canvas>
            </div>
        </div>
    </div>
@endcan
