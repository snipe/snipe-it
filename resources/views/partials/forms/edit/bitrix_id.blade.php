<!-- bitrix_id -->
<div class="form-group {{ $errors->has('bitrix_id') ? ' has-error' : '' }}">
    <label for="bitrix_id" class="col-md-3 control-label">Bitrix Id</label>
    <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'name')) ? ' required' : '' }}">
        <input class="form-control" type="number" min="0" max="10000" name="bitrix_id" aria-label="bitrix_id" id="bitrix_id" value="{{ Input::old('bitrix_id', $item->bitrix_id) }}" />
        {!! $errors->first('bitrix_id', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>