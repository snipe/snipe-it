@can('admin')
    @if ((config('services.baremetrics.enabled')=='true') && (config('services.baremetrics.app_key')) && (config('services.baremetrics.stripe_id')))
        <script>
            !function(){if(window.barepay&&window.barepay.created)window.console&&console.error&&console.error("Barepay snippet included twice.");else{window.barepay={created:!0};var a=document.createElement("script");a.src="https://baremetrics-dunning.baremetrics.com/js/application.js",a.async=!0;var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b),

                window.barepay.params = {
                    access_token_id: "{{ config('services.baremetrics.app_key') }}", // Your Recover API public key
                    customer_oid: "{{ config('services.baremetrics.stripe_id') }}" // Customer ID whose card you're looking to update
                }

            }}();
        </script>
        @else
    @endif
@endcan
