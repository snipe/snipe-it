<div class="form-group {{ $errors->has($logoVariable) ? 'has-error' : '' }}">
    <div class="col-md-3">
        <strong>{{ $logoLabel }}</strong>
    </div>

        @if (($setting->$logoVariable!='') && (Storage::disk('public')->exists(e($snipeSettings->$logoVariable))))
        <div class="col-md-9">

            <label for="{{ $logoClearVariable }}" style="font-weight: normal">
                {{ Form::checkbox($logoClearVariable, '1', Request::old($logoClearVariable),array('class' => 'minimal')) }}
                Remove current {{ str_replace('_', ' ', $logoVariable) }} image

            </label>


                <br>
                @if ($logoVariable!='favicon')
                    <a href="{{ Storage::disk('public')->url(e($snipeSettings->$logoVariable)) }}" data-toggle="lightbox">
                        <img style="max-height: 60px; padding-top: 10px; padding-bottom: 10px; " alt="" src="{{ Storage::disk('public')->url(e($snipeSettings->$logoVariable)) }}">
                    </a>
                @else
                    <img style="max-height: 50px; padding-top: 10px; padding-bottom: 10px; " alt="" src="{{ Storage::disk('public')->url(e($snipeSettings->$logoVariable)) }}">
                @endif

        </div>
        <div class="col-md-9 col-md-offset-3">
            @else
                <div class="col-md-9">
        @endif




        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="{{ $logoVariable }}" class="js-uploadFile" id="{{ $logoId }}"
                data-maxsize="{{ $maxSize ?? Helper::file_upload_max_size() }}"
                accept="{{ $allowedTypes ?? 'image/gif,image/jpeg,image/png,image/svg,image/svg+xml'}}" style="display:none; max-width: 90%">
        </label>
        <span class='label label-default' id="{{ $logoId }}-info"></span>

        <p class="help-block" id="{{ $logoId }}-status">
            {{ $helpBlock }}
        </p>

        @if (config('app.lock_passwords')===true)
            <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
        @endif
        {!! $errors->first($logoVariable, '<span class="alert-msg">:message</span>') !!}

    </div>
    <div class="col-md-9 col-md-offset-3">
        <img id="{{ $logoId }}-imagePreview" style="max-width: 500px; max-height: 50px;">
    </div>


</div>
