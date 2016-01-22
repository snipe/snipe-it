<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Labels</title>
    <link href="labels.css" rel="stylesheet" type="text/css" >
    <style>
    body {
        width: 8.5in;
        margin: 0in .1875in;
        }
    .label{
        /* Avery 5160 labels -- CSS and HTML by MM at Boulder Information Services */
        width: 3.5in; /* plus .6 inches from padding */
        height: 1.1in; /* plus .125 inches from padding */
        padding: .125in .3in 0;
        margin-right: .125in; /* the gutter */

        float: left;

        overflow: hidden;

        outline: none; /* outline doesn't occupy space like border does */
        }
    .page-break  {
        clear: left;
        display:block;
        page-break-after:always;
        }
	.qr_img {
		    float: left;
	    }

	 .qr_text {
		    margin-left: 5px;
		    float: left;
		    font-family: arial, helvetica, sans-serif;
		    font-size: 14px;
	    }
    </style>

</head>
<body>


@foreach ($assets as $asset)
	<?php $count++; ?>
	<div class="label">
		<div class="qr_img"><img src="./{{{ $asset->id }}}/qr_code"></div>
		<div class="qr_text">
			@if ($settings->qr_text!='')
				{{{ $settings->qr_text }}}
				<br><br>
			@endif
            		@if ($asset->name!='')
                		<b>N: {{ $asset->name }}</b>
                		<br>
            		@endif
			@if ($asset->asset_tag!='')
				T: {{{ $asset->asset_tag }}}
				<br>
			@endif
			@if ($asset->serial!='')
				S: {{{ $asset->serial }}}
				<br>
			@endif

		</div>
	</div>
	@if ($count % 18 == 0)
		<div class="page-break"></div>

	@endif

@endforeach





</body>
</html>
