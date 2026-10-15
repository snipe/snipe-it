@props([
    'item',
])

{{-- Batch equivalent of the notification callout that every
     singleton checkout screen renders. Conditions must match what
     the backend actually does at fulfillment time:
       - the item requires acceptance (acceptance email fires)
       - the item has a EULA attached (EULA email fires)
       - a webhook endpoint is configured (each fulfilled
         checkout POSTs to it)
     Sign-in-place is intentionally not offered here - bulk
     fulfill hands out to N different requesters and there is no
     single-user surface to sign against. --}}

@if ($item->requireAcceptance() || $item->getEula() || $snipeSettings->webhook_endpoint != '')
    <div class="form-group">
        <div class="col-md-12">
            <x-callout type="info" role="status">
                <strong>{{ trans('admin/hardware/message.requests.bulk_fulfill_notification_intro') }}</strong>
                <br>
                @if ($item->requireAcceptance())
                    <x-icon type="email" class="fa-fw"/>
                    {{ trans('admin/categories/general.required_acceptance') }}
                    <br>
                @endif
                @if ($item->requireAcceptance() && (string) $snipeSettings->require_accept_signature === '1')
                    <x-icon type="signature" class="fa-fw"/>
                    {{ trans('admin/categories/general.required_signature') }}
                    <br>
                @endif
                @if ($item->getEula())
                    <x-icon type="email" class="fa-fw"/>
                    {{ trans('admin/categories/general.required_eula') }}
                    <br>
                @endif
                @if ($snipeSettings->webhook_endpoint != '')
                    <i class="fab fa-slack fa-fw" aria-hidden="true"></i>
                    {{ trans('general.webhook_msg_note') }}
                @endif
            </x-callout>
        </div>
    </div>
@endif
