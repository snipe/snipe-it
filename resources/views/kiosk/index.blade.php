@extends('layouts/kiosk')

{{-- Page title --}}
@section('title')
    Kiosk Menu
    @parent
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title"> Options </h2>
                </div>
                <div class="box-body">
                    <div class="col-md-3">
                        <i class="fas fa-undo-alt"></i>
                        <a href="{{ route('kiosk/checkin') }}">Check-In</a>
                    </div>
                    <div class="col-md-3">
                        <i class="fas fa-cart-arrow-down"></i>
                        <a href="{{ route('kiosk/checkout') }}">Check-Out</a>
                    </div>
                    <div class="col-md-3">
                        <i class="fas fa-clipboard-check"></i>
                        <a href="{{ route('kiosk/audit') }}">Audit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop