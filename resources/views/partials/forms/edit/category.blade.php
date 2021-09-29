<!-- Category -->
<div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
    <label for="category_id" class="col-md-3 control-label">{{ trans('general.category') }}</label>
    <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'category_id')) ? ' required' : '' }}">
        {{ Form::select('category_id', $category_list , old('category_id', $item->category_id), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('category_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
