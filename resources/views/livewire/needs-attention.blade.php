<div class="box box-default">
    <div class="box-header with-border">
        <h2 class="box-title">{{ trans('general.dashboard_attention') }}</h2>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                <x-icon type="minus"/>
                <span class="sr-only">{{ trans('general.collapse') }}</span>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{-- Two-column layout inside each row: label flexes to fill,
             badge column has a fixed min-width so "1" and "1,247" line
             up in the same vertical spine instead of the label text
             bouncing around with the badge width. See
             .dashboard-attention-list in overrides.less. --}}
        <ul class="list-group list-group-unbordered dashboard-attention-list" style="margin-bottom: 0;">
            @can('audit', \App\Models\Asset::class)
                <li class="list-group-item">
                    <a href="{{ route('assets.audit.due') }}">
                        <x-icon type="asset" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_overdue_audits') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($overdueAudits) }}</span>
                    </a>
                </li>
            @endcan
            @can('checkin', \App\Models\Asset::class)
                <li class="list-group-item">
                    <a href="{{ route('assets.checkins.due') }}">
                        <x-icon type="asset" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_overdue_checkins') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($overdueCheckins) }}</span>
                    </a>
                </li>
            @endcan
            @if (Gate::allows('view', \App\Models\Asset::class)
                 || Gate::allows('view', \App\Models\Accessory::class)
                 || Gate::allows('view', \App\Models\Consumable::class)
                 || Gate::allows('view', \App\Models\Component::class)
                 || Gate::allows('view', \App\Models\License::class))
                {{-- Unaccepted acceptances span every checkoutable
                     type. Hide the row entirely when the caller
                     can't view any of them, since NeedsAttention's
                     mount() already zeros the count for them
                     anyway. Prevents an "Unaccepted acceptances 0"
                     line showing to a users-only viewer. --}}
                <li class="list-group-item">
                    <a href="{{ route('reports/unaccepted_assets') }}">
                        <x-icon type="signature" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_unaccepted_assets') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($pendingAcceptancesCount) }}</span>
                    </a>
                </li>
            @endif
            @can('canCheckoutAtLeastOneItemType')
                <li class="list-group-item">
                    <a href="{{ route('requests.index') }}">
                        <i class="fa-solid fa-boxes-packing fa-fw" aria-hidden="true"></i>
                        <span class="dashboard-attention-label">{{ trans('general.pending_requests') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($pendingRequestsCount) }}</span>
                    </a>
                </li>
            @endcan

            @can('view', \App\Models\Asset::class)
                <li class="list-group-item">
                    <a href="{{ $assetsPastEol > 0 ? route('hardware.index', ['past_eol' => 1]) : route('hardware.index') }}">
                        <x-icon type="asset" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_assets_past_eol') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($assetsPastEol) }}</span>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('maintenances.index', ['upcoming_status' => 'overdue']) }}">
                        <x-icon type="maintenances" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_overdue_maintenances') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($overdueMaintenances) }}</span>
                    </a>
                </li>
            @endcan
            @can('view', \App\Models\License::class)
                <li class="list-group-item">
                    <a href="{{ route('licenses.index') }}">
                        <x-icon type="license" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_licenses_expiring_soon') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($licensesExpiringSoon) }}</span>
                    </a>
                </li>
            @endcan
            @can('view', \App\Models\User::class)
                <li class="list-group-item">
                    <a href="{{ route('users.index') }}">
                        <x-icon type="users" class="fa-fw"/>
                        <span class="dashboard-attention-label">{{ trans('general.dashboard_users_offboarding_soon') }}</span>
                        <span class="badge dashboard-attention-count">{{ number_format($usersOffboardingSoon) }}</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</div>
