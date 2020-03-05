<!-- Company -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select name="{{ $fieldname }}" class="form-control select2" style="width: 100%" required="true">
          <option value="" selected></option>
          @foreach($states::$to_states_manual as $state)
            <option value="{{ $state }}">{{ trans('admin/inventory/general.'.$state)}}</option>
          @endforeach  
      </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
