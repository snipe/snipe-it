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






 @livewire('slack-settings-form',  ['setting' => $setting])












