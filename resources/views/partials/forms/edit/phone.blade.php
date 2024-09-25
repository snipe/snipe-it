<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
    {{ Form::label('phone', trans('admin/suppliers/table.phone'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{Form::text('phone', old('phone', $item->phone), array('class' => 'form-control', 'aria-label'=>'phone')) }}
        <x-form-error name="phone" />
    </div>
</div>
