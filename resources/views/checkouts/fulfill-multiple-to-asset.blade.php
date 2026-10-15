@extends('layouts/default')

@section('title')
    {{ trans('admin/hardware/general.fulfill_multiple') }}
    @parent
@stop

{{-- Bulk-fulfill for asset-target requestable types (Component,
     AssetModel). Each row picks a specific Asset per request; the
     controller pre-computes the available-asset set per row so the
     picker is a plain <select> (no ajax pagination needed for the
     typical scope). Sibling template checkouts/fulfill-multiple.blade.php
     handles the user-target types (Accessory/Consumable/License). --}}

@section('content')

    <x-container class="col-md-6 col-md-offset-3">
        <x-form :route="$formRoute" id="fulfill_multiple_form">

            <x-box :header="($item->display_name ?? $item->name).($remaining !== null ? ' ('.(int) $remaining.' '.trans('admin/components/general.remaining').')' : '')">

                {{-- Check-all toggle. Uses the shared
                     data-toggle="check-all" handler from
                     snipeit.js which toggles every non-disabled
                     checkbox in the enclosing form. Rows whose
                     available-asset set is empty render their
                     checkbox disabled so this toggle skips them.
                     Sits in the col-md-3 label slot so it lines
                     up with each row's checkbox below; wrapped
                     in a .form-control label so the checkbox +
                     text stay inline. --}}
                <div class="form-group">
                    <div class="col-md-3">
                        <label class="form-control">
                            <input type="checkbox" data-toggle="check-all">
                            {{ trans('general.select_all_none') }}
                        </label>
                    </div>
                </div>

                <x-checkout.notification-callout :item="$item" />

                {{-- $rowContext[$requestId] = ['availableAssets' => Collection, 'emptyMessage' => ?string]
                     Rows whose availableAssets is empty render the
                     row disabled (checkbox unavailable) with the
                     empty message so the admin sees WHY that row
                     can't be fulfilled from this screen. --}}
                @foreach ($pendingRequests as $request)
                    @php ($context = $rowContext[$request->id] ?? ['availableAssets' => collect(), 'defaultAssetId' => null, 'emptyMessage' => null])
                    <x-checkout.asset-picker-row
                        :request="$request"
                        :requester="$request->user"
                        :available-assets="$context['availableAssets']"
                        :default-asset-id="$context['defaultAssetId'] ?? null"
                        :empty-message="$context['emptyMessage']"
                        :show-qty="! ($hideQty ?? false)"
                        :max-qty="$remaining"
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
