@extends('layouts/default')

@section('title0')
  {{ trans('admin/hardware/general.requested') }}
  {{ trans('general.assets') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop

{{-- Page content --}}
@section('content')
    <x-container>
        <x-box name="checkoutRequests" sr_only_title>
            <x-slot:table_header>
                {{ trans('admin/hardware/general.requested') }}
            </x-slot:table_header>

            <x-slot:bulkactions>
                <x-table.bulk-checkoutrequests/>
            </x-slot:bulkactions>

            <x-table
                name="checkoutRequests"
                :presenter="\App\Presenters\CheckoutRequestPresenter::dataTableLayout()"
                :api_url="route('api.requests.index')"
                :sort_field="null"
                :fixed_right_number="1"
                :show_search="true"
                export_filename="export-requests-{{ date('Y-m-d') }}"
            />
        </x-box>
        <x-shiftclick/>
    </x-container>

    {{-- Shared adjust-quantity modal, opened by the Adjust Quantity
         button on each request row (see the replenish branch of
         checkoutRequestActionsFormatter). Snipeit.js binds to
         .adjust-quantity and hydrates the modal from the button's
         data-* attrs. --}}
    <x-modals.adjust-quantity />
@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
