@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/components/general.checkout') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

<x-container columns="2">
    <x-page-column class="col-md-7">

        <x-form route="{{ route('components.checkout.store', $snipe_component->id) }}" id="checkout_form">

            <x-box header="{{ $snipe_component->name }} ({{ $snipe_component->numRemaining() }} {{ trans('admin/components/general.remaining') }})">


            @if ($snipe_component->company)
                <x-form.static :label="trans('general.company')">{!! $snipe_component->company->present()->formattedNameLink !!}</x-form.static>
            @endif

            @if ($snipe_component->category)
                <x-form.static :label="trans('general.category')">{!! $snipe_component->category->present()->formattedNameLink !!}</x-form.static>
            @endif

            @include ('partials.forms.edit.asset-select', [
                'translated_name' => trans('general.select_asset'),
                'fieldname' => 'asset_id',
                'company_id' => $snipe_component->company_id,
                'required' => 'true',
                'value' => old('asset_id'),
                // Present when the admin reached this screen from a
                // /requests row; pre-scopes the picker to the
                // requester's assigned assets. See
                // ComponentCheckoutController::create for the wiring.
                // Empty result is intentional when the requester has
                // nothing assigned - the request-context callout
                // above the form tells the admin why the picker is
                // empty (no valid install target).
                'assigned_to' => $requestingUserId ?? null,
            ])

            <x-input.quantity
                name="assigned_qty"
                :value="1"
                :min="1"
                :max="$snipe_component->numRemaining()"
                :label="trans('general.qty')"
            />

            @if ($snipe_component->requireAcceptance() || $snipe_component->getEula() || ($snipeSettings->webhook_endpoint != ''))
                <div class="form-group notification-callout">
                    <div class="col-md-8 col-md-offset-3">
                        <x-callout type="info" role="status">
                            {{-- Components can only be checked out to assets (see
                                 ComponentCheckoutController::store, which forces
                                 checkout_to_type=asset). CheckoutableListener then
                                 resolves the notifiable user by walking to the
                                 target asset's assignee. Use the component-scoped
                                 copy that reflects the "if the asset is assigned
                                 to a user" chain, rather than the generic
                                 user-target copy used by the accessory / consumable
                                 / license / user-scoped checkout screens. --}}
                            @if ($snipe_component->category->require_acceptance == '1')
                                <i class="far fa-envelope fa-fw" aria-hidden="true"></i>
                                {{ trans('admin/categories/general.required_acceptance_component') }}<br>
                            @endif
                            @if ($snipe_component->getEula())
                                <i class="far fa-envelope fa-fw" aria-hidden="true"></i>
                                {{ trans('admin/categories/general.required_eula_component') }}<br>
                            @endif
                            @if ($snipeSettings->webhook_endpoint != '')
                                <i class="fab fa-slack fa-fw" aria-hidden="true"></i>
                                {{ trans('general.webhook_msg_note') }}
                            @endif
                        </x-callout>
                    </div>
                </div>
            @endif

            <x-form.row
                :label="trans('admin/hardware/form.notes')"
                :item="$snipe_component"
                name="note"
                type="textarea"
            />

            <x-slot:customfooter>
                <x-redirect_submit_options
                    index_route="components.index"
                    :button_label="trans('general.checkout')"
                    :options="[
                        'index' => trans('admin/hardware/form.redirect_to_all', ['type' => trans('general.components')]),
                        'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.component')]),
                        'target' => trans('admin/hardware/form.redirect_to_checked_out_to'),
                    ]"
                />
            </x-slot:customfooter>

            </x-box>

        </x-form>

    </x-page-column>

    <x-page-column class="col-md-5">
        <x-checkout-request-context :request="$checkoutRequest" :requestable="$snipe_component" />

        <livewire:checkout-target-panel type="components" defaultTargetType="asset" />
    </x-page-column>

</x-container>

@stop
