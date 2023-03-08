<div class="form-group">
    <div class="col-md-3">
        <label{!!  $errors->has($logoVariable) ? ' class="alert-msg"' : '' !!} for="{{ $logoVariable }}">{{ ucwords(str_replace('_', ' ', $logoVariable)) }}</label>
    </div>
    <div class="col-md-9">
        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="{{ $logoVariable }}" class="js-uploadFile" id="{{ $logoId }}"
                   data-maxsize="{{ $maxSize ?? Helper::file_upload_max_size() }}"
                   style="display:none; max-width: 90%">
        </label>

        <span class='label label-default' id="{{ $logoId }}-info"></span>

        {!! $errors->first($logoVariable, '<span class="alert-msg">:message</span>') !!}


        <p class="help-block" style="!important" id="{{ $logoId }}-status">
            {{ $helpBlock }}
        </p>

        @if (config('app.lock_passwords')===true)
            <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
        @endif
    </div>

    <div class="col-md-9 col-md-offset-3">
        <div class="col-md-6 no-padding">

            @if (($setting->$logoVariable!='') && (Storage::disk('public')->exists(e($snipeSettings->$logoVariable))))

            <a href="{{ Storage::disk('public')->url(e($snipeSettings->$logoVariable)) }}" {{ ($logoVariable!='favicon') ? ' data-toggle="lightbox"' : '' }}>
                <img id="{{ $logoId }}-imagePreview" style="max-height: 80px;" alt="" src="{{ Storage::disk('public')->url(e($snipeSettings->$logoVariable)) }}">
            </a>

            <label for="{{ $logoClearVariable }}" style="font-weight: normal">
                {{ Form::checkbox($logoClearVariable, '1', Request::old($logoClearVariable),array('class' => 'minimal')) }}
                Remove current {{ ucwords(str_replace('_', ' ', $logoVariable)) }} image
            </label>
           @else
                <img id="{{ $logoId }}-imagePreview" style="max-height: 80px;" alt="" src="{{ Storage::disk('public')->url(e($snipeSettings->$logoVariable)) }}">
           @endif

        </div>

    </div>



</div>







