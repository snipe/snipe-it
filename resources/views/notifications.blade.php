@if ($errors->any())
<div class="col-md-12">
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong>{{ trans('general.notification_error') }}</strong>
         {{ trans('general.notification_error_hint') }}
    </div>
</div>

@endif


@if ($message = Session::get('status'))
    <div class="col-md-12">
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fas fa-check faa-pulse animated"></i>
            <strong>{{ trans('general.notification_success') }} </strong>
            {{ $message }}
        </div>
    </div>
@endif


@if ($message = Session::get('success'))
<div class="col-md-12">
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check faa-pulse animated"></i>
        <strong>{{ trans('general.notification_success') }} </strong>
        {{ $message }}
    </div>
</div>
@endif


@if ($assets = Session::get('assets'))
    @foreach ($assets as $asset)
        <div class="col-md-12">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-info-circle faa-pulse animated"></i>
                <strong>{{ trans('general.asset_information') }} </strong>
                <ul>
                    @isset ($asset->model->name)
                        <li><b>{{ trans('general.model_name') }} </b> {{ $asset->model->name }}</li>
                    @endisset
                    @isset ($asset->name)
                        <li><b>{{ trans('general.asset_name') }} </b> {{ $asset->model->name }}</li>
                    @endisset
                    <li><b>{{ trans('general.asset_tag') }}</b> {{ $asset->asset_tag }}</li>
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
                <i class="fas fa-info-circle faa-pulse animated"></i>
                <strong>{{ trans('general.consumable_information') }} </strong>
                <ul><li><b>{{ trans('general.consumable_name') }}</b> {{ $consumable->name }}</li></ul>
            </div>
        </div>
    @endforeach
@endif


@if ($accessories = Session::get('accessories'))
    @foreach ($accessories as $accessory)
        <div class="col-md-12">
            <div class="alert alert-info fade in">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-info-circle faa-pulse animated"></i>
                <strong>{{ trans('general.accessory_information') }} </strong>
                <ul><li><b>{{ trans('general.accessory_name') }}</b> {{ $accessory->name }}</li></ul>
            </div>
        </div>
    @endforeach
@endif


@if ($message = Session::get('error'))
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong>{{ trans('general.error') }} </strong>
        {{ $message }}
    </div>
</div>
@endif


@if ($messages = Session::get('error_messages'))
@foreach ($messages as $message)        
<div class="col-md-12">
    <div class="alert alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong>{{ trans('general.notification_error') }} </strong>
        {{ $message }}
    </div>
</div>
@endforeach
@endif


@if ($message = Session::get('warning'))
<div class="col-md-12">
    <div class="alert alert-warning fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
        <strong>{{ trans('general.notification_warning') }} </strong>
        {{ $message }}
    </div>
</div>
@endif


@if ($message = Session::get('info'))
<div class="col-md-12">
    <div class="alert alert-info fade in">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-info-circle faa-pulse animated"></i>
        <strong>{{ trans('general.notification_info') }} </strong>
        {{ $message }}
    </div>
</div>
@endif
