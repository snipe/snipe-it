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
                <p>Your API endpoint is located at:<br>
                <code>{{ url('/api/v1') }}</code></p>

                <p>When you generate an API token, be sure to copy it down immediately as they will not be visible to you again. </p>

                <p>API tokens will expire in {{ config('passport.expiration_years') }} years.</p>
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
