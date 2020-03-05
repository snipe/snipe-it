<!-- Date Time fix -->
<div class="form-group {{ $errors->has('occurred_at') ? ' has-error' : '' }}">
    <label for="occurred_at" class="col-md-3 control-label">
        {{ trans('admin/inventory/general.occurred_at') }}
    </label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'occurred_at')) ? ' required' : '' }}">
        <input class="form-control" type="text" name="occurred_at" id="occurred_at" value="{{ Input::old('occurred_at', (isset($item)) ? $item->occurred_at : date_format(new \Carbon(), 'Y-m-d H:i:s')) }}" />
        {!! $errors->first('occurred_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>
