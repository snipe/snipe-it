{{-- Today widget: agenda-style list of everything happening today
     across every HasCalendarEvents source. Uses the same reusable
     snipeit-calendar bundle as the main /calendar page, initialized
     with listUpcoming (rolling 7 days from today). Renders just the
     box. Parent dashboard blade owns the row + col wrapper. --}}
@can('canViewUsersAndCheckoutables')
    <div class="box box-default">
        <div class="box-header with-border">
            <h2 class="box-title">
                <a href="{{ route('calendar.index') }}">{{ trans('general.calendar_upcoming') }}</a>
            </h2>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" aria-hidden="true">
                    <x-icon type="minus"/>
                    <span class="sr-only">{{ trans('general.collapse') }}</span>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div id="dashboard-today-calendar"></div>
        </div>
        {{-- Matches the "View all" btn-theme footers on the sibling
             dashboard panels. Shown only when the widget's
             onFetchMeta reports the API hit its row cap. --}}
        <div id="dashboard-today-more" class="box-footer text-center" style="display:none;">
            <a href="{{ route('calendar.index') }}" class="btn btn-theme btn-sm btn-block" id="dashboard-today-more-link"></a>
        </div>
    </div>
@endcan
