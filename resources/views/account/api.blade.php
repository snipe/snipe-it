@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Personal API Keys
    @parent
@stop

{{-- Page content --}}
@section('content')


        <div class="row">
            <div class="col-md-8">

                 @if (!config('app.lock_passwords'))
                    <passport-personal-access-tokens
                        token-url="{{ url('oauth/personal-access-tokens') }}"
                        scopes-url="{{ url('oauth/scopes') }}">
                    </passport-personal-access-tokens>
                 @else
                     <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                @endif
            </div>
            <div class="col-md-4">
                <p>When you generate an API token, be sure to copy it down immediately as they will not be visible to you again. </p>

                <p>API tokens will expire in: <strong>{{ config('passport.expiration_years') }} years</strong>.</p>

                <p>Your API base url is located at:<br>
                <code>{{ url('/api/v1') }}/&lt;endpoint&gt;</code></p>
                <p>Please check the <a href="https://snipe-it.readme.io/reference">API reference</a> to find specific API endpoints.</p>
            </div>
        </div>

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
    new Vue({
        el: "#app",
    });
</script>
@endsection
