@extends('layouts/kiosk')

{{-- Page title --}}
@section('title')
    Kiosk Menu
    @parent
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title"> Options </h2>
                </div>
                <div class="box-body">
                    <a href="{{ route('kiosk/checkin') }}">Check-In</a>
                    <a href="{{ route('kiosk/checkout') }}">Check-Out</a>
                    <a href="{{ route('kiosk/audit') }}">Audit</a>
                    <a href="{{ route('home') }}">Return to SnipeIT</a>
                </div>
            </div>
        </div>
    </div>
@stop