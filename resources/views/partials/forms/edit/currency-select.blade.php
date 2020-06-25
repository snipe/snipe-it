<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-no-ajax" data-placeholder="Выберите валюту" name="{{ $fieldname }}" style="width: 100%" id="currency_select" aria-label="{{ $fieldname }}">
{{--            <option value="341" selected="selected" role="option" aria-selected="true"  role="option">руб</option>--}}
{{--            <option value="342" role="option" aria-selected="false"  role="option">usd</option>--}}
{{--            <option value="343"  role="option" aria-selected="false"  role="option">eur</option>--}}
            <option value="341" selected="selected">руб</option>
            <option value="342">usd</option>
            <option value="343">eur</option>
        </select>
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

</div>
