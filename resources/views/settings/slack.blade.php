@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.slack_title') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>

    <!-- CSRF Token -->





                    <p style="padding: 20px;">
                        {!! trans('admin/settings/general.slack_integration_help',array('slack_link' => 'https://my.slack.com/services/new/incoming-webhook')) !!}

{{--                    @if (($setting->slack_channel=='') && ($setting->slack_endpoint==''))--}}
{{--                           {{ trans('admin/settings/general.slack_integration_help_button') }}--}}
{{--                    @endif--}}
{{--                    </p>--}}




                        @livewire('slack-settings-form')



