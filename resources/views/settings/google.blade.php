@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.google_login') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <x-container class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <x-form :route="route('settings.google.save')">
            <x-box>
                <x-slot:header>
                    <x-icon type="google"/> {{ trans('admin/settings/general.google_login') }}
                </x-slot:header>

                {{-- Single demo-mode banner. Renders nothing outside demo mode. --}}
                <x-demo-callout />

                <div class="col-md-12">

                    {{-- Google OAuth redirect URL. Read-only display of the
                         computed callback URL derived from app.url — not a
                         form input, so hand-rolled rather than routed
                         through <x-form.row>. --}}
                    <div class="form-group">
                        <div class="col-md-3 control-label">
                            <strong>{{ trans('admin/settings/general.redirect_url') }}</strong>
                        </div>
                        <div class="col-md-8">
                            <p class="form-control-static"><code>{{ config('app.url') }}/google/callback</code></p>
                            <p class="help-block">{!! trans('admin/settings/general.google_callback_help') !!}</p>
                        </div>
                    </div>

                    {{-- Enable Google login (click-target checkbox) --}}
                    <x-form.checkbox-row
                        name="google_login"
                        :label="trans('admin/settings/general.enable_google_login')"
                        :help_text="trans('admin/settings/general.enable_google_login_help')"
                        :item="$setting"
                        :disabled="config('app.lock_passwords') === true"
                    />

                    {{-- Google OAuth Client ID --}}
                    <x-form.row
                        :label="trans('admin/settings/general.client_id')"
                        name="google_client_id"
                        input_div_class="col-md-8"
                    >
                        <x-slot:input>
                            <x-input.text
                                name="google_client_id"
                                :value="old('google_client_id', $setting->google_client_id)"
                                :placeholder="trans('general.example') . '000000000000-XXXXXXXXXXX.apps.googleusercontent.com'"
                                :disabled="config('app.lock_passwords') === true"
                            />
                        </x-slot:input>
                    </x-form.row>

                    {{-- Google OAuth Client Secret. In demo mode, show X's
                         instead of the real secret so it doesn't leak. --}}
                    <x-form.row
                        :label="trans('admin/settings/general.client_secret')"
                        name="google_client_secret"
                        input_div_class="col-md-8"
                    >
                        <x-slot:input>
                            @if (config('app.lock_passwords') === true)
                                <x-input.text
                                    name="google_client_secret"
                                    value="XXXXXXXXXXXXXXXXXXXXXXX"
                                    disabled
                                />
                            @else
                                <x-input.text
                                    name="google_client_secret"
                                    :value="old('google_client_secret', $setting->google_client_secret)"
                                    :placeholder="trans('general.example') . 'XXXXXXXXXXXX'"
                                />
                            @endif
                        </x-slot:input>
                    </x-form.row>

                </div>

                {{-- Explicit footer preserves the demo-mode-disabled save state
                     that the default x-box.footer doesn't offer. --}}
                <x-slot:customfooter>
                    <div class="box-footer">
                        <div class="text-left col-md-6">
                            <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                        </div>
                        <div class="text-right col-md-6">
                            <x-button.submit class="btn-success" :disabled="config('app.lock_passwords') === true" />
                        </div>
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>

@stop
