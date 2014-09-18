@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/countries/table.general_info') {{ $country->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
       
        <h3 class="name">        
        {{{ $country->name }}} </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

            <h6></h6>

                <div class="col-md-12">
                                  
                </div>
        </div>
        <div class="col-md-9 bio">
               <!-- checked out assets table -->
            <h6> </h6>
            <table class="table table-hover">
                    {{ $country->name }}
            
                
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
        <h6><br>:</h6>
        <ul>

        </div>
    </div>
</div>
@stop
