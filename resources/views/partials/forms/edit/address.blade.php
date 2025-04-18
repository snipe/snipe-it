<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
    <label for="address" class="col-md-3 control-label">{{ trans('general.address') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="address" maxlength="191" name="address" type="text" id="address" value="{{ old('address', $item->address) }}">
        {!! $errors->first('address', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
    <label class="sr-only " for="address2">{{  trans('general.address')  }}</label>
    <div class="col-md-7 col-md-offset-3">
        <input class="form-control" aria-label="address2" maxlength="191" name="address2" type="text" value="{{ old('address2', $item->address2) }}">
        {!! $errors->first('address2', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
    <label for="city" class="col-md-3 control-label">{{ trans('general.city') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="city" maxlength="191" name="city" type="text" id="city" value="{{ old('city', $item->city) }}">
        {!! $errors->first('city', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
    <label for="state" class="col-md-3 control-label">{{ trans('general.state') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="state" maxlength="191" name="state" type="text" id="state" value="{{ old('state', $item->state) }}">
        {!! $errors->first('state', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}

    </div>
</div>

<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
    <label for="country" class="col-md-3 control-label">{{ trans('general.country') }}</label>
    <div class="col-md-7">
    {!! Form::countries('country', old('country', $item->country), 'select2') !!}
        <p class="help-block">{{ trans('general.countries_manually_entered_help') }}</p>
        {!! $errors->first('country', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
    <label for="zip" class="col-md-3 control-label" maxlength="10">{{ trans('general.zip') }}</label>
    <div class="col-md-7">
        <input class="form-control" name="zip" type="text" id="zip" value="{{ old('zip', $item->zip) }}">
        {!! $errors->first('zip', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ ($errors->has('latitude') || $errors->has('longitude')) ? ' has-error' : '' }}">
    <label for="latitude" class="col-md-3 control-label" maxlength="10">{{ trans('general.coordinates') }}</label>
    <div class="col-md-2">
        <input class="form-control" name="latitude" type="number" min="-90" max="90" placeholder="0.00000" pattern="-?\d{1,3}\.\d+" id="latitude" value="{{ old('latitude', $item->latitude) }}">
        {!! $errors->first('latitude', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-2">
        <input class="form-control" name="longitude" type="number" min="-180" max="180" placeholder="0.00000" pattern="-?\d{1,3}\.\d+" id="longitude" value="{{ old('longitude', $item->longitude) }}">
        {!! $errors->first('longitude', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-1">
      <a href="javascript:getCurrentLocation()" title="{{ trans('general.my_location') }}"><i class="fas fa-globe" aria-hidden="true"></i></a>
    </div>
</div>
<script type="text/javascript">
function getCurrentLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(pos) {
      $('#latitude').val(pos.coords.latitude);
      $('#longitude').val(pos.coords.longitude);
    });
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}
</script>

