{{-- Widget grid for the non-admin, non-empty-inventory dashboard
     branch.

     One flat .row (flex + wrap via .dashboard-row-eq) holding every
     visible widget at its natural col-md width. Bootstrap 3 handles
     the wrapping: when the running col-md total exceeds 12, the next
     widget wraps to a new visual line automatically. `.dashboard-row-eq`
     applies `align-items: stretch` per flex line, so widgets on the
     same visual line still equalize height. That means we get
     consistent-height boxes AND natural reflow when a widget hides,
     without hand-rolling row containment or bin-packing.

     Natural widths (from the historical admin layout):

       - Recent Activity is a wide table (col-md-8).
       - Today Calendar is a narrow agenda list (col-md-4).
       - Assets by Status is a pie chart (col-md-4).
       - Low Stock is a small table (col-md-4).
       - Needs Attention is a short list of counts (col-md-4).
         Wider columns just balloon the label / badge whitespace.
       - Companies / Locations / Categories are summary tables at
         their natural col-md-6. --}}
<div class="row dashboard-row-eq dashboard-row-compact">

    @can('canViewUsersAndCheckoutables')
        <div class="col-md-8">
            <x-dashboard.recent-activity/>
        </div>
        <div class="col-md-4">
            <x-dashboard.today-calendar/>
        </div>
    @endcan

    @can('view', \App\Models\Asset::class)
        <div class="col-md-4">
            <x-dashboard.assets-by-status/>
        </div>
    @endcan

    @if (Gate::allows('view', \App\Models\Consumable::class)
         || Gate::allows('view', \App\Models\Accessory::class)
         || Gate::allows('view', \App\Models\Component::class)
         || Gate::allows('view', \App\Models\AssetModel::class)
         || Gate::allows('view', \App\Models\License::class))
        <div class="col-md-4">
            <x-dashboard.low-stock/>
        </div>
    @endif

    @can('canViewUsersAndCheckoutables')
        <div class="col-md-4">
            {{-- Lazy Livewire component so the eight count queries
                 that back this widget don't sit on the dashboard's
                 critical render path. Rendered as a placeholder on
                 first paint. Livewire fires a follow-up XHR to
                 hydrate the real counts. --}}
            <livewire:needs-attention/>
        </div>

        <div class="col-md-6">
            @if (($snipeSettings->scope_locations_fmcs != '1') && ($snipeSettings->full_multiple_companies_support == '1'))
                <x-dashboard.companies-summary/>
            @else
                <x-dashboard.locations-summary/>
            @endif
        </div>
    @endcan

    @if (Gate::allows('view', \App\Models\Asset::class)
         || Gate::allows('view', \App\Models\Accessory::class)
         || Gate::allows('view', \App\Models\Consumable::class)
         || Gate::allows('view', \App\Models\Component::class)
         || Gate::allows('view', \App\Models\License::class))
        <div class="col-md-6">
            <x-dashboard.categories-summary/>
        </div>
    @endif

</div>
