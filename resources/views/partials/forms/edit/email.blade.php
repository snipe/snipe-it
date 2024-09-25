<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    {{ Form::label('email', trans('admin/suppliers/table.email'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{ Form::text('email', old('email', $item->email), array('class' => 'form-control', 'type' => 'email')) }}
        <x-form-error name="email" />
    </div>
</div>
