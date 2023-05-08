<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Labels</title>

</head>
<body>

<?php
$settings->labels_width = $settings->labels_width - $settings->labels_display_sgutter;
$settings->labels_height = $settings->labels_height - $settings->labels_display_bgutter;
// Leave space on bottom for 1D barcode if necessary
$qr_size = ($settings->alt_barcode_enabled=='1') && ($settings->alt_barcode!='') ? $settings->labels_height - .3 : $settings->labels_height - 0.1;
?>

<style>
    .container{
        padding: 0;
        display: block;
        overflow: hidden;
        border: 1px solid black;
        text-align: center;
        /* width: {{ $settings->labels_width }}in;
        height: {{ $settings->labels_height }}in; */
        width: 300px;
        height: 300px;
        margin-right: {{ $settings->labels_display_sgutter }}in; /* the gutter */
        margin-bottom: {{ $settings->labels_display_bgutter }}in;

    }
    .text{
        text-align: center;
        font-family: arial, helvetica, sans-serif;
        font-size: {{$settings->labels_fontsize}}pt;
        overflow: hidden;
        display: block;
        margin-top: 9px;
    }

    body {
        font-family: arial, helvetica, sans-serif;
        width: {{ $settings->labels_pagewidth }}in;
        height: {{ $settings->labels_pageheight }}in;
        margin: {{ $settings->labels_pmargin_top }}in {{ $settings->labels_pmargin_right }}in {{ $settings->labels_pmargin_bottom }}in {{ $settings->labels_pmargin_left }}in;
        font-size: {{ $settings->labels_fontsize }}pt;
    }
    /* .label {
        width: {{ $settings->labels_width }}in;
        height: {{ $settings->labels_height }}in;
        width: 350px;
        height: 350px;
        padding: 0in;
        margin-right: {{ $settings->labels_display_sgutter }}in; the gutter
        margin-bottom: {{ $settings->labels_display_bgutter }}in;
        display: inline-block;
        overflow: hidden;
    } */
    /* .page-break  {
        page-break-after:always;
    } */
    div.qr_img {
        /* width: {{ $qr_size }}in;
        height: {{ $qr_size }}in; */
        width: 120px;
        height: 120px;

        /* float: left;
        display: inline-flex; */
        /* padding-right: .15in; */
    }
    img.qr_img {

        width: 120px;
        height: 120px;
        /* margin-top: -6.9%;
        margin-left: -6.9%; */
        margin-left: 74%;
        padding-bottom: 5px;
    }
    /* img.barcode {
        display:block;
        margin-top:-7px;
         width: 100%;
    } */
    div.label-logo {
       text-align: center;
       margin-top: 5px;
       margin-bottom: 1px;
    }
    img.label-logo {
        height: 40%;
        width: 120px;
    }
    /* .qr_text {
        width: {{ $settings->labels_width }}in;
        height: {{ $settings->labels_height }}in;
        padding-top: {{$settings->labels_display_bgutter}}in;
        width: 100px;
        height: 100px;
        margin-top: 50%;
        margin-left: 35%;
        font-family: arial, helvetica, sans-serif;
        font-size: {{$settings->labels_fontsize}}pt;
        padding-right: .0001in;
        overflow: hidden !important;
        display: block;
        word-wrap: break-word;
        word-break: break-all;
    } */
    /* div.barcode_container {

        width: 100%;
        display: inline;
        overflow: hidden;
    } */
    .next-padding {
        margin: {{ $settings->labels_pmargin_top }}in {{ $settings->labels_pmargin_right }}in {{ $settings->labels_pmargin_bottom }}in {{ $settings->labels_pmargin_left }}in;
    }
    @media print {
        .noprint {
            display: none !important;
        }
        .next-padding {
            margin: {{ $settings->labels_pmargin_top }}in {{ $settings->labels_pmargin_right }}in {{ $settings->labels_pmargin_bottom }}in {{ $settings->labels_pmargin_left }}in;
            font-size: 0;
        }
    }
    @media screen {
        .label {
            outline: .02in black solid; /* outline doesn't occupy space like border does */
        }
        .noprint {
            font-size: 13px;
            padding-bottom: 15px;
        }
    }
    @if ($snipeSettings->custom_css)
        {!! $snipeSettings->show_custom_css() !!}
    @endif
</style>

@foreach ($assets as $asset)
    <?php $count++; ?>
    <div class="container">
       <div class="row">
            <div class="col-12">
                @if ($settings->label_logo)
                <div class="label-logo">
                    <img class="label-logo" src="{{ Storage::disk('public')->url('').e($snipeSettings->label_logo) }}">
                </div>
            @endif
            </div>
       </div>
        <div class="row">
            <div class="col-12">
                @if ($settings->qr_code=='1')
                <div class="qr_img">
                <img src="{{ config('app.url') }}/hardware/{{ $asset->id }}/qr_code" class="qr_img">
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="text">
            @if (($asset->asset_tag!='1'))
                <div class="pull-left">
                    Host Name: {{ $asset->asset_tag }}
                </div>
            @endif
                </div>
            </div>
        </div>
    </div>

    @if (($count % $settings->labels_per_page == 0) && $count!=count($assets))
    <div class="page-break"></div>
    <div class="next-padding">&nbsp;</div>
    @endif

@endforeach


</body>
</html>
