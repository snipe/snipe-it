<div class="form-group {{ $errors->has($logoVariable) ? 'has-error' : '' }}">
    <label class="col-md-3" for="{{ $logoVariable }}">
            {{ Form::label($logoVariable, $logoLabel) }}</label>

    <div class="col-md-9">
        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="{{ $logoVariable }}" class="js-uploadFile" id="{{ $logoId }}"
                data-maxsize="{{ $maxSize ?? \App\Helpers\Helper::file_upload_max_size() }}"
                accept="{{ $allowedTypes ?? 'image/gif,image/jpeg,image/png,image/svg'}}" style="display:none; max-width: 90%">
        </label>
        <span class='label label-default' id="{{ $logoId }}-info"></span>

        <p class="help-block" id="{{ $logoId }}-status">
            {{ $helpBlock }}
        </p>
        {!! $errors->first($logoVariable, '<span class="alert-msg">:message</span>') !!}

    </div>
    <div class="col-md-9 col-md-offset-3">
        <img id="{{ $logoId }}-imagePreview" style="max-width: 500px; max-height: 50px">
    </div>

    @if ($setting->$logoVariable!='')
    <div class="col-md-9 col-md-offset-3">
        {{ Form::checkbox($logoClearVariable, '1', Request::old($logoClearVariable),array('class' => 'minimal')) }} Remove current image
    </div>
    @endif
</div>
