@extends('layouts/default')

{{-- Page title --}}
@section('title')

@parent
@stop

{{-- Page content --}}
@section('content')

<style>
.form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
    padding-top: 17px;
    padding-right: 10px;
}

.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
    margin-left: -40px;
}
</style>
<div class="row header">
    <div class="col-md-12">

        <h3>
        Accept {{ $item->showAssetName() }}</h3>
    </div>
</div>


<div class="col-md-12">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="logId" value="{{ $findlog->id }}" />

        <div class="radio">
          <label>
            <input type="radio" name="asset_acceptance" id="accepted" value="accepted"> I accept
          </label>
        </div>

        <div class="radio">
          <label>
            <input type="radio" name="asset_acceptance" id="declined" value="declined"> I decline
          </label>
        </div>


        <!-- Form actions -->
        <div class="form-group">
            <div class="col-md-7 col-md-offset-3">
                <button type="submit" class="btn btn-success">Submit </button>
            </div>
        </div>
    </form>
    </div>
</div>

@stop
