<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="legal_persons" data-placeholder="Выберите юр. лицо" name="{{ $fieldname }}" style="width: 100%" id="legal_person_select" aria-label="{{ $fieldname }}">
            @if ($legal_person = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $legal_person_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\LegalPerson::find($legal_person_id)) ? \App\Models\LegalPerson::find($legal_person_id)->name : '' }}
                </option>
            @else
                <option value=""  role="option">Выберите юр. лицо</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

</div>
