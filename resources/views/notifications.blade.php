@if ($errors->any())
<div class="col-md-12">
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>Error: </strong>
         Please check the form below for errors
    </div>
</div>

@endif


@if ($message = Session::get('status'))
    <div class="col-md-12">
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check faa-pulse animated"></i>
            <strong>Success: </strong>
            {{ $message }}
        </div>
    </div>
@endif


@if ($message = Session::get('success'))
<div class="col-md-12">
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-check faa-pulse animated"></i>
        <strong>Success: </strong>
        {{ $message }}
    </div>
</div>
@endif


@if ($assets = Session::get('assets'))
    @foreach ($assets as $asset)
        <div class="col-md-12">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-info-circle faa-pulse animated"></i>
                <strong>Asset Information: </strong>
                <ul>
                    @isset ($asset->model->name)
                        <li><b>Model Name: </b> {{ $asset->model->name }}</li>
                    @endisset
                    @isset ($asset->name)
                        <li><b>Asset Name: </b> {{ $asset->model->name }}</li>
                    @endisset
                    <li><b>Asset Tag:</b> {{ $asset->asset_tag }}</li>
                </ul>

            </div>
        </div>
    @endforeach
@endif


@if ($consumables = Session::get('consumables'))
    @foreach ($consumables as $consumable)
        <div class="col-md-12">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-info-circle faa-pulse animated"></i>
                <strong>Consumable Information: </strong>
                <ul><li><b>Name:</b> {{ $consumable->name }}</li></ul>
            </div>
        </div>
    @endforeach
@endif


@if ($accessories = Session::get('accessories'))
    @foreach ($accessories as $accessory)
        <div class="col-md-12">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-info-circle faa-pulse animated"></i>
                <strong>Accessory Information: </strong>
                <ul><li><b>Name:</b> {{ $accessory->name }}</li></ul>
            </div>
        </div>
    @endforeach
@endif


@if ($message = Session::get('error'))
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>Error: </strong>
        {{ $message }}
    </div>
</div>
@endif


@if ($messages = Session::get('error_messages'))
@foreach ($messages as $message)        
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle faa-pulse animated"></i>
        <strong>Error: </strong>
        {{ $message }}
    </div>
</div>
@endforeach
@endif


@if ($message = Session::get('warning'))
<div class="col-md-12">
    <div class="alert alert-warning fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-warning faa-pulse animated"></i>
        <strong>Warning: </strong>
        {{ $message }}
    </div>
</div>
@endif


@if ($message = Session::get('info'))
<div class="col-md-12">
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-info-circle faa-pulse animated"></i>
        <strong>Info: </strong>
        {{ $message }}
    </div>
</div>
@endif
