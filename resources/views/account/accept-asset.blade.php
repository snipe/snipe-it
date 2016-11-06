@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Accept {{ $item->showAssetName() }}
    @parent
@stop


{{-- Page content --}}
@section('content')

    
<link rel="stylesheet" href="{{ asset('assets/css/signature-pad.css') }}">

<style>
.form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
    padding-top: 17px;
    padding-right: 10px;
}

#eula_div {
    width: 100%;
    height: 200px;
    overflow: scroll;
}

</style>


<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="logId" value="{{ $findlog->id }}" />


<div class="row">
    <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

        <div class="panel box box-default">

            <div class="box-body">
                <div class="col-md-12">


                <div class="radio">
                    <label>
                        <input type="radio" name="asset_acceptance" id="accepted" value="accepted">
                        I accept
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="asset_acceptance" id="declined" value="declined">
                        I decline
                    </label>
                </div>

                @if ($item->getEula())
                <div class="col-md-12" style="padding-top: 20px">
                    <div id="eula_div">
                        {!!  $item->getEula() !!}
                    </div>
                 </div>
                @endif

                @if ($snipeSettings->require_accept_signature=='1')
                <div class="col-md-12 col-sm-12 text-center" style="padding-top: 20px">

                    <h3>Sign below to indicate that you agree to the terms of service:</h3>

                    <div id="signature-pad" class="m-signature-pad col-md-12 col-sm-12">
                        <div class="m-signature-pad--body col-md-12 col-sm-12">
                            <canvas></canvas>
                            <input type="hidden" name="signature_output" id="signature_output">
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                            <button type="button" class="btn btn-sm btn-default clear" data-action="clear" id="clear_button">Clear</button>
                        </div>
                    </div>
                </div>
                @endif




                </div><!-- / col-md-7 col-sm-12 -->

            </div> <!-- / box-body -->
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-success" id="submit-button"><i class="fa fa-check icon-white"></i> {{ trans('general.submit') }}</button>
            </div><!-- /.box-footer -->
        </div> <!-- / box-default -->
    </div> <!-- / col -->
</div> <!-- / row -->

</form>

@section('moar_scripts')

    <script src="{{ asset('assets/js/signature_pad.min.js') }}"></script>
    <script>
        var wrapper = document.getElementById("signature-pad"),
                clearButton = wrapper.querySelector("[data-action=clear]"),
                saveButton = wrapper.querySelector("[data-action=save]"),
                canvas = wrapper.querySelector("canvas"),
                signaturePad;

        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        signaturePad = new SignaturePad(canvas);

        $('#clear_button').on("click", function (event) {
            signaturePad.clear();
        });

        $('#submit-button').on("click", function (event) {
            if (signaturePad.isEmpty()) {
                alert("Please provide signature first.");
                return false;
            } else {
                $('#signature_output').val(signaturePad.toDataURL());
            }
        });

    </script>
@stop

@stop
