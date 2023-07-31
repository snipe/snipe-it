@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update LDAP/AD Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>

    @livewire('ldap-settings-form')

@stop

