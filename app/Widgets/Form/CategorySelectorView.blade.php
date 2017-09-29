<?php extract($data); ?>
<!-- Category -->
<div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
    <label for="category_id" class="col-md-3 control-label">{{ trans('general.category') }}</label>
    <div class="col-md-7 col-sm-12{{  $required ? ' required' : '' }}">
        {{ Form::select('category_id', $category_list , $value, array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('category_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>