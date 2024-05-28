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
         /*
           Don't make the password field *look* readonly - this is for usability, so admins don't think they can't edit this field.
         */
        .form-control[readonly] {
            background-color: white;
            color: #555555;
            cursor:text;
        }
    </style>

    @livewire('ldap-settings-form')


    {{Form::close()}}


@stop

