<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Labels</title>

</head>
<body>


<!-- now use grid or table to layout mulitples -->

<style>
    html {
		--measurement-unit: 1in;
		--page-width: calc( {{ $settings->labels_pagewidth }} * var(--measurement-unit));
		--page-height: calc( {{ $settings->labels_pageheight }} * var(--measurement-unit));
		--page-margin-top: calc( {{ $settings->labels_pmargin_top }} * var(--measurement-unit));
		--page-margin-right: calc( {{ $settings->labels_pmargin_right }} * var(--measurement-unit));
		--page-margin-bottom: calc( {{ $settings->labels_pmargin_bottom }} * var(--measurement-unit));
		--page-margin-left: calc( {{ $settings->labels_pmargin_left }} * var(--measurement-unit));
		--label-width: calc( {{ $settings->labels_width }} * var(--measurement-unit));
		--label-height: calc( {{ $settings->labels_height }} * var(--measurement-unit));
		--label-padding-top: calc(0.02 * var(--measurement-unit));
		--label-padding-right: calc( 0.02 * var(--measurement-unit));
		--label-padding-bottom: calc( 0.02 * var(--measurement-unit));
		--label-padding-left: calc( 0.02 * var(--measurement-unit));
		--barcode-width: min(80%, 250px);
		--barcode-height: 18px;
        --label-logo-height: 0.5in;
	}
    body {
        font-family: arial, helvetica, sans-serif;
        width: var(--page-width);
        height: var(--page-height);
        margin: var(--page-margin-top) var(--page-margin-right) var(--page-margin-bottom) var(--page-margin-left);
		font-size: {{ $settings->labels_fontsize }}pt;
		display: grid;
    }
    .label {
        width: var(--label-width);
        height: var(--label-height);
		box-sizing: border-box;
		padding: var(--label-padding-top) var(--label-padding-right) var(--label-padding-bottom) var(--label-padding-left);
        overflow: hidden;


    }
	.label-container {
		width: 100%;
		height: 100%;
		overflow: hidden !important;
	}
	.row {
		display: flex;
		flex-wrap: nowrap;
		height: calc(var(--label-height) - var(--label-padding-top) - var(--label-padding-bottom) - var(--barcode-height));
		overflow: hidden;
	}
    .page-break  {
        page-break-after:always;
    }
    div.qr_img {
		height: 100%;

    }
    img.qr_img {
		height: 100%;

    }
    img.barcode {
        display:block;
        margin: 0 auto;
        width: var(--barcode-width);
    }
    div.label-logo {
        float: right;
        display: inline-block;
    }
    img.label-logo {
        height: var(--label-logo-height);
    }
    .qr_text {
        font-family: arial, helvetica, sans-serif;
        font-size: {{$settings->labels_fontsize}}pt; 
        overflow: hidden !important;
        word-wrap: break-word;
        word-break: break-all;
		flex-grow: 1;
    }
    div.barcode_container {
        width: 100%;
		height: var(--barcode-height);
        display: inline;
    }
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
    <div class="label">
		<div class="label-container">
			<div class="row">
				@if ($settings->qr_code=='1')
					<div class="qr_img">
						<img src="{{ config('app.url') }}/hardware/{{ $asset->id }}/qr_code" class="qr_img">
					</div>
				@endif

				<div class="qr_text">
					@if ($settings->qr_text!='')
						<div class="pull-left">
							<strong>{{ $settings->qr_text }}</strong>
							<br>
						</div>
					@endif
					@if (($settings->labels_display_company_name=='1') && ($asset->company))
						<div class="pull-left">
							C: {{ $asset->company->name }}
						</div>
					@endif
					@if (($settings->labels_display_name=='1') && ($asset->name!=''))
						<div class="pull-left">
							N: {{ $asset->name }}
						</div>
					@endif
					@if (($settings->labels_display_tag=='1') && ($asset->asset_tag!=''))
						<div class="pull-left">
							T: {{ $asset->asset_tag }}
						</div>
					@endif
					@if (($settings->labels_display_serial=='1') && ($asset->serial!=''))
						<div class="pull-left">
							S: {{ $asset->serial }}
						</div>
					@endif
					@if (($settings->labels_display_model=='1') && ($asset->model->name!=''))
						<div class="pull-left">
							M: {{ $asset->model->name }} {{ $asset->model->model_number }}
						</div>
					@endif

				</div> <!-- end qr_text -->
				
				@if ($settings->label_logo)
					<div class="label-logo">
						<img class="label-logo" src="{{ Storage::disk('public')->url('').e($snipeSettings->label_logo) }}">
					</div>
				@endif
			</div> <!-- end row -->
			
			@if ((($settings->alt_barcode_enabled=='1') && $settings->alt_barcode!=''))
				<div class="barcode_container">
					<img src="{{ config('app.url') }}/hardware/{{ $asset->id }}/barcode" class="barcode">
				</div>
			@endif
		
		</div> <!-- end container -->

    </div> <!-- end label -->

    @if (($count % $settings->labels_per_page == 0) && $count!=count($assets))
        <div class="page-break"></div>
        <div class="next-padding">&nbsp;</div>
    @endif

@endforeach


</body>
</html>
