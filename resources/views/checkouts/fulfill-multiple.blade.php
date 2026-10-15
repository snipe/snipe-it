@extends('layouts/default')

@section('title')
    {{ trans('admin/hardware/general.fulfill_multiple') }}
    @parent
@stop

@section('content')

    <x-container class="col-md-6 col-md-offset-3">
        <x-form :route="$formRoute" id="fulfill_multiple_form">

            <x-box header="{{ $item->display_name ?? $item->name }} ({{ (int) $item->numRemaining() }} {{ trans('admin/components/general.remaining') }})">

                {{-- Check-all toggle. Uses the shared
                     data-toggle="check-all" handler from
                     snipeit.js which walks the closest form and
                     toggles every non-disabled checkbox. Sits in
                     the col-md-3 label slot so it lines up with
                     each row's checkbox below. Wrapped in a
                     .form-control label (same shape as the row-
                     level <x-form.checkbox-inline>) so the
                     checkbox + text stay inline instead of
                     wrapping to two lines. --}}
                <div class="form-group">
                    <div class="col-md-3">
                        <label class="form-control">
                            <input type="checkbox" data-toggle="check-all">
                            {{ trans('general.select_all_none') }}
                        </label>
                    </div>
                </div>

                <x-checkout.notification-callout :item="$item" />

                {{-- One row per pending CheckoutRequest, ordered
                     oldest-first (waiting-list). Admin ticks the
                     ones to fulfill; rows left unchecked stay
                     pending. Qty defaults to what was requested;
                     the controller re-checks under lock during the
                     transaction so a stale page load can't over-
                     fulfill on submit. --}}
                @foreach ($pendingRequests as $request)
                    <x-checkout.recipient-row
                        :request="$request"
                        :requester="$request->user"
                        :company-id="$item->company_id ?? null"
                        :max-qty="$remaining"
                        :show-qty="! ($hideQty ?? false)"
                    />
                @endforeach

                <x-slot:customfooter>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn btn-link" href="{{ route('requests.index') }}">
                                    {{ trans('general.cancel') }}
                                </a>
                            </div>
                            <div class="col-md-9 text-right">
                                <x-input.button class="btn-success" id="submit_button">
                                    <x-icon type="checkmark" class="icon-white" />
                                    {{ trans('general.checkout') }}
                                </x-input.button>
                            </div>
                        </div>
                    </div>
                </x-slot:customfooter>

            </x-box>

        </x-form>
    </x-container>

@stop
