@props(['item', 'category' => null])

{{-- Singleton-checkout notification callout: preview of what will fire when the admin
     submits the checkout. Used from hardware, accessories, licenses, and consumables
     checkout screens. --}}

@if ($item->requireAcceptance() || $item->getEula() || $snipeSettings->webhook_endpoint != '')
    <div class="form-group notification-callout">
        <div class="col-md-8 col-md-offset-3">
            <x-callout type="info" role="status">
                @if ($item->requireAcceptance())
                    <x-icon type="email" class="fa-fw"/>
                    {{ trans('admin/categories/general.required_acceptance') }}<br>
                @endif
                @if ($item->requireAcceptance() && (string) $snipeSettings->require_accept_signature === '1')
                    <x-icon type="signature" class="fa-fw"/>
                    {{ trans('admin/categories/general.required_signature') }}<br>
                @endif
                @if ($item->getEula())
                    <x-icon type="email" class="fa-fw"/>
                    {{ trans('admin/categories/general.required_eula') }}<br>
                @endif
                @if ($category?->checkin_email)
                    <x-icon type="email" class="fa-fw"/>
                    {{ trans('admin/categories/general.checkin_email_notification') }}<br>
                @endif
                @if ($snipeSettings->webhook_endpoint != '')
                    <i class="fab fa-slack fa-fw" aria-hidden="true"></i>
                    {{ trans('general.webhook_msg_note') }}
                @endif
            </x-callout>
        </div>
    </div>
@endif

@if ($item->requireAcceptance() || (string) $snipeSettings->require_accept_signature === '1')
    <div class="notification-callout">
        <x-form.checkbox-row
            name="sign_in_place"
            :label="trans('general.sign_in_place')"
            :help_text="trans('general.sign_in_place_help')"
            :checked="old('sign_in_place', session('sign_in_place', false))"
        />
    </div>
@endif
