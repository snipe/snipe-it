{{-- Same gate as the /requests page + API endpoint + nav link
     (see AuthServiceProvider::canCheckoutAtLeastOneItemType). --}}
@can('canCheckoutAtLeastOneItemType')
    <x-table.bulk-actions
        name="checkoutRequests"
        :action_route="route('requests.bulk-cancel')"
        model_name="checkout_request"
        :actions="[
            'cancel' => ['label' => trans('general.cancel_request')],
        ]"
    />
@endcan
